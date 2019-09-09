<?php
App::uses('Model', 'Model');

class TTeam extends AppModel {
    public $useDbConfig = 'default';
    public $useTable = 't_team';
    public $name = 'TTeam';

    public $validate = array(
        'name' => array(
            array(
                "rule" => "notBlank",
                "message" => "Name not blank!",
            )
        )
    );
}