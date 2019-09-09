<?php
App::uses('AppController', 'Controller');
class NotificationsController extends AppController {
    public $uses = array("TNotification");
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    public  $layout = 'default';
    public $paginate = array(
        'limit' => 10,
        'order' => array('created' => 'desc'),
    );

    public function index() {
        $this->set('hideSidebar', 1);

        $this->paginate['conditions'] = array('user_id' => $this->Auth->user()['id']);
        $this->TNotification->bindModel(
            array('belongsTo' => array(
                'TUser' => array(
                    'className' => 'TUser',
                    'foreignKey' => 'from_id',
                    'fields' => array('id', 'username', 'avatar_user'),
                )
            ))
        );

        $uid = $this->Auth->user()['id'];
        $this->Paginator->settings = $this->paginate;
        $data = $this->Paginator->paginate("TNotification", array(
            array('user_id' => $uid)
        ));

        $this->set("data", $data);
        $this->set('pageCount', $this->request->params['paging']['TNotification']['pageCount']);
    }

    public function changeStatus(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $uid = $this->Auth->user()['id'];
        $id = $this->request->data('id');
        if (isset($id) && $id !== '') {
            return $this->Notification->changeStatus($uid, $id);
        } else
            return $this->Notification->changeStatus($uid);
    }
}


