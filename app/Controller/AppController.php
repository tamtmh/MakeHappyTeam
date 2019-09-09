<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

App::import('Vendor', 'vendor', array('file' => 'autoload.php'));

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package        app.Controller
 * @link        https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $uses = array('TUser', 'TUserTeam', 'TTeam', 'TRoleTeam');
    public $teams = null;
    public $team; //use edit team and show report controller
    public $pusher;

    public $components = array(
        'Flash',
        'Cookie',
        'Session',
        'Notification',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'Logins',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'reports',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'homes',
                'action' => 'index'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'userModel' => 'TUser',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    )
                )
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        ## init Pusher Object
        $this->_getPusher();

        $this->set($this->checkNotification());
        $authUser = $this->Auth->user();
        $this->set('authUser', $authUser);

        # List Account
        $this->set('listAccount', $this->getListAccount());

        # List Team
        $this->getListTeam();
        $this->set('listTeams', $this->teams);
        if (isset($authUser)) {
            if (!empty($this->teams)) {
                $teamID = $this->teams[0]['TTeam']['id'];
                if (isset($this->request['url']['teamid']) && !empty($this->request['url']['teamid'])) {
                    $teamID = $this->request['url']['teamid'];
                }
                $this->initDataTeam($teamID);
            }
        }

        //get list role_team
        $listRoleTeam = $this->TRoleTeam->find('all');
        $this->set('listRoleTeam', $listRoleTeam);

        // When $this->contents return null
        // For Mock Objects and Debug >= 2 allow all (this is for PHPUnit Tests)
        if (preg_match('/Mock_/', get_class($this)) && Configure::read('debug') >= 2) {
            $this->Auth->allow();
        }
    }

    protected function _getPusher(){

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $this->pusher = new Pusher\Pusher(
            '5c94ee7d8dcf8c4bdcd6',
            '7da4b25d263fff8c2606',
            '855352',
            $options
        );

        return $this->pusher;
    }

    protected function _sendRealtime($dataTo){
        $dataMessages = [];
        foreach ($dataTo as $memberID) {
            $dataMessages[$memberID]['num'] = $this->Notification->getNumberNewNoti($memberID);
            $dataMessages[$memberID]['data'] = $this->Notification->getLastestNotification($memberID);
        }
        $this->pusher->trigger('notification', 'e_tmh-noti', $dataMessages);
    }

    public function initDataTeam($teamID) {
        # list add member
        $dataMember = $this->getListAddMember($teamID);

        # list leader of team
        $listLeader = $this->getListLeaderOfTeam($teamID);

        # get info team
        $this->team = $this->TTeam->find('first', array(
            'conditions' => array('id' => $teamID),
            'fields' => array('id', 'name', 'des', 'avatar')
        ));

        $listMemberInTeam = $dataMember['listMemberInTeamExcept'];
        $listAddMember = $dataMember['listAddMember'];
        $this->set('teamInfo', $this->team);
        $this->set(compact('listMemberInTeam', 'listAddMember', 'listLeader'));
    }

    public function checkNotification($uid = null) {
        $uid = (!$uid) ? $this->Auth->user()['id'] : $uid;

        $listNotice = $this->Notification->check($uid);

        $numberNoRead = 0;
        foreach ($listNotice as $value) {
            if ($value['TNotification']['read'] == 0) {
                $numberNoRead++;
            }
        }
        return compact('numberNoRead', 'listNotice');
    }

    public function getListAccount() {
        return $this->TUser->find('all', array(
            'conditions' => array('id !=' => $this->Auth->user()['id']),
            'fields' => array('id', 'username', 'email'),
            'order' => array('id ASC')
        ));
    }

    public function getListTeam($options = null) {
        $this->TUserTeam->bindModel(
            array('belongsTo' => array(
                'TTeam' => array(
                    'className' => 'TTeam',
                    'foreignKey' => 'team_id'
                )
            ))
        );
        $params['conditions'] = array('user_id' => $this->Auth->user()['id']);
        if ($options !== null) {
            $params['conditions']['role_team_id'] = 1;
        }
        return $this->teams = $this->TUserTeam->find('all', $params);
    }

    public function getListAddMember($teamID) {
        //Get the list member in the team except user login
        $data['listMemberInTeamExcept'] = $this->listMemberInTeam($teamID, $this->Auth->user()['id']);

        //Get the list members not in the team
        $listMemberOfTeam = $this->listMemberInTeam($teamID);

        //all member of team
        $this->set('allMemberTeam', $listMemberOfTeam);
        $listMember = [];
        foreach ($listMemberOfTeam as $result) {
            $listMember[] = $result['TUserTeam']['user_id'];
        }
        $data['listAddMember'] = $this->TUser->find('all', array(
            'conditions' => array('id NOT IN' => $listMember),
            'fields' => array('id', 'username')
        ));

        return $data;
    }

    public function listMemberInTeam($teamID, $exceptID = null) {
        $this->TUserTeam->bindModel(
            array('belongsTo' => array(
                'TUser' => array(
                    'className' => 'TUser',
                    'foreignKey' => 'user_id'
                )
            ))
        );

        $params['conditions'] = array('team_id' => $teamID);
        if ($exceptID !== null) {
            $params['conditions']['user_id !='] = $exceptID;
        }
        return $this->TUserTeam->find('all', $params);
    }

    public function getListLeaderOfTeam($teamID) {
        return $this->TUserTeam->find('all', array(
            'conditions' => array('team_id' => $teamID, 'user_id' => $this->Auth->user()['id'], 'role_team_id' => 1),
            'fields' => array('user_id')
        ));
    }

    public function nameAvartar($file) {
        $ext = explode('.', $file['file']['name']);
        $ext = $ext[(count($ext) - 1)];
        return strtotime("now").'.'.$ext;
    }
    public function moveUploadFile($file, $name_upload, $folder) {
        if (move_uploaded_file($file['file']['tmp_name'], $folder.$name_upload)) {
            return true;
        }
        return false;
    }
}