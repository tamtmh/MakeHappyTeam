<?php
App::uses('TUser', 'Model');
App::uses('ClassRegistry', 'Utility');

class TUserTest extends CakeTestCase {
    public $fixtures = array('app.user');

    public function setUp() {
        parent::setUp();
        $this->TUser = ClassRegistry::init('TUser');
    }
}