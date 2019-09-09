<?php
App::uses('TNotificationTest', 'Model');
App::uses('ClassRegistry', 'Utility');

class TNotificationTest extends CakeTestCase {
    public $fixtures = array('app.notification', 'app.user');

    public function setUp() {
        parent::setUp();
        $this->TNotification = ClassRegistry::init('TNotification');
    }

    /**
     *
     * Test get the list limit of notification by user id
     *
     * @param    int $id is id of user
     * @param    array $expected data expected
     * @dataProvider dataListNotificationDataProvider
     */
    public function testGetLimitNotificationByUserID($userID, $expected) {
        $result = $this->TNotification->getLimitByUserID($userID);
        $this->assertEquals($expected, $result);
    }

    public function dataListNotificationDataProvider() {
        return array(
            //case 1: get the list limit of notification by user id => success
            array(
                2,  //user_id
                array(
                    array(
                        'TNotification' => array(
                            'id' => 3,
                            'user_id' => 2,
                            'from_id' => 1,
                            'read' => '2',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-17 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => 1,
                            'username' => 'pvtamh2bg',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 2,
                            'user_id' => 2,
                            'from_id' => 3,
                            'read' => '1',
                            'content' => '<a href="/reports/create/1">Thaovtp requires you create detail content of reports</a>',
                            'created' => '2019-06-16 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => 3,
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 1,
                            'user_id' => 2,
                            'from_id' => 3,
                            'read' => '0',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-15 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => 3,
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    )
                )  //data expected
            )
        );
    }
}