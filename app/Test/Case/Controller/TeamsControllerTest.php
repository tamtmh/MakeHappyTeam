<?php
App::uses('ClassRegistry', 'Utility');
App::uses('TeamsController', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');

class TeamsControllerTest extends ControllerTestCase {

    public $fixtures = array('app.team', 'app.userteam', 'app.roleteam', 'app.report');

    public function setUp() {
        parent::setUp();
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new TeamsController($CakeRequest, $CakeResponse);
        $this->TTeam = ClassRegistry::init('TTeam');
        $this->TUserTeam = ClassRegistry::init('TUserTeam');
        $this->TReport = ClassRegistry::init('TReport');
    }

    /**
     * test delete member action
     *
     * @param int $user_id : id of user handling delete
     * @param array $data : account data that need to delete
     * @param array $dataContain expected data
     * @param int $status status of test case: success of fail
     * @dataProvider deleteMemberDataProvider
     */
    public function testDeleteMember($userId, $data, $dataContain, $status) {
        $beforeDeleteMemberCount = $this->TUserTeam->find('count');
        //login session
        CakeSession::write('Auth.User', array(
            'id' => $userId
        ));
        $options = array(
            'method' => 'post',
            'data' => array(
                'teamId' => $data['TUserTeam']['team_id'],
                'memberIDs' => $data['TUserTeam']['user_id']
            )
        );
        $this->testAction('/teams/deleteMember', $options);

        $afterDeleteMemberCount = $this->TUserTeam->find('count');

        $output = $this->TUserTeam->find('all', array('fields' => array('team_id', 'user_id'), 'conditions' => array('team_id' => $data['TUserTeam']['team_id'])));

        if ($status == 1) {
            $this->assertEquals($beforeDeleteMemberCount - 1, $afterDeleteMemberCount);
            $this->assertNotContains($dataContain, $output);
        } else {
            $this->assertEquals($beforeDeleteMemberCount, $afterDeleteMemberCount);
            $this->assertEquals($dataContain, $output);
        }

        //delete session
        CakeSession::delete('Auth.User');

    }

    public function deleteMemberDataProvider() {
        return array(
            //pass
            array(
                1, //user_id
                array(
                    'TUserTeam' => array(
                        'team_id' => '1',
                        'user_id' => array('2')
                    ),
                ),
                array(
                    'TUserTeam' => array(
                        'team_id' => 1,
                        'user_id' => 2
                    ),
                ),
                1 //status
            ),
            //fail
            array(
                3, //user_id
                array(
                    'TUserTeam' => array(
                        'team_id' => '1',
                        'user_id' => array('2')
                    ),
                ),
                array(
                    array(
                        'TUserTeam' => Array
                        (
                            'team_id' => 1,
                            'user_id' => 1
                        )

                    ),
                    array(
                        'TUserTeam' => Array
                        (
                            'team_id' => 1,
                            'user_id' => 2
                        )
                    ),
                    array(
                        'TUserTeam' => Array
                        (
                            'team_id' => 1,
                            'user_id' => 3
                        )
                    )
                ),
                0 //status
            ),
        );
    }

    /**
     * test delete team action
     *
     * @param int $userId id of user handling delete
     * @param array $data : data of team that need to delete
     * @param int $status status of test case: success or fail
     * @dataProvider deleteTeamDataProvider
     */
    public function testDeleteTeam($userId, $data, $status) {
        $beforeDeleteTeamCount = $this->TTeam->find('count');
        $beforeDeleteTeamCount1 = $this->TReport->find('count');

        //login session
        CakeSession::write('Auth.User', array(
            'id' => $userId
        ));

        $options = array(
            'method' => 'post',
            'data' => array(
                'team_id' => $data['TTeam']['id']
            )
        );
        $this->testAction('/teams/deleteTeam/?teamid=' . $data['TTeam']['id'], $options);

        $afterDeleteTeamCount = $this->TTeam->find('count');
        $afterDeleteUserTeamCount = $this->TUserTeam->find('count', array('conditions' => array('team_id' => $data['TTeam']['id'])));
        $afterDeleteReportCount = $this->TReport->find('count', array('conditions' => array('team_id' => $data['TTeam']['id'])));

        $output = $this->TTeam->find('all', array('fields' => array('id')));

        if ($status == 1) {
            $this->assertEquals($beforeDeleteTeamCount - 1, $afterDeleteTeamCount);
            $this->assertNotContains($data, $output);
            $this->assertEquals($afterDeleteUserTeamCount, 0);
            $this->assertEquals($afterDeleteReportCount, 0);
        } else {
            $this->assertEquals($beforeDeleteTeamCount, $afterDeleteTeamCount);
            $this->assertContains($data, $output);
            $this->assertNotEquals($afterDeleteUserTeamCount, 0);
            $this->assertNotEquals($afterDeleteReportCount, 0);
        }

        //delete session
        CakeSession::delete('Auth.User');
    }

    public function deleteTeamDataProvider() {
        return array(
            //pass
            array(
                1, //user_id
                array(
                    "TTeam" => array(
                        'id' => '1',
                    ),
                ),
                1 //status
            ),
            //fail
            array(
                3, //user_id
                array(
                    "TTeam" => array(
                        'id' => '1',
                    ),
                ),
                0 //status
            ),
        );
    }

    /**
     * Edit team information
     * @param string $dataForm serialize string: name, des, and name image
     * @param  array $file File information is uploaded
     * @param int $status mark the status: success or fail
     * @dataProvider editTeamProvider
     */
    public function testEditTeam($dataForm, $file, $status) {
        //Mock up login session
        CakeSession::write('Auth.User', array(
            'username' => 'nhinhdt',
            'role_id' => '1',
            'id' => 5,
        ));

        $data['data'] = $dataForm;
        $_FILES['file'] = $file;

        $params = array();
        parse_str($data['data'][0], $params['TTeam']);
        $team_id = $params['TTeam']['team_id'];

        $beforeEditTeam = $this->TTeam->find('first', array(
            'conditions' => array(
                'id' => $team_id
            )
        ));
        $this->testAction('teams/editTeam', array('data' => $data));

        $afterEditTeam = $this->TTeam->find('first', array(
            'conditions' => array(
                'id' => $params['TTeam']['team_id']
            )
        ));

        if ($status == 1) {
            $this->assertNotEquals($beforeEditTeam['TTeam']['name'], $afterEditTeam['TTeam']['name']);
            if (isset($file) && !empty($file) && !empty($file['file'])) {
                $this->assertNotEquals($beforeEditTeam['TTeam']['avatar'], $afterEditTeam['TTeam']['avatar']);
            }
        } else {
            $this->assertEquals($beforeEditTeam['TTeam']['name'], $afterEditTeam['TTeam']['name']);
            $this->assertEquals($beforeEditTeam['TTeam']['avatar'], $afterEditTeam['TTeam']['avatar']);
        }
        CakeSession::delete('Auth.User');
    }

    public function editTeamProvider() {
        return array(
            // case 1: full message => success
            array(
                // dataform
                array(
                    "name=edit+team&des=dskhgkdf&team_id=2" // dataForm
                ),
                // file
                array(
                    'error' => UPLOAD_ERR_OK,
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',  // WRONG TYPE
                    'size' => 112, //112547,
                    'tmp_name' => '/tmp/phppxAdOg',
                    'type' => 'image/jpeg'
                ),
                // status
                1
            ),
            // case 2: upload image null, but full name => success
            array(
                array(
                    "name=edit+team&des=dskhgkdf&team_id=2"
                ),
                null,
                1
            ),
            // case 3: empty name => fail
            array(
                array(
                    "name=&des=dskhgkdf&team_id=2"
                ),
                array(
                    'error' => UPLOAD_ERR_OK,
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',  // WRONG TYPE
                    'size' => 112547,
                    'tmp_name' => '/tmp/phppxAdOg',
                    'type' => 'image/jpeg'
                ),
                0
            )
        );
    }

    /**
     * Add a team
     * @param string $dataForm serialize string: name, des
     * @param  array $file File information is uploaded
     * @param int $status mark the status: success or fail
     * @dataProvider createTeamDataProvider
     */
    public function testCreateTeam($dataForm, $file, $status) {
        $data['data'] = $dataForm;
        $_FILES['file'] = $file;
        $beforeAddTeamCount = $this->TTeam->find('count');
        $this->testAction('/teams/addTeam', array('data' => $data, 'method' => 'post'));
        $afterAddTeamCount = $this->TTeam->find('count');
        $output = $this->TTeam->find('all', array('fields' => array('TTeam.name, TTeam.des')));
        if ($status == 1) {
            $this->assertEquals($beforeAddTeamCount + 1, $afterAddTeamCount);
        } else {
            $this->assertEquals($beforeAddTeamCount, $afterAddTeamCount);
        }
    }

    public function createTeamDataProvider() {
        return array(
            // case 1: full message => success
            array(
                // dataForm
                "name=teamtest&des=gxg",
                // file
                array(
                    'error' => UPLOAD_ERR_OK,
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',  // WRONG TYPE
                    'size' => 112547,
                    'tmp_name' => '/tmp/phppxAdOg',
                    'type' => 'image/jpeg'
                ),
                1 // status
            ),
            // case 2: empty file, but full data form => success
            array(
                array(
                    'file' => "undefined",
                    0 => "name=teamtest&des=xbcv"
                ),
                null,
                1
            ),
            // case 3: empty name, full file => fail
            array(
                "name=&des=teamtest",
                array(
                    'error' => UPLOAD_ERR_OK,
                    'name' => '60141006_2425036027548198_7817765159409025024_n.jpg',  // WRONG TYPE
                    'size' => 112547,
                    'tmp_name' => '/tmp/phppxAdOg',
                    'type' => 'image/jpeg'
                ),
                0
            ),
            // case 4: empty name, empty file => fail
            array(
                array(
                    'file' => "undefined",
                    0 => "name=&des=xbcv"
                ),
                null,
                0
            )
        );
    }

    /**
     *
     * Test change permission user in team
     *
     * @param Int $teamID The numerical ID of the team.
     * @param Array $permission list permission of member in team.
     * @param Array $expects data your expect.
     * @param boolean $status is result status of test case.
     *
     * @dataProvider changePermissionDataProvider
     */
    public function testChangePermision($teamID, $permission, $expects, $status) {

        $result = $this->Controller->changePermission($teamID, $permission);
        $output = $this->TUserTeam->find('all', array(
            'conditions' => array('team_id' => $teamID),
            'fields' => array('id', 'user_id', 'team_id', 'role_team_id', 'created')
        ));

        if ($status == 1) {
            $this->assertEquals($expects, $output);
        } else {
            $this->assertNotEquals($expects, $output);
        }
    }

    public function changePermissionDataProvider() {
        return array(
            //case 1: success
            array(
                1,
                array(
                    '2' => 2,
                    '3' => 1
                ),
                array(
                    array(
                        'TUserTeam' => array(
                            'id' => '1',
                            'user_id' => '1',
                            'team_id' => '1',
                            'role_team_id' => '1',
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => '2',
                            'user_id' => '2',
                            'team_id' => '1',
                            'role_team_id' => '2',
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => '3',
                            'user_id' => '3',
                            'team_id' => '1',
                            'role_team_id' => '1',
                            'created' => '2019-06-05 10:07:30'
                        )
                    )
                ),
                1    //status
            ),
            //case 2: fail
            array(
                1,
                array(
                    '2' => 2,
                    '3' => 1
                ),
                array(
                    array(
                        'TUserTeam' => array(
                            'id' => 1,
                            'user_id' => 1,
                            'team_id' => 1,
                            'role_team_id' => 1,
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => 2,
                            'user_id' => 2,
                            'team_id' => 1,
                            'role_team_id' => 1,
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => 3,
                            'user_id' => 3,
                            'team_id' => 1,
                            'role_team_id' => 1,
                            'created' => '2019-06-05 10:07:30'
                        )
                    )
                ),
                0   //status
            ),
            //case 3: list permission empty -> fail
            array(
                1,
                array(),
                array(
                    array(
                        'TUserTeam' => array(
                            'id' => 1,
                            'user_id' => 1,
                            'team_id' => 1,
                            'role_team_id' => 1,
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => 2,
                            'user_id' => 2,
                            'team_id' => 1,
                            'role_team_id' => 1,
                            'created' => '2019-06-05 10:07:30'
                        )
                    ),
                    array(
                        'TUserTeam' => array(
                            'id' => 3,
                            'user_id' => 3,
                            'team_id' => 1,
                            'role_team_id' => 2,
                            'created' => '2019-06-05 10:07:30'
                        )
                    )
                ),
                1   //status
            )
        );
    }

    /**
     *
     * Test add member of team
     *
     * @param    array $dataAddMember data to add members
     * @param    int $status mark the status: success or fail
     * @dataProvider dataAddMemberDataProvider
     */
    public function testAddMember($dataAddMember, $status) {
        //Mock up login session
        CakeSession::write('Auth.User', array(
            'username' => 'pvtamh2bg',
            'id' => 1,
        ));

        $memberOld = $this->TUserTeam->find('count');
        $result = $this->testAction('/teams/addMember', array('data' => $dataAddMember, 'method' => 'post'));
        if ($status == 1) {
            $expect = array(
                array(
                    'TUserTeam' => array(
                        'user_id' => 1,
                        'team_id' => 1,
                        'role_team_id' => 1,
                    )
                ),
                array(
                    'TUserTeam' => array(
                        'user_id' => 2,
                        'team_id' => 1,
                        'role_team_id' => 1
                    )
                ),
                array(
                    'TUserTeam' => array(
                        'user_id' => 3,
                        'team_id' => 1,
                        'role_team_id' => 2
                    )
                ),
                array(
                    'TUserTeam' => array(
                        'user_id' => 4,
                        'team_id' => '1',
                        'role_team_id' => '2'
                    )
                ),
                array(
                    'TUserTeam' => array(
                        'user_id' => 5,
                        'team_id' => '1',
                        'role_team_id' => '2'
                    )
                ),
                array(
                    'TUserTeam' => array(
                        'user_id' => 6,
                        'team_id' => '1',
                        'role_team_id' => '2'
                    )
                ),
            );
            $memberNew = $this->TUserTeam->find('all', array(
                'fields' => array('user_id', 'team_id', 'role_team_id')
            ));
            $this->assertEquals($expect, $memberNew);
            $this->assertEquals($memberOld + 3, count($memberNew));
        } else {
            $this->assertFalse($result);
        }
        CakeSession::delete("Auth.User");
    }

    public function dataAddMemberDataProvider() {
        return array(
            //case 1: infomation full => success
            array(
                'TUserTeam' => array(
                    'userID' => array(4, 5, 6),  //members are added
                    'team_id' => 1,
                    'team_name' => 'Make Happy Team'
                ),  //data to add members
                1   //status
            ),
            //case 2: userID field is empty => fail
            array(
                'TUserTeam' => array(
                    'userID' => null,
                    'team_id' => 1,
                    'team_name' => 'Make Happy Team'
                ),
                0
            ),
            //case 3: team_id field is empty => fail
            array(
                'TUserTeam' => array(
                    'userID' => array(4, 5, 6),
                    'team_id' => null,
                    'team_name' => 'Make Happy Team'
                ),
                0
            ),
            //case 4: team_id field is empty => fail
            array(
                'TUserTeam' => array(
                    'userID' => array(4, 5, 6),
                    'team_id' => 1,
                    'team_name' => null
                ),
                0
            ),
            //case 5: all empty => fail
            array(
                'TUserTeam' => array(
                    'userID' => null,
                    'team_id' => null,
                ),
                0
            )
        );
    }

}
