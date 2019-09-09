<?php

class RoleTeamFixture extends CakeTestFixture {
    public $import = 'TRoleTeam';

    public $records = array(
        array(
            'id' => 1,
            'name' => "Leader",
        ),
        array(
            'id' => 2,
            'name' => "Member",
        )
    );
}
