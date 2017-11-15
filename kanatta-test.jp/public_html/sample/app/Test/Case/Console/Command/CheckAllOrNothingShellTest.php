<?php
App::uses('ConsoleOutput', 'Console');
App::uses('AppShell', 'Console/Command');
App::uses('CheckAllOrNothingShell', 'Console/Command');

class CheckAllOrNothingShellTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.user', 'app.project', 'app.backed_project', 'app.setting');

    public $target;
    public function setUp() {
        parent::setUp();
        $output = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $error = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $in = $this->getMock('ConsoleInput', array(), array(), '', false);
        $this->target = new CheckAllOrNothingShell($output, $error, $in);
        $this->target->startup();
        $this->BackedProject = ClassRegistry::init('BackedProject');
        $this->Project = ClassRegistry::init('Project');
    }

    public function tearDown() {
        unset($this->BackedProject);
        unset($this->Project);
        unset($this->target);
        parent::tearDown();
    }

    public function testSuccess(){
        $result = $this->_init(550000);
        $this->assertEqual(true, $result);
        $pj_id = 7;
        $pj = $this->Project->findById($pj_id);
        $this->assertEqual(1, $pj['Project']['active']);

        $this->target->main();

        $bps = $this->BackedProject->get_by_pj_id($pj_id, false);
        $this->assertEqual(2, count($bps));
        $this->assertEqual(STATUS_KAKUTEI, $bps[0]['BackedProject']['status']);
        $this->assertEqual(STATUS_KAKUTEI, $bps[1]['BackedProject']['status']);
        $pj = $this->Project->findById($pj_id);
        $this->assertEqual(0, $pj['Project']['active']);
    }

    public function testFail()
    {
        $result = $this->_init(50000);
        $this->assertEqual(true, $result);
        $pj_id = 7;
        $pj = $this->Project->findById($pj_id);
        $this->assertEqual(1, $pj['Project']['active']);

        $this->target->main();

        $bps = $this->BackedProject->get_by_pj_id($pj_id, false);
        $this->assertEqual(2, count($bps));
        $this->assertEqual(STATUS_FAIL, $bps[0]['BackedProject']['status']);
        $this->assertEqual(STATUS_FAIL, $bps[1]['BackedProject']['status']);
        $pj = $this->Project->findById($pj_id);
        $this->assertEqual(0, $pj['Project']['active']);
    }

    /**
     * 2人が支援する
     */
    private function _init($amount)
    {
        $pj_id = 7;
        $bl_id = 4;
        $user_id1 = 2;
        $user_id2 = 4;
        if($this->_back($user_id1, $pj_id, $amount, $bl_id)){
            if($this->_back($user_id2, $pj_id, $amount, $bl_id)){
                return true;
            }
        }
        return false;
    }

    private function _back($user_id, $pj_id, $amount, $bl_id)
    {
        $data = array(
            'user_id' => $user_id,
            'order_id' => $this->BackedProject->get_order_id($pj_id, $user_id),
            'amount' => $amount,
            'pj_id' => $pj_id,
            'bl_id'=> $bl_id
        );
        if(!$this->target->Card->_test_save_member_and_card($user_id)) return false;
        $pj = $this->Project->findById($pj_id);
        if(!$this->_save_pj($data, $pj)) return false;
        list($status, $out) = $this->target->Card->pay_for_all_or_nothing($data);
        if(!$status) return false;
        if(!$this->_save_bp($data, $out)) return false;
        return true;
    }

    private function _save_bp($data, $out)
    {
        $data['comment'] = 'test';
        $bp = $this->BackedProject->_set_pay_result_for_allornothing_or_allin($out, $data, ALL_OR_NOTHING);
        $this->BackedProject->create();
        if($this->BackedProject->save($bp)) return true;
        return false;
    }

    private function _save_pj($bp, $pj)
    {
        if($this->Project->add_backed_to_project($bp, $pj)) return true;
        return false;
    }
}