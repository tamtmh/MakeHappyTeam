<?php
App::uses('TUserTeam', 'Model');
App::uses('ClassRegistry', 'Utility');

class TUserTeamTest extends CakeTestCase {
    public $fixtures = array('app.userteam');

    public function setUp() {
        parent::setUp();
        $this->TUserTeam = ClassRegistry::init('TUserTeam');
    }

    /**
     *
     * Test get the list leader of team
     *
     * @param    int $teamID is team_id
     * @param    int $userLogin is id of user login
     * @param    array $expected data expected
     * @dataProvider dataListLeaderTeamDataProvider
     */
    public function testGetLeaderList($teamID, $userLogin, $expected) {
        $result = $this->TUserTeam->getLeaderList($teamID, $userLogin);
        $this->assertEquals($expected, $result);
    }

    public function dataListLeaderTeamDataProvider() {
        return array(
            //case 1: get the list leader of team to user login => success
            array(
                1,  //team_id
                2,  //id of user login
                array(
                    array(
                        'TUserTeam' => array(
                            'user_id' => 1
                        )
                    )
                )  //data expected
            )
        );
    }
}