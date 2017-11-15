<?php
App::uses('ConsoleOutput', 'Console');
App::uses('AppShell', 'Console/Command');
App::uses('CancelMonthlyShell', 'Console/Command');

class CancelMonthlyShellTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.user', 'app.project', 'app.backed_project', 'app.setting');

    public $target;
    public function setUp() {
        parent::setUp();
        $output = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $error = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $in = $this->getMock('ConsoleInput', array(), array(), '', false);
        $this->target = new CancelMonthlyShell($output, $error, $in);
        $this->target->startup();
        $this->BP = ClassRegistry::init('BackedProject');
        $this->PJ = ClassRegistry::init('Project');
    }

    public function tearDown() {
        unset($this->BP);
        unset($this->PJ);
        unset($this->target);
        parent::tearDown();
    }

    public function testMain(){
        $bps = $this->BP->get_target_of_gmo_cancel(30);
        $this->assertEqual(2, count($bps));
        $this->assertEqual(19, $bps[0]['BackedProject']['id']);
        $this->assertEqual(20, $bps[1]['BackedProject']['id']);
        $result = $this->_init();
        $this->assertEqual(true, $result);
        $result = $this->target->main();
        $this->assertEqual(true, $result);
        $bps = $this->BP->get_target_of_gmo_cancel(30);
        $this->assertEqual(0, count($bps));
        $bp = $this->BP->findById(19);
        $this->assertEqual(true, $bp['BackedProject']['gmo_cancelled_flag']);
        $bp = $this->BP->findById(20);
        $this->assertEqual(true, $bp['BackedProject']['gmo_cancelled_flag']);
    }

    //2人分GMOの自動売上登録する
    private function _init()
    {
        if($recurring_id = $this->_back(2)){
            if($this->_update_bp(19, $recurring_id)){
                if($recurring_id = $this->_back(4)){
                    if($this->_update_bp(20, $recurring_id)){
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function _back($user_id)
    {
        $pj_id = 11;
        $amount = 1000;
        $data = array(
            'pj_id' => $pj_id,
            'user_id' => $user_id,
            'order_id' => $this->BP->get_order_id($pj_id, $user_id),
            'amount' => $amount,
        );
        $result = $this->target->Card->pay_for_monthly($data);
        if($result[0]) return $data['order_id'];
        return null;
    }

    private function _update_bp($bp_id, $recurring_id)
    {
        $this->BP->id = $bp_id;
        if($this->BP->saveField('recurring_id', $recurring_id)){
            return true;
        }
        return false;
    }

}