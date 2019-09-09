<?php
App::uses('AppController', 'Controller');

App::import('Vendor', 'vendor', array('file' => 'autoload.php'));

use Stichoza\GoogleTranslate\GoogleTranslate;

class ReportsController extends AppController {
    public $uses = array('TReport', 'TComment', 'TUser', 'TUserTeam');
    public $components = array('Paginator');
    public $helpers = array('Paginator');
    public $paginate = array(
        'limit' => 10,
        'order' => array('created' => 'desc'),
    );

    public function index() {
        $this->Session->delete('TReport.created');

        $this->set('mn_active', 'reports');
        $this->set('today', date('Y-m-d'));
        $dataToday = $this->TReport->find('first', array(
            'conditions' => array(
                'user_id' => $this->Auth->user()['id'],
                'team_id' => $this->team['TTeam']['id'], //$this->teamID,
                'DATE(created)' => date('Y-m-d'),
            ),
            'order' => array('TReport.created' => 'desc')
        ));

        if ((count($dataToday) > 0)) {
            $this->set('report', $dataToday);
        }

        $this->Paginator->settings = array(
            'conditions' => array(
                'user_id' => $this->Auth->user()['id'],
                'TReport.team_id' => $this->team['TTeam']['id']
            ),
            'order' => array('TReport.created' => 'desc')
        );

        $results = $this->Paginator->paginate("TReport");
        $this->set ('title_for_layout', $this->team['TTeam']['name']);
        $this->set("results", $results);
        $this->set('pageCount', $this->request->params['paging']['TReport']['pageCount']);
    }

    public function addReport() {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $data = array();
        $error = array();
        $data['TReport'] = $this->request->data;
        $data['TReport']['status'] = $this->request->data('comment');
        $this->TReport->set($data);
        if ($this->TReport->validates($data)) {
            $data['TReport']['user_id'] = $this->Auth->user()['id'];
            if (empty($this->request->data('team_id')))
                return false;
            $teamID = $this->request->data('team_id');
            $checkData = $this->TReport->checkReportTodayByTeam($this->Auth->user()['id'], $teamID);
            if ($checkData == 0) {
                if ($this->TReport->save($data)) {
                    $idLogin = $this->Auth->user()['id'];

                    //list leader
                    $leaderList = $this->TUserTeam->getLeaderList($teamID, $idLogin);
                    $to = [];
                    foreach ($leaderList as $result) {
                        $to[] = $result['TUserTeam']['user_id'];
                    }

                    //send notification
                    $content = "<a href='/leaders/team?teamid=" . $this->request->data('team_id') . "&date=" . date('Y-m-d') . "'> created report day " . date('Y-m-d') . "</a>";
                    if($this->Notification->send($idLogin, $to, $content)){
                        $this->_sendRealtime($to);
                    }
                    $response = $this->TReport->find('first', array(
                        'conditions' => array(
                            'emoji_id' => $data['TReport']['emoji_id'],
                            'score' => $data['TReport']['score'],
                            'status' => $data['TReport']['status']
                        ),
                        'fields' => array('emoji_id', 'score', 'status', 'report_status', 'DATE(created)')
                    ));
                    return json_encode(array('success' => $response));
                } else {
                    $error[] = "Not save ";
                    return json_encode(array('error' => $error));
                }
            }
        } else {
            $error = $this->TReport->validationErrors;
            if (isset($error['emoji_id'])) {
                return json_encode(array('error' => $error['emoji_id'][0]));
            }
            if (isset($error['status'])) {
                return json_encode(array('error' => $error['status'][0]));
            }
        }
    }

    public function detail($id = null) {
        $this->Session->delete('TReport.created');

        $this->set('mn_active', 'reports');
        $this->set('hideSidebar', 1);
        if (!$id)
            return $this->redirect(array('controller' => 'reports', 'action' => 'index'));

        //info report
        $report = $this->TReport->getReportByID($id);
        if (empty($report['TReport']['report_detail']))
            return $this->redirect(array('controller' => 'reports', 'action' => 'index'));
        $this->Session->write('TReport.created', $report['TReport']['created']);
        $contentDetail = json_decode($report['TReport']['report_detail'], true);
        $dayDetail = key($contentDetail);
        $report['TReport']['day_detail'] = $dayDetail;
        $report['TReport']['report_detail'] = $contentDetail[$dayDetail];

        //list comment
        $comment = $this->TComment->getCommentList($id);

        $this->set ('title_for_layout', $this->team['TTeam']['name'].' - detail');
        $this->set(compact('report', 'comment'));
    }

    public function translateReport() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if (!empty($_POST['to_lan']) && !empty($_POST['text'])) {
            $tr = new GoogleTranslate($_POST['to_lan']);
            $text = $_POST['text'];
            $result = $tr->translate($text);
            return preg_replace('/\/\s/', '/', $result);
        }
    }

    public function create($id) {
        $this->Session->delete('TReport.created');

        $this->set('mn_active', 'reports');
        $this->set('hideSidebar', 1);
        if (!$id)
            return false;

        $report = $this->TReport->read('id,emoji_id,team_id,score,status,report_detail,created', $id);
        $this->Session->write('TReport.created', $report['TReport']['created']);
        if (empty($report) && count($report) == 0)
            return false;
        if ($report['TReport']['report_detail'] != '')
            $this->redirect('/reports/detail/' . $id);
        if ($this->request->is('post') && $this->request->data['TReport']['Problem'] !== '') {
            $now = date("Y-m-d H:i:s");
            $data[$now][] = $this->request->data['TReport'];
            $this->TReport->id = $id;
            $this->TReport->set('report_status', 2);
            $this->TReport->set('report_detail', json_encode($data));
            if ($this->TReport->save()) {
                //list leader
                $leaderList = $this->TUserTeam->getLeaderList($report['TReport']['team_id'], $this->Auth->user()['id']);
                foreach ($leaderList as $result) {
                    $to[] = $result['TUserTeam']['user_id'];
                }
                //send notification
                $idLogin = $this->Auth->user()['id'];
                $linkReport = "/reports/detail/" . $id;
                $content = "<a href=" . $linkReport . "> completed detail report</a>";
                if ($this->Notification->send($idLogin, $to, $content)) {
                    $this->_sendRealtime($to);
                    $this->redirect('/reports/detail/' . $id);
                }
            }
        }
        $this->set ('title_for_layout', $this->team['TTeam']['name'].' - create detail');
        $this->set('report', $report);
    }
}


