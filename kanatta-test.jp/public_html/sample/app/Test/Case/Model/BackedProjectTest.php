<?php
class BackedProjectTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.backed_project', 'app.project', 'app.user');

    public function setUp()
    {
        parent::setUp();
        $this->BP = ClassRegistry::init('BackedProject');
    }

    public function tearDown() {
        unset($this->BP);
        parent::tearDown();
    }

    public function testGetMonthlyOfChargeDateInPast()
    {
        $bps = $this->BP->get_monthly_of_charge_date_in_past(10);
        $this->assertEqual(2, count($bps));
        $this->assertEqual(10, $bps[0]['BackedProject']['id']);
        $this->assertEqual(6, $bps[0]['Project']['id']);
        $this->assertEqual(2, $bps[1]['Backer']['id']);
        $this->assertEqual(3, $bps[1]['Owner']['id']);
    }

    public function testSaveMonthlyChargeResult()
    {
        $id = 10;
        $two_days_ago = date('Ymd', strtotime('-2days'));
        $thirty_days_later = date('Ymd', strtotime('+30days'));
        $result = array(
            'old_charge_date' => $two_days_ago,
            'next_charge_date' => $thirty_days_later,
            'charge_result' => CHARGE_OK
        );
        $this->BP->save_monthly_charge_result($id, $result);
        $bp = $this->BP->findById($id);
        $this->assertEqual(date('Y-m-d', strtotime($two_days_ago))
            , $bp['BackedProject']['old_charge_date']);
        $this->assertEqual(date('Y-m-d', strtotime($thirty_days_later))
            , $bp['BackedProject']['next_charge_date']);
        $this->assertEqual(CHARGE_OK, $bp['BackedProject']['charge_result']);
    }

    public function testGetMonthlyOfFailing()
    {
        $bps = $this->BP->get_monthly_of_failing(10);
        $this->assertEqual(5, count($bps));
        $this->assertEqual(22, $bps[0]['BackedProject']['id']);
        $this->assertEqual(21, $bps[1]['BackedProject']['id']);
        $this->assertEqual(18, $bps[2]['BackedProject']['id']);
        $this->assertEqual(17, $bps[3]['BackedProject']['id']);
        $this->assertEqual(15, $bps[4]['BackedProject']['id']);
        $this->assertEqual(6, $bps[0]['Project']['id']);
        $this->assertEqual('debug6@logicky.com', $bps[1]['Backer']['email']);
    }

    public function testStopMonthlyService()
    {
        $id = 17;
        $this->BP->stop_monthly_service($id);
        $bp = $this->BP->findById($id);
        $this->assertEqual(STATUS_STOP, $bp['BackedProject']['status']);
    }

    public function testSaveMonthlySuccessWhileFailing()
    {
        $id = 17;
        $bp = array('BackedProject' => array('id' => $id));
        $this->BP->save_monthly_success_while_failing($bp);
        $bp = $this->BP->findById($id);
        $this->assertEqual(CHARGE_OK, $bp['BackedProject']['charge_result']);
        $this->assertEqual(null, $bp['BackedProject']['old_charge_date_for_fail']);
    }

    public function testGmoCancelledFlagTrue()
    {
        $id = 17;
        $this->BP->gmo_cancelled_flag_true($id);
        $bp = $this->BP->findById($id);
        $this->assertEqual(true, $bp['BackedProject']['gmo_cancelled_flag']);
    }

    public function testGetTargetOfGmoCancel()
    {
        $bps = $this->BP->get_target_of_gmo_cancel(30);
        $this->assertEqual(2, count($bps));
        $this->assertEqual(STATUS_CANCEL, $bps[0]['BackedProject']['status']);
        $this->assertEqual(MONTHLY, $bps[0]['BackedProject']['pay_pattern']);
        $this->assertEqual(false, $bps[0]['BackedProject']['gmo_cancelled_flag']);
        $this->assertEqual(STATUS_CANCEL, $bps[1]['BackedProject']['status']);
        $this->assertEqual(MONTHLY, $bps[1]['BackedProject']['pay_pattern']);
        $this->assertEqual(false, $bps[1]['BackedProject']['gmo_cancelled_flag']);
    }

}