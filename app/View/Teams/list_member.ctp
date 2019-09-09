<hr>
<p>Leader:</p>
<?php
foreach ($allMemberTeam as $member):
    if ($member['TUserTeam']['role_team_id'] == 1):
        ?>
        <div class="avatar_menu" data-tooltip="<?= $member['TUser']['username']; ?>">
            <?= (isset($member['TUser']['avatar_user']) && !empty($member['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $member['TUser']['avatar_user']) : $this->Html->image("user.png") ?>
        </div>
    <?php endif; endforeach; ?>
<p>Member:</p>
<?php
foreach ($allMemberTeam as $member):
    if ($member['TUserTeam']['role_team_id'] == 2):
        ?>
        <div class="avatar_menu" data-tooltip="<?= $member['TUser']['username']; ?>">
            <?= (isset($member['TUser']['avatar_user']) && !empty($member['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $member['TUser']['avatar_user']) : $this->Html->image("user.png") ?>
        </div>
    <?php endif; endforeach; ?>
<div class="modal-footer">
    <div class="alert statusAddMember" role="alert"></div>
    <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Close
    </button>
</div>