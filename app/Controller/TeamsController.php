<?php
App::uses('AppController', 'Controller');

class TeamsController extends AppController {
    public $uses = array('TUser', 'TTeam', 'TUserTeam', 'TReport');

    public function index() {

    }

    public function addTeam() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $params = array();
            if (isset($_FILES['file']) && !empty($_FILES['file']) && ($_FILES['file']['error'] == 0)) {
                $dataInput = $this->request->data;
                // PHP-unserialize a jQuery-serialized form
                parse_str($dataInput, $params);
                $name_upload = $this->nameAvartar($_FILES);
                $params['avatar'] = $name_upload;
                $folder = WWW_ROOT.'img/avatar_team/';
                if (!file_exists($folder)) {
                    mkdir($folder);
                }
                $this->moveUploadFile($_FILES, $name_upload, $folder);
            } else {
                $dataInput = $this->request->data[0];
                // PHP-unserialize a jQuery-serialized form
                parse_str($dataInput, $params);
            }
            $dataInput = $params;

            $this->TTeam->validator()->add('name', 'isUnique', array(
                    'rule' => array('isUnique'),
                    'message' => 'This Name is already registered'
                ));
            $this->TTeam->set($dataInput);
            if ($this->TTeam->validates()) {
                $this->TTeam->create();
                if ($this->TTeam->save($dataInput)) {
                    # Leader is persion create group
                    $idTeam = $this->TTeam->getLastInsertId();
                    $dataMember[] = array(
                        'user_id' => $this->Auth->user()['id'],
                        'team_id' => $idTeam,
                        'role_team_id' => 1,
                        'created' => date("Y-m-d H:i:s")
                    );
                    $dataSendNotification = [];

                    # List member added
                    if (isset($dataInput['members']) && !empty($dataInput['members'])) {
                        foreach ($dataInput['members'] as $memberID) {
                            $dataSendNotification[] = $memberID;
                            $dataMember[] = array(
                                'user_id' => $memberID,
                                'team_id' => $idTeam,
                                'role_team_id' => 2,
                                'created' => date("Y-m-d H:i:s")
                            );
                        }
                    }
                    $this->TUserTeam->saveMany($dataMember);

                    # Send Notification to member added
                    if (isset($dataInput['members']) && !empty($dataInput['members'])) {
                        $linkReport = "/reports?teamid=" . $idTeam;
                        $from = $this->Auth->user()['id'];
                        $content = "<a href=" . $linkReport . ">added you to the group " . $dataInput['name'] . "</a>";
                        if($this->Notification->send($from, $dataSendNotification, $content)){
                            $this->_sendRealtime($dataSendNotification);
                        }
                    }

                    $response['status'] = 1;
                    $response['message'] = $dataInput['name'] . ' created success!';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Whoop!! Error can\'t save data';
                }
            } else {
                $response['status'] = 0;
                $response['message'] = $this->TTeam->validationErrors;
            }
            return json_encode($response);
        }
    }

    public function addMember() {
        $this->autoRender = false;

        if ($this->request->is('ajax') || $this->request->is('post')) {
            if (!empty($_POST['userID']) && !empty($_POST['team_id']) && !empty($_POST['team_name'])) {
                $dataAddMembers = [];
                foreach ($_POST['userID'] as $userID) {
                    $dataAddMembers[] = [
                        'user_id' => $userID,
                        'team_id' => $_POST['team_id'],
                        'created' => date("Y-m-d H:i:s")
                    ];
                }
                if ($this->TUserTeam->saveMany($dataAddMembers)) {
                    $linkReport = "/reports?teamid=" . $_POST['team_id'];
                    $content = "<a href=" . $linkReport . ">added you to the group " . $_POST['team_name'] . "</a>";
                    $idLogin = $this->Auth->user()['id'];

                    if($this->Notification->send($idLogin, $_POST['userID'], $content)){
                        $this->_sendRealtime($_POST['userID']);$this->_sendRealtime($_POST['userID']);
                    }

                    $response['status'] = 1;
                    $response['message'] = 'Add member success!';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Whoop!! Error can\'t add member';
                }
                return json_encode($response);
            }
            return false;
        }
    }

    public function deleteMember() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $user_id = $this->Auth->user()['id'];
        
        if($this->request->is('ajax') || $this->request->is('post')) {
            $team_id = $this->request->data('teamId');
            $memberIDs = $this->request->data('memberIDs');

            $userData = $this->TUserTeam->find('first', array('fields' => array('role_team_id'), 'conditions' => array('user_id' => $user_id, 'team_id' => $team_id)));

            $conditionDelete = array('id' => $memberIDs);
            if($userData['TUserTeam']['role_team_id'] == '1') {
                if($this->TUserTeam->deleteAll($conditionDelete, false)) {
                    return true;
                } 
                return false;
            }
            return false;
        }
        return false;
    }

    public function deleteTeam() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $user_id = $this->Auth->user()['id'];

        if($this->request->is('ajax') || $this->request->is('post')) {
            $team_id = $this->request->data('team_id');
            $userData = $this->TUserTeam->find('first', array('fields' => array('role_team_id'), 'conditions' => array('user_id' => $user_id, 'team_id' => $team_id)));
            $conditionDelete = array('team_id' => $this->request->data('team_id'));
            $teamData = $this->TTeam->find('first', array('fields' => array('avatar', 'name'), 'conditions' => array('id' => $team_id)));
            $this->TTeam->id = $team_id;
            if($userData['TUserTeam']['role_team_id'] == '1') {
                if($this->TTeam->delete()) {
                    $this->TUserTeam->deleteAll($conditionDelete, false);
                    $this->TReport->deleteAll($conditionDelete, false);
                    if(isset($teamData['TTeam']['avatar']) && !empty($teamData['TTeam']['avatar'])) {
                        if(file_exists(WWW_ROOT . 'img/avatar_team/' . $teamData['TTeam']['avatar'])){
                            unlink('img/avatar_team/' . $teamData['TTeam']['avatar']);
                        }
                    }
                } 
                return false;
            }
            return false;
        }
        return false;
    }

    public function editTeam() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($this->request->is('post') || $this->request->is('ajax')) {
            $params = array();
            $dataInput = $this->request->data[0];            
            parse_str($dataInput, $params);
            if (isset($_FILES['file']) && !empty($_FILES['file']) && ($_FILES['file']['error'] == 0)) {
                $name_upload = $this->nameAvartar($_FILES);
                $params['avatar'] = $name_upload;
                //delete image in folder "avatar_team"
                $data = $this->TTeam->findById($params['team_id']);
                $folder = WWW_ROOT.'img/avatar_team/';
                if (file_exists($folder.$data['TTeam']['avatar'])) {
                    unlink($folder.$data['TTeam']['avatar']);
                }
                $this->moveUploadFile($_FILES, $name_upload, $folder);
            }

            $dataInput = $params; //team_id, name, des
            if (isset($this->request->data['dataMembers']) && !empty($this->request->data['dataMembers'])) {
                $dataMembers = json_decode($this->request->data['dataMembers'], true);
                # Format Data
                $arr_dataMember = array();
                if (isset($dataMembers) && !empty($dataMembers)) {
                    foreach ($dataMembers as $key => $val) {
                        foreach ($val as $k => $v) {
                            $arr_dataMember[$k] = $v;
                        }
                    }
                }
                // update role members in team
                $this->changePermission($dataInput['team_id'], $arr_dataMember);
            }
            //update info team
            if (isset($dataInput['team_id']) && !empty($dataInput['team_id'])) {
                $team = $this->TTeam->read('name', $dataInput['team_id']);
                if($team['TTeam']['name'] == $dataInput['name']) {
                    if ($this->TTeam->save($dataInput)) {
                        $response['status'] = 1;
                        $response['message'] = $dataInput['name'] . ' is edited successful!';
                    }
                }else {
                    $this->TTeam->validator()->add('name', 'isUnique', array(
                        'rule' => array('isUnique'),
                        'message' => 'This Name is already registered'
                    ));

                    if ($this->TTeam->validates()) {
                        $this->TTeam->id = $dataInput['team_id'];
                        if ($this->TTeam->save($dataInput)) {
                            $response['status'] = 1;
                            $response['message'] = $dataInput['name'] . ' is edited successful!';
                        } else {
                            $response['status'] = 0;
                            $response['message'] = 'Whoop!! Error can\'t save data';
                        }
                    } else {
                        $response['status'] = 0;
                        $response['message'] = $this->TTeam->validationErrors;
                    }
                }

            } else {
                $response['status'] = 0;
                $response['message'] = "Not exists team_id, please check again!";
            }
            return json_encode($response);
        }
    }

    public function editMembers() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $teamID = $this->request->data('teamId');
            $dataList = $this->request->data('dataList');
            # Format Data
            $data = array();
            foreach ($dataList as $key => $val) {
                foreach ($val as $k => $v) {
                    $data[$k] = $v;
                }
            }
            return $this->changePermission($teamID, $data);
        }
        return false;
    }

    public function changePermission($teamID, $dataList) {
        if (!$teamID)
            return false;
        if (isset($dataList) && !empty($dataList)) {
            $dataMembers = [];
            foreach ($dataList as $id => $role) {
                $dataMembers[] = [
                    'id' => $id,
                    'role_team_id' => $role,
                    'modified' => date("Y-m-d H:i:s")
                ];
            }
            if ($this->TUserTeam->saveMany($dataMembers)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function getMember() {
        $this->layout = 'ajax';

        if ($this->request->is('ajax') || $this->request->is('post')) {

            $listMemberInTeam = $this->listMemberInTeam($this->request->data['teamID'], $this->Auth->user()['id']);

            if ($this->request->data['tab'] === 'list-edit-member') {
                $listRoleTeam = $this->TRoleTeam->find('all');
                $this->set(compact('listMemberInTeam', 'listRoleTeam'));

                $this->render('/Teams/list_editmember');
            }

            if ($this->request->data['tab'] === 'list-add-member') {
                $listMemberInTeam = $this->listMemberInTeam($this->request->data['teamID']);
                $listMember = [];
                foreach ($listMemberInTeam as $result) {
                    $listMember[] = $result['TUserTeam']['user_id'];
                }
                $this->set('listAddMember', $this->TUser->find('all', array(
                    'conditions' => array('id NOT IN' => $listMember),
                    'fields' => array('id', 'username')
                )));

                $this->render('/Teams/list_addmember');

            }

            if ($this->request->data['tab'] === 'list-member') {
                $this->set('allMemberTeam', $this->listMemberInTeam($this->request->data('teamID')));

                $this->render('/Teams/list_member');
            }
        }
    }
}
