<?php
App::uses('TComment', 'Model');
App::uses('ClassRegistry', 'Utility');

class TCommentTest extends CakeTestCase {
    public $fixtures = array('app.user', 'app.comment');

    public function setUp() {
        parent::setUp();
        $this->TComment = ClassRegistry::init('TComment');
        $this->TUser = ClassRegistry::init('TUser');
    }

    /**
     *
     * Test get the list of comments by report id
     *
     * @param    int $id is id of report
     * @param    array $expected data expected
     * @dataProvider dataListCommentDataProvider
     */
    public function testGetListComment($reportID, $expected) {
        $result = $this->TComment->getCommentList($reportID);
        $this->assertEquals($expected, $result);
    }

    public function dataListCommentDataProvider() {
        return array(
            //case 1: get the list of comments by report id => success
            array(
                1,  //report_id
                array(
                    array(
                        'TComment' => array(
                            'id' => 3,
                            'user_id' => '2',
                            'report_id' => '1',
                            'content' => '疲れました！',
                            'created' => '2019-06-16 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => '2',
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TComment' => array(
                            'id' => 2,
                            'user_id' => '3',
                            'report_id' => '1',
                            'content' => 'Have a nice day',
                            'created' => '2019-06-15 11:07:30'
                        ),
                        'TUser' => array(
                            'id' => '3',
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    ),
                    array(
                        'TComment' => array(
                            'id' => 1,
                            'user_id' => '2',
                            'report_id' => '1',
                            'content' => 'Have a nice day',
                            'created' => '2019-06-15 10:07:30'
                        ),
                        'TUser' => array(
                            'id' => '2',
                            'username' => 'admin',
                            'avatar_user' => ''
                        )
                    )
                )  //data expected
            )
        );
    }
}