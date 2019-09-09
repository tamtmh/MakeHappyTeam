<?php

class TeamFixture extends CakeTestFixture {
    public $import = 'TTeam';

    public $records = array(
        array(
            'id' => 1,
            'name' => "Make Happy Team",
            'des' => "This is description MHT",
            'avatar' => '',
            'created' => '2019-06-05 10:07:30'
        ),
        array(
            'id' => 2,
            'name' => "Ours Team",
            'des' => "This is description Ours Team",
            'avatar' => 'abc1.jpg',
            'created' => '2019-07-05 10:07:30'
        ),
        array(
            'id' => 3,
            'name' => "Funnee Team",
            'des' => "This is description Funnee",
            'avatar' => '',
            'created' => '2019-08-05 10:07:30'
        ),
        array(
            'id' => 5,
            'name' => "XXX Team",
            'des' => "This is description XXX Team",
            'avatar' => 'abc3.jpg',
            'created' => '2019-09-05 10:07:30'
        ),
    );
}
