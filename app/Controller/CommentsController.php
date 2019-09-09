<?php
App::uses('AppController', 'Controller');

class CommentsController extends AppController {
    public $uses = array('TComment');

    public function addComment() {
        $this->autoRender = false;
        $idLogin = $this->Auth->user()['id'];
        if($this->request->is('ajax') || $this->request->is('post')){
            if(!empty($_POST['content']) && !empty($_POST['report_id'])) {
                $this->request->data['user_id'] = $idLogin;
                $this->request->data['created'] = date("Y-m-d H:i:s");
                if($this->TComment->save($this->request->data)){
                    //send notification
                    $linkReport = "/reports/detail/". $_POST['report_id'];
                    $content = "<a href=". $linkReport .">commented on the report detail</a>";
                    if($idLogin == $_POST['user_report']) {
                        //list leader
                        $leaderList = $this->TUserTeam->getLeaderList($this->request->data('team_id'), $idLogin);
                        $to = [];
                        foreach ($leaderList as $result) {
                            $to[] = $result['TUserTeam']['user_id'];
                        }
                        if($this->Notification->send($idLogin, $to, $content)) {
                            $this->_sendRealtime($to);
                            return true;
                        }
                    }else {
                        $to = array($_POST['user_report']);
                        if($this->Notification->send($idLogin, $to, $content)){
                            $this->_sendRealtime($to);
                        }
                        return true;
                    }
                }
            }
            return false;
        }

        return false;
    }

    public function getListComment($id){
        $this->layout = 'ajax';
        if(!$id) return false;
        $listComment = $this->TComment->getCommentList($id);
        $this->set('comment', $listComment);
    }
}
