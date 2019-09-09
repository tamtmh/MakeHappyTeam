<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
    public $uses = array("TUser");
    public $components = array('Paginator');
    public  $layout = 'login';
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('signup');
    }
    public function signup() {
        if ($this->request->is('post')) {
            $this->TUser->create();
            $data['TUser'] = $this->request->data;
            $this->TUser->set($data);
            if ($this->TUser->validates()) {
                if ($this->TUser->save($data)) {
                    $this->Session->setFlash(__('Welcome! you have signed up successfully.', null), 
                            'default', 
                             array('class' => 'flash-message-success text-success'));
                
                    // Retrieve user from DB
                    $id = $this->TUser->id;
                    $data['TUser'] = array_merge(
                        $data['TUser'],
                        array('id' => $id)
                    );
                    unset($data['TUser']['password']);
                    if($this->Auth->login($data['TUser'])){
                        return $this->redirect('/reports/index');
                    } else {
                        $this->Session->setFlash(__('An error has occurred', null), 
                            'default', 
                             array('class' => 'flash-message-error text text-danger'));
                    }
                } else {
                    $this->Session->setFlash(__('The user could not be saved. Please, try again.', null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
                }
            } else {
                $error = $this->TUser->validationErrors;
                if (isset($error['username'])) {
                    $this->Session->setFlash(__($error['username'][0], null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
                }
                if (isset($error['email'])) {
                    $this->Session->setFlash(__($error['email'][0], null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
                }
                if (isset($error['password'])) {
                    $this->Session->setFlash(__($error['password'][0], null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
                }
            }
        }
    }

    public function editProfile(){
        $this->autoRender = false;
        $this->layout = 'ajax';

        if($this->request->is('ajax') || $this->request->is('post')){
            $postData = $this->request->data;
            $this->request->data['date_of_birth'] = date("Y-m-d H:i:s", strtotime($this->request->data['date_of_birth']));
            $this->request->data['modified'] = date("Y-m-d H:i:s");
            if($this->TUser->save($this->request->data)){
                $this->Session->write('Auth.User.date_of_birth', $this->request->data['date_of_birth']);
                $this->Session->write('Auth.User.phone_number', $this->request->data['phone_number']);
                $this->Session->write('Auth.User.facebook', $this->request->data['facebook']);
                $response['status'] = 1;
                $response['message'] =  'Save User Profile success!';
                $response['data'] = $postData;
            }else{
                $response['status'] = 0;
                $response['message'] = 'Whoop!! Error can\'t save data';
            }
        }

        return json_encode($response);
    }

    public function uploadAvatar() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if($this->request->is('ajax') || $this->request->is('post')){
            if (isset($_FILES) && !empty($_FILES) && !empty($_FILES['file'])) {
                $name_avatar= $this->nameAvartar($_FILES);
                $dir = WWW_ROOT.'img';
                if (!file_exists($dir.'/avatar_user')) {
                    mkdir($dir.'/'.'avatar_user');
                }
                $folder = $dir.'/'.'avatar_user/';
                $this->moveUploadFile($_FILES, $name_avatar, $folder);
                $this->TUser->id = $this->Auth->user()['id']; //save db
                if (isset($this->request->data['mark']) && !empty($this->request->data['mark'])) {
                    if ($this->request->data['mark'] == 2) {
                        $this->Session->write('Auth.User.cover_image', $name_avatar);
                        $this->TUser->set('cover_image', $name_avatar); //save db
                    } else {
                        $this->Session->write('Auth.User.avatar_user', $name_avatar);
                        $this->TUser->set('avatar_user', $name_avatar); //save db
                    }
                }
                if ($this->TUser->save()) {
                    return true;
                }
            }
        }
        return false;
    }
}


