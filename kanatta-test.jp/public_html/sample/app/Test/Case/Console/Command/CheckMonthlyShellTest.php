<?php
App::uses('ConsoleOutput', 'Console');
App::uses('AppShell', 'Console/Command');
App::uses('UrlTask', 'Console/Command/Task');
App::uses('CheckMonthlyShell', 'Console/Command');

class CheckMonthlyShellTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.user', 'app.project', 'app.backed_project', 'app.setting');

    public $target;
    public function setUp() {
        parent::setUp();
        $output = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $error = $this->getMock('ConsoleOutput', array(), array(), '', false);
        $in = $this->getMock('ConsoleInput', array(), array(), '', false);
        $this->target = new CheckMonthlyShell($output, $error, $in);
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

    public function testMailSuccess(){
        $bps = $this->BP->get_monthly_of_charge_date_in_past(10);
        $bp = $bps[0]; //bp_id => 10, user_id => 4
        $result = array(
            'amount' => 1000,
            'next_charge_date' => date('Ymd', strtotime('+30days')),
            'old_charge_date' => date('Ymd', strtotime('-1day')),
            'err_code' => null,
            'err_info' => null,
            'charge_result' => CHARGE_OK
        );
        $result = $this->target->_mail($bp, $result);
        $this->assertEqual(true, $result);
    }

    public function testMailFail(){
        $bps = $this->BP->get_monthly_of_charge_date_in_past(10);
        $bp = $bps[0]; //bp_id => 10, user_id => 4
        $result = array(
            'amount' => 1000,
            'next_charge_date' => date('Ymd', strtotime('+30days')),
            'old_charge_date' => date('Ymd', strtotime('-1day')),
            'err_code' => 'error',
            'err_info' => 'error',
            'charge_result' => CHARGE_NG
        );
        $result = $this->target->_mail($bp, $result);
        $this->assertEqual(true, $result);
    }

}