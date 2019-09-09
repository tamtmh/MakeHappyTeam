<?php

class NotificationComponent extends Component {
    public $components = array('Session');

    public function __construct() {
        $this->TNotification = ClassRegistry::init('TNotification');
    }

    /**
     * @param $from array(id => name)
     * @param $to   array(id1, id2, id3)
     * @param $content text or html format
     */
    public function send($from, $to, $content) {
        if(!$from || !$to) return false;
        if (count($to) !== 0) {
            foreach ($to as $key => $item) {
                $data = array(
                    'user_id' => $item,
                    'from_id' => $from,
                    'content' => $content,
                    'read' => 0,
                    'created' => date("Y-m-d H:i:s")
                );
                $this->TNotification->create();
                if (!$this->TNotification->save($data)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function check($uid) {
        return $this->TNotification->getLimitByUserID($uid);
    }

    public function changeStatus($uid, $id = null) {
        if (!$uid)
            return false;

        ## Unbind Model TUser
        $this->TNotification->unbindModel(
            array('belongsTo' => array('TUser'))
        );

        if (!$id) {
            if ($this->TNotification->updateAll(
                array('TNotification.read' => 1),
                array('TNotification.user_id' => $uid,
                    'TNotification.read <' => 2
                )
            ))
                return 1;
        } else {
            $this->TNotification->id = $id;
            $this->TNotification->set('read', 2);
            if ($this->TNotification->save())
                return 2;
        }

        return false;
    }

    public function getLastestNotification($uid){
        return $this->TNotification->find('first', array(
            'conditions' => array('user_id' => $uid),
            'order' => array('created DESC')
        ));
    }

    public function getNumberNewNoti($uid){
        ## Unbind Model TUser
        $this->TNotification->unbindModel(
            array('belongsTo' => array('TUser'))
        );

        return $this->TNotification->find('count', array(
            'conditions' => array(
                'user_id' => $uid,
                'read'  => 0
            )
        ));
    }
}