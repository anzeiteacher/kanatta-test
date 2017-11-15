<?php
App::uses('ConsoleOutput', 'Console');
App::uses('AppShell', 'Console/Command');
App::uses('UrlTask', 'Console/Command/Task');
App::uses('CaptureMonthlyShell', 'Console/Command');

class CaptureMonthlyShellTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.user', 'app.project', 'app.backed_project', 'app.setting');

    public $target;
    public function setUp() {
        parent::setUp();
        $output = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $error = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $in = $this->getMock('ConsoleInput', array(), array(), '', false);
        $this->target = new CaptureMonthlyShell($output, $error, $in);
        $this->target->loadTasks();
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

    public function testChkCertainPeriodPassed()
    {
        $bp['BackedProject']['old_charge_date'] = date('Y-m-d');
        $result = $this->target->_chk_certain_period_passed($bp);
        $this->assertEqual(false, $result);

        $bp['BackedProject']['old_charge_date'] = date('Y-m-d', strtotime('-13days'));
        $result = $this->target->_chk_certain_period_passed($bp);
        $this->assertEqual(false, $result);

        $bp['BackedProject']['old_charge_date'] = date('Y-m-d', strtotime('-14days'));
        $result = $this->target->_chk_certain_period_passed($bp);
        $this->assertEqual(true, $result);

        $bp['BackedProject']['old_charge_date'] = date('Y-m-d', strtotime('-30days'));
        $result = $this->target->_chk_certain_period_passed($bp);
        $this->assertEqual(true, $result);
    }

    public function testStopService()
    {
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(5, count($bps));
        $this->assertEqual(22, $bps[0]['BackedProject']['id']);
        $bp = $bps[0];
        $result = $this->target->_stop_service($bp);
        $this->assertEqual(true, $result);
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(4, count($bps));
        $this->assertEqual(21, $bps[0]['BackedProject']['id']);
    }

    public function testPay()
    {
        $user_id = 1;
        $bp = array(
            'BackedProject' => array('id' => 1, 'invest_amount' => 500),
            'Project' => array('id' => 1),
            'Backer' => array('id' => $user_id)
        );
        $result = $this->target->Card->_test_save_member_and_card($user_id);
        $this->assertEqual(true, $result);
        $result = $this->target->_pay($bp);
        $this->assertEqual(true, $result);
    }

    public function testSuccess()
    {
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(5, count($bps));
        $this->assertEqual(22, $bps[0]['BackedProject']['id']);
        $bp = $bps[0];
        $result = $this->target->_success($bp);
        $this->assertEqual(true, $result);
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(4, count($bps));
    }

    public function testMailSuccess()
    {
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(5, count($bps));
        $this->assertEqual(22, $bps[0]['BackedProject']['id']);
        $bp = $bps[0]; //bp_id => 10, user_id => 4
        $bp['Backer']['email'] = TEST_EMAIL;
        $result = $this->target->_mail_success($bp);
        $this->assertEqual(true, $result);
    }

    public function testFail()
    {
        $bp = $this->BP->findById(1);
        $this->assertEqual(null, $bp['BackedProject']['old_charge_date_for_fail']);
        $result = $this->target->_fail($bp);
        $this->assertEqual(true, $result);
        $bp = $this->BP->findById(1);
        $this->assertEqual(date('Y-m-d'), $bp['BackedProject']['old_charge_date_for_fail']);
    }

    public function testMailFail()
    {
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(5, count($bps));
        $this->assertEqual(22, $bps[0]['BackedProject']['id']);
        $bp = $bps[0]; //bp_id => 10, user_id => 4
        $bp['Backer']['email'] = TEST_EMAIL;
        $result = $this->target->_mail_fail($bp);
        $this->assertEqual(true, $result);
    }

}