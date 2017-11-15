<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProjectHelper', 'View/Helper');

class ProjectHelperTest extends CakeTestCase {
    public function setUp() {
        $Controller = new Controller();
        $View = new View($Controller);
        $this->Project = new ProjectHelper($View);
    }

    /**
     * 達成率取得
     */
    public function testGetBackedPer()
    {
        $pj = array(
            'Project' => array(
                'pay_pattern' => ALL_OR_NOTHING,
                'collected_amount' => 0,
                'goal_amount' => 200
            )
        );
        $result = $this->Project->get_backed_per($pj);
        $this->assertEqual(0, $result);

        $pj['Project']['collected_amount'] = 123;
        $result = $this->Project->get_backed_per($pj);
        $this->assertEqual(61, $result);

        $pj['Project']['pay_pattern'] = ALL_IN;
        $result = $this->Project->get_backed_per($pj);
        $this->assertEqual(61, $result);

        $pj['Project']['pay_pattern'] = MONTHLY;
        $pj['Project']['backers'] = 3;
        $pj['Project']['goal_backers'] = 10;
        $result = $this->Project->get_backed_per($pj);
        $this->assertEqual(30, $result);
    }

}