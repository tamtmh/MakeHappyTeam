<?php
App::uses('Model', 'Model');

class TUserTeam extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_user_team';
    public $name = 'TUserTeam';

    // get list leader
    public function getLeaderList($teamID, $exceptID = null){
        $params = array('role_team_id' => 1, 'team_id' => $teamID);
        if($exceptID !== null) $params['user_id !='] = $exceptID;

        return $this->find('all', array(
            'fields' => array('user_id'),
            'conditions' => $params
        ));
    }
}