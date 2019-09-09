<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-first" style="padding: 5px">
        <?php echo $this->Html->image('logo1.jpg', array('class' => 'logoweb')); ?>
        <span class="title-logo">Tribal Media House</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto menu-left">
                <?php if ($authUser) : ?>
                <li class="nav-item">
                    <a class="nav-link menu-children menu-reports <?= (isset($mn_active) && $mn_active === 'reports') ? 'active': ''; ?>" href="/reports/">
                        <i class="fa fa-area-chart" aria-hidden="true"></i> Report
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-children <?= (isset($mn_active) && $mn_active === 'leaders') ? 'active': ''; ?>" href="/leaders/team">
                        <i class="fa fa-list" aria-hidden="true"></i> Manager
                        <span class="sr-only">(current)</span></a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav mr-right menu-right">
                <?php if ($authUser) : ?>
                <li class="dropdown iconInfo" id="<?= $authUser['id']; ?>" data-uid="<?= $authUser['id']; ?>">
                    <a href="#" class="numberNotifi" id="not-no-read" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell fa-lg bell-noti" aria-hidden="true" ></i>
                        <span class="p1 fa-stack fa-lg count-notification-show" style="<?= ($numberNoRead ===0)? 'visibility: hidden;' : ''; ?>"  data-count="<?php echo $numberNoRead;?>"></span>
                    </a>
                    <ul class="dropdown-menu notify-drop" id="list-notification">
                        <div class="notify-drop-title">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">Notifications (<b class="number-unread"><?php echo $numberNoRead; ?></b>)</div>
                            </div>
                        </div>
                        <div class="drop-content">
                            <?php if(!empty($listNotice)): ?>
                                <?php foreach($listNotice as $notifi): ?>
                                <li data-id="<?php echo $notifi['TNotification']['id']; ?>" class="row <?= ($notifi['TNotification']['read'] == 0 || $notifi['TNotification']['read'] == 1) ? 'unread' : 'read';?>">
                                    <div class="col-md-2 col-sm-2 col-xs-2 col-2">
                                        <span class="avatar_menu">
                                            <?= (isset($notifi['TUser']['avatar_user']) && !empty($notifi['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $notifi['TUser']['avatar_user']) : $this->Html->image("user.png"); ?>
                                        </span>
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-10 col-10 contentNofi">
                                        <span><a href="#" class="nameUser"><?= $notifi['TUser']['username']; ?></a></span>
                                        <span class="message url-redirect">
                                            <?php echo $notifi['TNotification']['content']; ?>
                                        </span>
                                        <p href="" class="rIcon">
                                            <i class="fa fa-dot-circle-o <?= ($notifi['TNotification']['read'] == 0 || $notifi['TNotification']['read'] == 1) ? 'text-success' : 'text-muted'; ?>"></i>
                                        </p><br/>
                                        <p class="timeNotifi"><?php echo $notifi['TNotification']['created']; ?></p>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            <?php else: ?>
                                <p class="text-center" style="margin-top: 20px; font-weight: 500; color: #4c7ebf;">
                                    No notifications!
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="notify-drop-footer text-center">
                            <a href="/notifications"><i class="fa fa-eye"></i> All Notification</a>
                        </div>
                    </ul>
                </li>
                <li>
                    <span class="avatar_menu avatar_user">
                        <?= (isset($authUser['avatar_user']) && !empty($authUser['avatar_user'])) ? $this->Html->image("avatar_user/" . $authUser['avatar_user']) : $this->Html->image("user.png") ?>
                    </span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-header" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $authUser['username'] ?>
                    </a>
                    <div class="dropdown-menu show-profile" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#user-profile">Profile</a>
                        <a class="dropdown-item" href="/leaders/team">Manager</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/Logins/logout">Logout</a>
                    </div>
                </li>
                <?php else : ?>
                <li class="home-logout">
                    <a class="home" href="/homes">Home</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>