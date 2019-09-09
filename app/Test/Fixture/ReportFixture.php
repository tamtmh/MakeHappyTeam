<?php

class ReportFixture extends CakeTestFixture {
    public $import = 'TReport';

    public $records = array(
        array(
            'id' => 1,
            'user_id' => '1',
            'team_id' => '1',
            'emoji_id' => '1',
            'team_id' => '1',
            'score' => '90',
            'status' => 'have a nice day!',
            'report_status' => '0',
            'report_detail' => '',
            'created' => '2019-06-05 10:07:30'
        ),
        array(
            'id' => 2,
            'user_id' => '2',
            'team_id' => '1',
            'team_id' => '1',
            'emoji_id' => '2',
            'score' => '60',
            'status' => 'have a nice day!',
            'report_status' => '0',
            'report_detail' => '',
            'created' => '2019-06-05 10:07:30'
        ),
        array(
            'id' => 3,
            'user_id' => '2',
            'team_id' => '1',
            'emoji_id' => '1',
            'team_id' => '1',
            'score' => '90',
            'status' => 'have a nice day!',
            'report_status' => '2',
            'report_detail' => '{"2019-06-14 03:58:16":[{"Problem":"i have a good day","Did it affect to work?":"no","How did it affect to work?":"sfdsfgfg","How do you think how to fix the problem and affect?":"dgfhgfh","What do you want leader help you?":"dhgfh"}]}',
            'created' => '2019-06-06 10:07:30'
        ),
        array(
            'id' => 4,
            'user_id' => '3',
            'team_id' => '1',
            'emoji_id' => '1',
            'team_id' => '1',
            'score' => '90',
            'status' => 'have a nice day!',
            'report_status' => '2',
            'report_detail' => '{"2019-06-10 10:09:17":[{"Problem":"aaaaa","Did it affect to work?":"yes","How did it affect to work?":"ddddd","How do you think how to fix the problem and affect?":"dddd","What do you want leader help you?":"dddasda"}]}',
            'created' => '2019-06-05 10:07:30'
        )
    );
}
