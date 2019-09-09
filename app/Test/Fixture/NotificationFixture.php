<?php

class NotificationFixture extends CakeTestFixture {
    public $import = 'TNotification';

    public $records = array(
        array(
            'id' => 1,
            'user_id' => '2',
            'from_id' => 3,
            'read' => '0',
            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
            'created' => '2019-06-15 10:07:30'
        ),
        array(
            'id' => 2,
            'user_id' => '2',
            'from_id' => 3,
            'read' => '1',
            'content' => '<a href="/reports/create/1">Thaovtp requires you create detail content of reports</a>',
            'created' => '2019-06-16 10:07:30'
        ),
        array(
            'id' => 3,
            'user_id' => '2',
            'from_id' => 1,
            'read' => '2',
            'content' => '<a href=\'/leaders/team?date=2019-07-09\'> created report day 2019-07-09</a>',
            'created' => '2019-06-17 10:07:30'
        ),
    );
}