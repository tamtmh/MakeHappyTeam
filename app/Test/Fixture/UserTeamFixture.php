<?php

class UserTeamFixture extends CakeTestFixture {
    public $import = 'TUserTeam';

    public $records = array(
        array(
            'id' => 1,
            'user_id' => 1,
            'team_id' => 1,
            'role_team_id' => 1,
            'created' => '2019-06-05 10:07:30',
            'modified' => '2019-06-05 10:07:30'
        ),
        array(
            'id' => 2,
            'user_id' => 2,
            'team_id' => 1,
            'role_team_id' => 1,
            'created' => '2019-06-05 10:07:30',
            'modified' => '2019-06-05 10:07:30'
        ),
        array(
            'id' => 3,
            'user_id' => 3,
            'team_id' => 1,
            'role_team_id' => 2,
            'created' => '2019-06-05 10:07:30',
            'modified' => '2019-06-05 10:07:30'
        )
    );
}
