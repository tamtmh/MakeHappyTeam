<?php

class HomesController extends AppController {
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    public  $layout = 'login';
    public function index() {

    }
}

