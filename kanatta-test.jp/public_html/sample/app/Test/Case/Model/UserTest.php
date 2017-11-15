<?php
class UserTest extends CakeTestCase {
    public $fixtures = array('app.attachment', 'app.user');

    public function setUp()
    {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }

    public function testGetUserFromEmail()
    {
        $email = 'system@logicky.com';
        $user = $this->User->get_user_from_email($email);
        $this->assertEqual(1, $user['User']['id']);
    }

    public function tearDown() {
        unset($this->User);
        parent::tearDown();
    }
}