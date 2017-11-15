<?php
class ContactControllerTest extends ControllerTestCase {
    public $fixtures = array('app.attachment', 'app.setting');

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->generate('Contact', array(
            'components' => array(
                'Mail' => array('send_mail')
            )
        ));
        $this->mock->Mail
            ->expects($this->any())
            ->method('send_mail')
            ->will($this->returnValue(true));
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->mock);
    }

    public function testIndexGet()
    {
        $this->testAction('/contact', array('method' => 'get'));
        $this->assertTextContains('お問合せ', $this->vars['title']);
    }

    public function testIndexPostError()
    {
        $data = array(
            'Contact' => array(
                'name' => 'taro',
                'mail' => 'bad email address',
                'content' => 'Hello'
            )
        );
        $result = $this->testAction('/contact', array('data' => $data));
        $this->assertEqual(false, $result);
    }

    public function testIndexPostSuccess()
    {
        $data = array(
            'Contact' => array(
                'name' => 'taro',
                'mail' => 'system@logicky.com',
                'content' => 'Hello'
            )
        );
        $result = $this->testAction('/contact', array('data' => $data));
        $this->assertEqual(true, $result);
    }

}