<div class="addTeam">
    <span><?php echo (isset($pageLeader) && $pageLeader) ? 'Manage Team' : 'All Team'; ?></span>
    <a href="" data-toggle="modal" data-target="#addTeamModalCenter">
        <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
    </a>
</div>
<div class="nameTeam">
    <ul>
        <?php if (isset($listTeams) && !empty($listTeams)): ?>
            <?php foreach ($listTeams as $team) : ?>
                <li class="<?php echo(($team['TTeam']['id'] == $this->request->query('teamid')))? 'active' : ''; ?>">
                    <a href="?teamid=<?php echo $team['TTeam']['id']; ?>" class="avatar_menu">
                        <?= (!empty($team['TTeam']['avatar']) && WWW_ROOT . 'img/avatar_team/'.$team['TTeam']['avatar']) ? $this->Html->image('avatar_team/'.$team['TTeam']['avatar']) : $this->Html->image('logo.png'); ?>
                        <span id="team-name<?php echo $team['TTeam']['id']; ?>"><?php echo $team['TTeam']['name']; ?></span>
                    </a>
                </li>
            <?php endforeach ?>
        <?php endif; ?>
    </ul>
</div>

