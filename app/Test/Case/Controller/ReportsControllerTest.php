<?php
App::uses('ClassRegistry', 'Utility');

class ReportsControllerTest extends ControllerTestCase {
    public $fixtures = array('app.team', 'app.report', 'app.notification', 'app.user', 'app.comment', 'app.roleteam');

    public function setUp() {
        parent::setUp();
        $this->TReport = ClassRegistry::init('TReport');
        $this->TNotification = ClassRegistry::init('TNotification');
        $this->TComment = ClassRegistry::init('TComment');
        $this->TUserTeam = ClassRegistry::init('TUserTeam');
    }

    /**
     * List data of account and add report on today
     * @param array $data data input information form add report
     * @param int $status mark the status: success or fail
     * @dataProvider dataReportProvider
     */
    public function testAddReportAndIndex($data, $status) {
        //Mock up login session
        CakeSession::write('Auth.User', array(
            'username' => 'nhinhdt',
            'role_id' => '1',
            'id' => 5,
        ));
        $beforeAdd = $this->TReport->find('all', array(
            'conditions' => array(
                'team_id' => 1
            )
        )); // not add
        $this->testAction('reports/addReport', array('data' => $data));
        $afterAdd = $this->TReport->find('all', array(
            'conditions' => array(
                'team_id' => 1
            )
        ));// after add 1 item

        $itemAdd = $this->TReport->find('first', array(
            'conditions' => array(
                'id' => 5,
                'team_id' => 1
            )
        ));
        if ($status == 1) {
            $this->assertNotEquals($beforeAdd, $afterAdd);
            $this->assertCount(count($beforeAdd) + 1, $afterAdd);
            $this->assertContains($itemAdd, $afterAdd);
        } else {
            $this->assertCount(count($beforeAdd), $afterAdd);
        }
        CakeSession::delete('Auth.User');
    }

    public function dataReportProvider() {
        return array(
            // case 1: full message => success
            array(
                'TReport' => array(
                    'team_id' => '1',
                    'emoji_id' => '1',
                    'score' => '90',
                    'comment' => 'report add!'
                ),
                'status' => 1
            ),
            // case 2: empty status => fail
            array(
                'TReport' => array(
                    'team_id' => '1',
                    'emoji_id' => '1',
                    'score' => '90',
                    'status' => ''
                ),
                'status' => 0
            ),
            // case 3: empty emoji_id => fail
            array(
                'TReport' => array(
                    'team_id' => '1',
                    'emoji_id' => '',
                    'score' => '90',
                    'status' => 'aaaaaaaaa'
                ),
                'status' => 0
            ),
            // case 4: empty team_id => fail
            array(
                'TReport' => array(
                    'team_id' => '',
                    'emoji_id' => '1',
                    'score' => '90',
                    'comment' => 'have a pretty day!'
                ),
                'status' => 0
            ),
        );
    }

    /**
     *
     * Test Create report method
     *
     * @param Array $data data test case
     * @param Int $reportId The numerical ID of the special report.
     * @param boolean $status is result status of test case
     *
     * @dataProvider createReportDataProvider
     */
    public function testCreateReport($data, $reportId, $status) {

        CakeSession::write('Auth.User', array(
            'username' => 'nhinhdt',
            'role_id' => '1',
            'id' => 1,
        ));

        $beforeCountNoti = $this->TNotification->find('count');
        $numberToNoti = count($this->TUserTeam->getLeaderList(1, 1));

        $this->testAction('/reports/create/' . $reportId, array('data' => $data, 'method' => 'post'));

        // Find report detail field after create report saved
        $outputReports = $this->TReport->read('report_detail', $reportId);

        $afterCountNoti = $this->TNotification->find('count');

        if ($status == 1) {
            // if success then field not empty
            $this->assertNotEmpty($outputReports['TReport']['report_detail']);
            // Send notification success
            $this->assertEquals($afterCountNoti, $beforeCountNoti + $numberToNoti);
            // redirect to /reports/detail when notification sent
            $this->assertContains('/reports/detail', $this->headers['Location']);

        } else {
            $this->assertEmpty($outputReports['TReport']['report_detail']);
            $this->assertNotEquals($afterCountNoti, $beforeCountNoti + $numberToNoti);
        }

        CakeSession::delete('Auth.User');
    }

    public function createReportDataProvider() {
        return array(
            //case 1: message full -> success
            array(
                array(
                    'TReport' => array(
                        'Problem' => 'New Report Detail',
                        'Did it affect to work?' => 'yes',
                        'How did it affect to work?' => "Test New Report",
                        'How do you think how to fix the problem and affect?' => 'Test New report'
                    )
                ),
                1,   //report ID
                1    //status
            ),
            //case 2: problem field is empty -> fail
            array(
                array(
                    'TReport' => array(
                        'Problem' => '',
                        'Did it affect to work?' => 'yes',
                        'How did it affect to work?' => "Test New Report",
                        'How do you think how to fix the problem and affect?' => 'Test New report'
                    )
                ),
                2,
                0
            )
        );
    }

    /**
     *
     * Test redirect of report detail
     *
     * @param    int $id is id of report
     * @param    int $status mark the status: success or fail
     * @dataProvider redirectDetailDataProvider
     */
    public function testRedirectReportDetail($id, $status) {
        $this->testAction('/reports/detail/' . $id);
        if ($status == 1) {
            $this->assertContains('/reports', $this->headers['Location']);
        } else {
            $this->assertNotEmpty($this->vars['report']);
        }
    }

    public function redirectDetailDataProvider() {
        return array(
            //case 1: id has report detail => fail
            array(
                3,  //report_id
                0   //status
            ),
            //case 2: id has no report detail => suscess
            array(
                2,
                1
            ),
            //case 3: without id => suscess
            array(
                null,
                1
            ),
        );
    }

    /**
     *
     * Test get infomation report detail
     *
     * @param    int $id is id of report
     * @param    array $expected data expected
     * @dataProvider dataReportDetailDataProvider
     */
    public function testGetReportDetail($id, $expected) {
        $this->testAction('/reports/detail/' . $id);
        $comment = $this->TComment->find('all', array(
            'conditions' => array('report_id' => $id),
        ));
        $this->assertEquals($this->vars['report'], $expected);
        $this->assertEquals($this->vars['comment'], $comment);
    }

    public function dataReportDetailDataProvider() {
        return array(
            //case 1: id has report detail => success
            array(
                3,  //report_id
                array(
                    'TReport' => array(
                        'id' => '3',
                        'user_id' => '2',
                        'team_id' => '1',
                        'emoji_id' => '1',
                        'score' => '90',
                        'status' => 'have a nice day!',
                        'report_status' => '2',
                        'report_detail' => array(
                            0 => array(
                                'Problem' => 'i have a good day',
                                'Did it affect to work?' => 'no',
                                'How did it affect to work?' => 'sfdsfgfg',
                                'How do you think how to fix the problem and affect?' => 'dgfhgfh',
                                'What do you want leader help you?' => 'dhgfh'
                            )),
                        'created' => '2019-06-06 10:07:30',
                        'day_detail' => '2019-06-14 03:58:16',
                    )
                )   //data expected
            )
        );
    }
}