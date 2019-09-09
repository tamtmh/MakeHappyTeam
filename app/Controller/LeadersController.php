<?php
App::uses('AppController', 'Controller');
class LeadersController extends AppController {
    public $uses = array("TReport", 'TUser', 'TUserTeam');
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    public $paginate = array(
        'limit' => 10,
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->getListTeam('leader');
        $this->set('listTeams', $this->teams);
        $this->set('pageLeader', 1);
        $this->set('mn_active', 'leaders');

        if(!empty($this->teams)) {
            $teamID = $this->teams[0]['TTeam']['id'];
            if (isset($this->request['url']['teamid']) && !empty($this->request['url']['teamid'])) {
                $teamID = $this->request['url']['teamid'];
            }
            $this->initDataTeam($teamID);
        }
    }

    public function team() {
        $this->Session->delete('TReport.created');
        $this->TReport->bindModel(
            array('belongsTo' => array(
                'TUser' => array(
                    'className' => 'TUser',
                    'foreignKey' => 'user_id'
                )
            ))
        );
        if (isset($this->request->query['date']) && !empty($this->request->query['date'])) {
            $date = $this->request->query['date'];
        } else {
            $date = date('Y-m-d');
        }

        if (isset($this->request->query['teamID']) && !empty($this->request->query['teamID'])) {
            $this->team['TTeam']['id'] = $this->request->query['teamID'];
        }

        $this->set('today', $date);
        $this->Paginator->settings = array(
            'conditions' => array(
                'TReport.team_id' => $this->team['TTeam']['id'],
                'DATE(TReport.created)' => $date
            ),
            'order' => array('TReport.created' => 'desc')
        );

        $results = $this->Paginator->paginate("TReport");
        $this->set("results",$results);
        $this->set('pageCount', $this->request->params['paging']['TReport']['pageCount']);
        if($this->request->is('ajax') || $this->request->is('post')){
            $this->layout = 'ajax';
            $this->redirect(array('action' => 'list_report'));
        }
        $this->set ('title_for_layout', $this->team['TTeam']['name']);
    }

    public function listReport(){
        $this->layout = 'ajax';
        $this->TReport->bindModel(
            array('belongsTo' => array(
                'TUser' => array(
                    'className' => 'TUser',
                    'foreignKey' => 'user_id'
                )
            ))
        );
        if($this->request->is('ajax') || $this->request->is('post')){
            $date = $this->request->data['dateReport'];
            $date = explode(' - ', $date);
            $startDate = date("Y/m/d", strtotime($date[0]));
            $endDate = date("Y/m/d", strtotime($date[1]));
            if (isset($this->request->data['teamID']) && !empty($this->request->data['teamID'])) {
                $teamID = $this->request->data['teamID'];
            } else{
                $teamID = $this->team['TTeam']['id'];
            }
            if (isset($date) && !empty($date)) {
                $this->Paginator->settings = $this->paginate;
                if (isset($this->request->data['member']) && !empty($this->request->data['member'])) {
                    $member = $this->request->data['member'];
                    $results = $this->Paginator->paginate("TReport", array(
                        'TReport.team_id' => $teamID,
                        array(
                            'DATE(TReport.created) >=' => $startDate,
                            'DATE(TReport.created) <= ' => $endDate,
                        ),
                        'user_id' => $member
                    ));
                } else {
                    $results = $this->Paginator->paginate("TReport", array(
                        'TReport.team_id' => $teamID,
                        array(
                            'DATE(TReport.created) >=' => $startDate,
                            'DATE(TReport.created) <= ' => $endDate,
                        )
                    ));
                }
                $this->set('results', $results);
                $this->set('pageCount', $this->request->params['paging']['TReport']['pageCount']);
            } else {
                $this->set('results', 'Empty');
            }
        }
    }

    public function sendRequest(){
        $this->autoRender = false;
        if($this->request->is('ajax') || $this->request->is('post')){
            $this->layout = 'ajax';
            $idLogin = $this->Auth->user()['id'];
            $to = array( $_POST['toID']);
            $content = $_POST['content'];
            $status = 1;
            $reportID = $_POST['reportID'];
            $this->TReport->id = $reportID;
            $this->TReport->set('report_status', $status);
            if($this->TReport->save()){
                if($this->Notification->send($idLogin, $to, $content)){
                    $this->_sendRealtime($to);
                }

                return true;
            }
        }
        return false;
    }
}

