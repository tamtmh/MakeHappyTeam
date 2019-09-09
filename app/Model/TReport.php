<?php
App::uses('Model', 'Model');
class TReport extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_report';
    public $name = 'TReport';
    
    public $validate = array(
        'emoji_id' => array(
            'rule'    => 'notBlank',
            'message' => 'Emoji is required'
        ),
        'status' => array(
            'rule'    => 'notBlank',
            'message' => 'Comment is required'
        )
    );
    public function getReportByID($id){
        return $this->find('first', array(
            "conditions" =>  array("id" => $id)
        ));
    }

    public function checkReportTodayByTeam($id, $teamID) {
        return $this->find('count', array(
            "conditions" => array(
                'user_id' => $id,
                'team_id' => $teamID,
                'DATE(created)' => date('Y-m-d')
            )
        ));
    }
}