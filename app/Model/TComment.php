<?php
App::uses('Model', 'Model');
class TComment extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_comment';
    public $name = 'TComment';

    public function getCommentList($id){
        $this->belongsTo = array(
            'TUser' => array(
                'className' => 'TUser',
                'foreignKey' => 'user_id',
                'fields' => array('id', 'username', 'avatar_user'),
            )
        );
        return $this->find('all', array(
            "conditions" =>  array("report_id" => $id),
            'order' => array('TComment.created' => 'desc'),
        ));
    }
}