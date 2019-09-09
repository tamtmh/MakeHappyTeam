<?php if(!empty($teamInfo)): ?>
<div class="tittle avatar_menu">
    <?= (!empty($teamInfo['TTeam']['avatar']) && file_exists(WWW_ROOT . 'img/avatar_team/'.$teamInfo['TTeam']['avatar'])) ? $this->Html->image('avatar_team/'.$teamInfo['TTeam']['avatar']) : $this->Html->image('logo.png'); ?>
    <span class="group">
		<div class="btn-group">
            <?php if(isset($listLeader) && !empty($listLeader)): ?>
            <input type="hidden" id="teamID" name="" value="<?= $teamInfo['TTeam']['id']; ?>">
            <a class="btn dropdown-toggle text-info textTeam" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $teamInfo['TTeam']['name']; ?>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#editTeamModalCenter">Edit Team</a>
                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#addAndEditMember">Member</a>
                    <a id="delete-team" href="" data-toggle="modal" data-target="#confirm-delete-team" data-id="<?php echo $teamInfo['TTeam']['id']; ?>" class="dropdown-item" href="#">Delete this team</a>
                </div>
            <?php else: ?>
            <a class="text-info textTeam" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $teamInfo['TTeam']['name']; ?>
                </a>
            <?php endif; ?>
		</div>
	</span>
    <?php  if(!empty($this->Session->read('TReport.created'))): ?>
    <span class="time">
		<i class="fa fa-calendar fa-lg" aria-hidden="true"></i>
		<?= date('Y-m-d',strtotime($this->Session->read('TReport.created'))); ?>
	</span>
    <?php endif; ?>
</div>
<?php endif; ?>