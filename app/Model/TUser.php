<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class TUser extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_user';
    public $name = 'TUser';
    public $validate = array(
        'username' => array(
            "rule1" => array(
                "rule" =>  "/^[a-z_]([a-zA-Z0-9_]){5,}$/i", //"/^[a-z0-9_.]{5,}$/i",
                "message" => "Username only letters and integers and '_', min 6 characters",
             ),
             "rule2" =>array(
                "rule" => "isUnique",
                "message" => "The username has already registered",
             )
        ),
        'email' => array(
            'rule1' => array(
                "rule" => "isUnique",
                "message" => "The email has already registered",
            ),
            'rule2' => array(
                'rule' => array('email', true),
                'message' => 'Please supply a valid email address.'
            )
        ),

        'password' => array(
            'rule1' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Minimum 6 characters long'
            )
        ),
    );    

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

    
}