<?php
App::uses('Model', 'Model');

class TNotification extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_notification';
    public $name = 'TNotification';

    public function getLimitByUserID($uid) {
        $this->belongsTo = array(
            'TUser' => array(
                'className' => 'TUser',
                'foreignKey' => 'from_id',
                'fields' => array('id', 'username', 'avatar_user'),
            )
        );
        return $this->find('all', array(
            'conditions' => array('user_id' => $uid),
            'order' => array('TNotification.created' => 'desc'),
            'limit' => 30,
        ));
    }
}