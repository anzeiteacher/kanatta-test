<?php
class BaseControllerTest extends ControllerTestCase {
    public $fixtures = array('app.attachment', 'app.setting', 'app.project',
                             'app.user', 'app.session', 'app.category', 'app.report');

    public function testIndex()
    {
        $this->testAction('/');
        $this->assertEqual(2, $this->vars['pickup_pj']['Project']['id']);
        $pjs = $this->vars['pjs'];
        $pj_ids = array();
        foreach($pjs as $p){
            $pj_ids[] = $p['Project']['id'];
        }
        $this->assertEqual(array('10', '6', '11', '8', '9', '7', '4'), $pj_ids);
    }

}