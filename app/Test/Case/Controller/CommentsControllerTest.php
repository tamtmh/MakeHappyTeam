<?php
App::uses('ClassRegistry', 'Utility');

class CommentsControllerTest extends ControllerTestCase {
    public $fixtures = array('app.team', 'app.user', 'app.comment', 'app.notification','app.roleteam');

    public function setUp() {
        parent::setUp();
        $this->TComment = ClassRegistry::init('TComment');
        $this->TUser = ClassRegistry::init('TUser');
        $this->TNotification = ClassRegistry::init('TNotification');
        $this->TUserTeam = ClassRegistry::init('TUserTeam');
    }

    /**
     *
     * Test add comment
     *
     * @param    array $comment data add comment
     * @param    int $status mark the status: success or fail
     * @dataProvider dataAddCommentDataProvider
     */
    public function testAddComment($comment, $status) {
        //Mock up login session
        CakeSession::write('Auth.User', array(
            'id' => 1,
        ));

        $oldComment = $this->TComment->find('count');
        $result = $this->testAction('/comments/addComment', array('data' => $comment['TComment'], 'method' => 'post'));
        if ($status == 1) {
            $newComment = $this->TComment->find('all', array(
                'fields' => array('content', 'report_id', 'user_id')
            ));
            $expected = array(
                'TComment' => array(
                    'content' => 'Test2 ngay 8/7',
                    'report_id' => 1,
                    'user_id' => 1
                )
            );
            $this->assertEquals(count($newComment), ++$oldComment);
            $this->assertContains($expected, $newComment);
        } else {
            $this->assertFalse($result);
        }
        CakeSession::delete('Auth.User');
    }

    public function dataAddCommentDataProvider() {
        return array(
            //case 1: infomation comment full  => success
            array(
                array(
                    'TComment' => array(
                        'content' => 'Test2 ngay 8/7',
                        'report_id' => 1,
                        'user_report' => 1  //report creator id
                    )
                ),  //data add comment
                1   //status
            ),
            //case 2: content field is empty => fail
            array(
                array(
                    'TComment' => array(
                        'content' => null,
                        'report_id' => 1
                    )
                ),
                0
            ),
            //case 3: report_id field is empty => fail
            array(
                array(
                    'TComment' => array(
                        'content' => 'Test2 ngay 8/7',
                        'report_id' => null
                    )
                ),
                0
            ),
        );
    }

    /**
     *
     * Test send notification when add comment
     *
     * @param    array $userInfo data add comment
     * @param    array $comment data add comment
     * @param    int $status mark the status (0:user login isn't report creator id , 1:user login is report creator id )
     * @dataProvider dataNotificationDataProvider
     */
    public function testNotification($userInfo, $comment, $status) {
        //Mock up login session
        CakeSession::write('Auth.User', $userInfo);
        $oldNotification = $this->TNotification->find('count');

        $this->testAction('/comments/addComment', array('data' => $comment['TComment'], 'method' => 'post'));
        if ($status == 1) {
            $newNotification = $this->TNotification->find('count');
            $numberAdmin = count($this->TUserTeam->getLeaderList($comment['TComment']['team_id'], $userInfo['id']));
            $this->assertEquals($newNotification, $oldNotification + $numberAdmin);
        } else {
            $newNotification = $this->TNotification->find('count');
            $this->assertEquals($newNotification, ++$oldNotification);
        }
        CakeSession::delete('Auth.User');
    }

    //data test add notification of comment
    public function dataNotificationDataProvider() {
        return array(
            //case 1: user login is report creator id
            array(
                array(
                    'id' => 1,
                ),  //data user login
                array(
                    'TComment' => array(
                        'content' => 'Test1 ngay 8/7',
                        'report_id' => 1,
                        'team_id' => 1,
                        'user_report' => 1  //report creator id
                    )
                ),  //data add comment
                1   //status
            ),
            //case 1: user login isn't report creator id
            array(
                array(
                    'id' => 2,
                ),
                array(
                    'TComment' => array(
                        'content' => 'Test2 ngay 8/7',
                        'report_id' => 1,
                        'team_id' => 1,
                        'user_report' => 1
                    )
                ),
                0
            )
        );
    }
}