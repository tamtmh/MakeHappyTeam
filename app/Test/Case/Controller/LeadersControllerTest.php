<?php
App::uses('ClassRegistry', 'Utility');

class LeadersControllerTest extends ControllerTestCase {
    public $fixtures = array('app.team','app.roleteam', 'app.report', 'app.notification');

    public function setUp() {
        parent::setUp();
        $this->TReport = ClassRegistry::init('TReport');
        $this->TNotification = ClassRegistry::init('TNotification');
    }

    /**
     * List data for date
     * @param array $exampleDate get data on today
     * @depends testGetReportToday
     */
    public function testListReport($exampleDate) {
        // get list report allow date choose
        $dateReport = date('Y-m-d');
        $this->testAction('/leaders/listReport', array('data' => array('dateReport' => $dateReport, 'teamID' => 1), 'method' => 'post'));
        $this->assertEquals($exampleDate, $this->vars['results']);

        // check empty($dateReport)
        $dateReport = "";
        $this->testAction('/leaders/listReport', array('data' => array('dateReport' => $dateReport, 'teamID' => 1), 'method' => 'post'));
        $this->assertSame('Empty', $this->vars['results']);
    }

    public function testGetReportToday() {
        return $this->TReport->find('all', array(
            'conditions' => array(
                'team_id' => 1,
                'DATE(created)' => date('Y-m-d')
            )
        ));
    }

    /**
     * Test send notification when add comment
     *
     * @param    array $data data when send request
     * @dataProvider dataSendRequestReportDataProvider
     */
    public function testSendRequest($data) {
        //Mock up login session
        CakeSession::write('Auth.User', array(
            'username' => 'pvtamh2bg',
            'role_id' => '1',
            'id' => 1,
        ));

        $oldNotification = $this->TNotification->find('count');
        $result = $this->testAction('/leaders/sendRequest', array('data' => $data, 'method' => 'post'));
        $statusReport = $this->TReport->find('first', array(
            'fields' => array('report_status'),
            'conditions' => array('id' => $data['reportID'])
        ));
        $newNotification = $this->TNotification->find('count');

        $this->assertTrue($result);
        $this->assertEquals($statusReport['TReport']['report_status'], 1);
        $this->assertEquals($newNotification, ++$oldNotification);
    }

    public function dataSendRequestReportDataProvider() {
        return array(
            //case 1: send notification when send request and change status of report => success
            array(
                array(
                    'content' => '<a href="/reports/create/1"> requires you create detail content of reports</a>',
                    'reportID' => '1',
                    'toID' => '1'
                )
            ),

        );
    }
}