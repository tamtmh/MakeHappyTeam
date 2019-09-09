<?php
App::uses('ClassRegistry', 'Utility');

class NotificationsControllerTest extends ControllerTestCase {
    public $fixtures = array('app.notification', 'app.user');

    public function setUp() {
        parent::setUp();
        $this->TNotification = ClassRegistry::init('TNotification');
    }

    /**
     *
     * Test get data notifications
     *
     * @param    array $userInfo infomation of user login
     * @param    array $expected data expected
     * @dataProvider dataNotificationDataProvider
     */
    public function testIndex($userInfo, $expected) {
        //Mock up login session
        CakeSession::write('Auth.User', $userInfo);

        $this->testAction('/notifications/index');
        $this->assertEquals($expected, $this->vars['data']);
        CakeSession::delete('Auth.User');
    }

    public function dataNotificationDataProvider() {
        return array(
            //case 1: get data notification of user login => success
            array(
                array(
                    'username' => 'admin',
                    'id' => 2,
                ),  //data user login
                array(
                    array(
                        'TNotification' => array(
                            'id' => 3,
                            'user_id' => 2,
                            'from_id' => 1,
                            'read' => 2,
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-17 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => '1',
                            'username' => 'pvtamh2bg',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 2,
                            'user_id' => 2,
                            'from_id' => 3,
                            'read' => 1,
                            'content' => '<a href="/reports/create/1">Thaovtp requires you create detail content of reports</a>',
                            'created' => '2019-06-16 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => '3',
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 1,
                            'user_id' => 2,
                            'from_id' => 3,
                            'read' => 0,
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-15 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => '3',
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    )
                )   //data expected
            )
        );
    }
}