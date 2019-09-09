<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('Security', 'Utility');
class LoginsController extends AppController
{
    public $uses = array('TUser');
    private $__userInformation = array();
    public  $layout = 'login';

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('login', 'resetPassword', 'forgotPassword', 'confirmPassword');
    }

    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->__checkLogin()) {
                if ($this->Auth->login()) {
                    //rewrite session
                    $arr = $this->TUser->read(null, $this->Auth->User('id'));
                    unset($arr['TUser']['password']);
                    $this->Session->write('TUser', $arr);

                    if ($this->request->data('remember')) {
                        $data = $this->Auth->user();
                        $data['password'] = $this->Auth->password($this->request->data('TUser.password'));
                        $this->Cookie->write('TUser', $data, true, '2 weeks');
                    }
                    //delete session redirect -> when login again, redirect to the default of Auth->redirectUrl()
                    $this->Session->delete('Auth.redirect');

                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->set('error', 'Login fail!');
                    $this->Session->setFlash(__('Username or password is incorrect', null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
                }
            } else {
                $this->set('error', 'Login fail!');
                $this->Session->setFlash(__('Username or password is incorrect', null), 
                            'default', 
                             array('class' => 'flash-message-error text-danger'));
            }
        }
    }
    public function forgotPassword()
    {
        if ($this->request->is('post')) {
            $checkEmail = false;
            $data = $this->request->data;
            $email = $data['email'];
            $checkEmail = $this->__checkValidateEmail($email);
            if ($checkEmail == 1) {
                if ($this->_sendMail($data)) {
                    $message = "Check your email to reset password please!";
                    $this->set('message', $message);
                } else {
                    return false;
                }
            }
        }
    }

    public function resetPassword()
    {
        $this->__deleteSection();

        if (!$this->__checkEmailQuery()) {
            $this->layout = 'error_access';
            return;
        }
        $this->TUser->id = $this->__userInformation['id'];

        if ($this->request->is('post')) {
            // $checkError = false;
            $data = $this->request->data;
            $password = $data['password'];
            $value = array();
            $value['modified'] = date("Y-m-d H:i:s");
            $value['password'] = $password;

            //save to db
            try {
                $this->TUser->id = $this->__userInformation['id'];
                $this->TUser->save($value);
            } catch (Exception $e) {
                $error = "Have some error. Password has not changed. Please try again later.";
                $this->set('error', $error);
                return;
            }
            $this->Session->write('UserInformationChangePassword', $this->__userInformation);
            $this->redirect(array('action' => 'confirmPassword'));
        }
    }

    public function confirmPassword()
    {
        if ($this->Session->check('UserInformationChangePassword')) {
            $infoAccount = $this->Session->read('UserInformationChangePassword');
            $email = $infoAccount['email'];

            if (empty($email)) {
                $this->layout = 'error_access';
                return;
            }

            //delete session before redirect to confirm
            $this->__deleteSection();

            $this->set('email', $email);
        } else {
            $this->layout = 'error_access';
            return;
        }
    }

    private function __checkLogin()
    {
        if (isset($this->request->data['TUser']['email'])) {
            $email = $this->request->data['TUser']['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Wrong email format";
                $this->set('errorEmail', $errorEmail);
                return false;
            } else {
                return true;
            }
        } return false;
    }

    public function logout()
    {
        $this->autoLayout = false;
        $this->autoRender = false;

        $this->Session->destroy();
        $this->Cookie->destroy();

        return $this->redirect($this->Auth->logout());
    }

    private function __checkValidateEmail($email)
    {
        $checkEmail = false;
        $emailResult = array();
        //check email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Wrong email format";
            $this->set('error', $error);
            $checkEmail = true;
        }
        if (!$checkEmail) { //check existence email
            $data = $this->TUser->find('all', array('fields' => array('email')));
            foreach ($data as $value) {
                $emailResult[] = $value['TUser']['email'];
            }
            if (!in_array($email, $emailResult, true)) {
                $error = "Email does not exist!";
                $this->set('error', $error);
                return 0;
            } else {
                return 1;
            }
        }
    }

    protected function _sendMail($user)
    {
        if (!$user) {
            return false;
        }
        $mailer = new CakeEmail();
        $mailer->config('admin')
            ->template('set_new_pwd', null)
            ->subject('Welcome to the Make Happy Team')
            ->emailFormat('html')
            ->viewVars(array('user' => $user))
            ->to($user['email']);
        if ($mailer->send()) {
            return true;
        }
        return false;
    }

    private function __checkEmailQuery()
    {
        if (!isset($this->request->query['email']) || !$this->request->query['email']) {
            return false;
        }

        $email = base64_decode($this->request->query['email']);

        $user = $this->TUser->find('first', array('conditions' => array('TUser.email' => $email), "fields" => array('id', 'email')));

        if (!empty($user)) {
            $this->__email = $email;
            $this->__userInformation = $user['TUser'];
            return true;
        }

        return false;
    }

    private function __deleteSection()
    {
        if ($this->Session->check('UserInformationChangePassword')) {
            $this->Session->delete('UserInformationChangePassword');
        }
    }
}
