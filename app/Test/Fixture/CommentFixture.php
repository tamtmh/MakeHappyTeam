<?php

class CommentFixture extends CakeTestFixture {
    public $import = 'TComment';

    public $records = array(
        array(
            'id' => 1,
            'user_id' => '2',
            'report_id' => '1',
            'content' => 'Have a nice day',
            'created' => '2019-06-15 10:07:30'
        ),
        array(
            'id' => 2,
            'user_id' => '3',
            'report_id' => '1',
            'content' => 'Have a nice day',
            'created' => '2019-06-15 11:07:30'
        ),
        array(
            'id' => 3,
            'user_id' => '2',
            'report_id' => '1',
            'content' => '疲れました！',
            'created' => '2019-06-16 10:07:30'
        ),
    );
}