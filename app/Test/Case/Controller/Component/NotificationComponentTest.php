<?php
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');
App::uses('NotificationComponent', 'Controller/Component');
App::uses('ClassRegistry', 'Utility');

// A fake controller to test against
class NotificationControllerTest extends Controller {
    public $components = array('Notification');
}

class NotificationComponentTest extends CakeTestCase {

    public $fixtures = array('app.notification', 'app.user');
    public $NotificationComponent = null;
    public $Controller = null;

    public function setUp() {
        parent::setUp();
        // Setup our component and fake test controller
        $Collection = new ComponentCollection();
        $this->NotificationComponent = new NotificationComponent($Collection);
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new NotificationControllerTest($CakeRequest, $CakeResponse);
        $this->NotificationComponent->startup($this->Controller);
        $this->TNotification = ClassRegistry::init('TNotification');
    }

    /**
     *
     * Test send notification method
     *
     * @param Array $data test case
     * @param boolean $status is result status of test case
     *
     * @dataProvider sendDataProvider
     */
    public function testSend($data, $status) {
        $beforeCountNoti = $this->TNotification->find('count');
        $recordNotiAddtion = count($data['to']);

        $result = $this->NotificationComponent->send($data['from'], $data['to'], $data['content']);

        $afterCountNoti = $this->TNotification->find('count');

        if ($status == 1) {
            $this->assertTrue($result);
            $this->assertEquals($afterCountNoti, $beforeCountNoti + $recordNotiAddtion);
        } else {
            $this->assertFalse($result);
            $this->assertNotEquals($afterCountNoti, $beforeCountNoti + $recordNotiAddtion);
        }

    }

    public function sendDataProvider() {
        return array(
            //case 1: message full -> success
            array(
                array(
                    'from' => 1,
                    'to' => array(2),
                    'content' => "This is test notification content"
                ),
                1    //status
            ),
            //case 2: missing from id -> fail
            array(
                array(
                    'from' => null,
                    'to' => array(2),
                    'content' => "This is test notification content"
                ),
                0
            )
        );
    }

    /**
     *
     * Test Get all notification of special user
     *
     * @param Int $uid ID special user
     * @param Array $expected result your expect
     * @param boolean $status is result status of test case
     *
     * @dataProvider checkDataProvider
     */
    public function testCheck($uid, $expected, $status) {
        $result = $this->NotificationComponent->check($uid);
        if ($status == 1) {
            $this->assertEquals($result, $expected);
        } else {
            $this->assertNotEquals($result, $expected);
        }
    }

    public function checkDataProvider() {
        return array(
            //case 1: data of user 2 in fixtures -> success
            array(
                2, // user id
                array(
                    array(
                        'TNotification' => array(
                            'id' => 3,
                            'user_id' => '2',
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
                            'user_id' => '2',
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
                            'user_id' => '2',
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
                ),
                1    //status
            ),

            //case 2: content diff -> fail
            array(
                1,
                array(
                    array(
                        'TNotification' => array(
                            'id' => 1,
                            'user_id' => '2',
                            'from_id' => 3,
                            'read' => '0',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-15 10:07:30'
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 2,
                            'user_id' => '2',
                            'from_id' => 3,
                            'read' => '1',
                            'content' => '<a href="/reports/create/1">Thaovtp requires you create detail content of reports</a>',
                            'created' => '2019-06-16 10:07:30'
                        )),
                    array(
                        'TNotification' => array(
                            'id' => 3,
                            'user_id' => '2',
                            'from_id' => 1,
                            'read' => '2',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-17 10:07:30'
                        )
                    )
                ),
                0   //status
            )
        );
    }

    /**
     *
     * Test change status all notification of special user
     *
     * @param Int $uid ID special user
     * @param Array $expected result your expect
     * @param boolean $status is result status of test case
     *
     * @dataProvider changeStatusNotIDDataProvider
     */
    public function testChangeStatusNotID($uid, $expected, $status) {
        $result = $this->NotificationComponent->changeStatus($uid);

        $output = $this->TNotification->find('all', array(
            'conditions' => array(
                'user_id' => $uid
            )));
        if ($status == 1) {
            $this->assertEquals($result, 1);
            $this->assertEquals($output, $expected);
        } else {
            $this->assertNotEquals($output, $expected);
        }
    }

    public function changeStatusNotIDDataProvider() {
        return array(
            //case 1: data expect right -> success
            array(
                2,      //uid
                array(
                    array(
                        'TNotification' => array(
                            'id' => 1,
                            'user_id' => '2',
                            'from_id' => 3,
                            'read' => '1',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-15 10:07:30'
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 2,
                            'user_id' => '2',
                            'from_id' => 3,
                            'read' => '1',
                            'content' => '<a href="/reports/create/1">Thaovtp requires you create detail content of reports</a>',
                            'created' => '2019-06-16 10:07:30'
                        )
                    ),
                    array(
                        'TNotification' => array(
                            'id' => 3,
                            'user_id' => '2',
                            'from_id' => 1,
                            'read' => '2',
                            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                            'created' => '2019-06-17 10:07:30'
                        )
                    )
                ),
                1       //status
            ),
            //case 2: uid not exist -> fail
            array(
                10,
                array(
                    array()
                ),
                0
            ),
            //case 3: uid undefined -> fail
            array(
                null,
                array(
                    array()
                ),
                0
            )
            //
        );
    }

    /**
     *
     * Test change status of special notification
     *
     * @param Int $uid ID special user
     * @param Int $id ID special notification
     * @param Array $expected result your expect
     * @param boolean $status is result status of test case
     *
     * @dataProvider changeStatusWidthIDDataProvider
     */
    public function testChangeStatusWidthID($uid, $id, $expected, $status) {
        $result = $this->NotificationComponent->changeStatus($uid, $id);

        $output = $this->TNotification->read(null, $id);

        if ($status == 1) {
            $this->assertEquals($result, 2);
            $this->assertEquals($output, $expected);
        } else {
            $this->assertNotEquals($output, $expected);
        }
    }

    public function changeStatusWidthIDDataProvider() {
        return array(
            //case 1: status changed -> success
            array(
                2, //user id
                1, // Notification ID
                array(
                    'TNotification' => array(
                        'id' => 1,
                        'user_id' => '2',
                        'from_id' => 3,
                        'read' => '2',
                        'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                        'created' => '2019-06-15 10:07:30'
                    ),
                ),
                1       //status
            ),
            //case 2: status not change -> fail
            array(
                2,
                1,
                array(
                    'TNotification' => array(
                        'id' => 1,
                        'user_id' => '2',
                        'from_id' => 3,
                        'read' => '0',
                        'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
                        'created' => '2019-06-15 10:07:30'
                    )
                ),
                0
            )

        );
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        parent::tearDown();
        // Clean up after we're done
        unset($this->NotificationComponent);
        unset($this->Controller);
    }

}