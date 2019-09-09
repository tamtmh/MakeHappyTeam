<p id="list-notifi"><i class="fa fa-bars" aria-hidden="true"></i> List Notifications</p>
<table id="tableNotifi" class="table">
    <tbody>
    <?php foreach($data as $value): ?>
    <tr class="<?= ($value['TNotification']['read'] == 1 || $value['TNotification']['read'] == 0) ? 'unread' : 'read'; ?>">
        <td>
            <span class="avatar_menu">
                <?= (isset($value['TUser']['avatar_user']) && !empty($value['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $value['TUser']['avatar_user']) : $this->Html->image('user.png'); ?>
            </span><b style="margin-left: 10px;"><?= $value['TUser']['username']; ?></b></td>
        <td data-id="<?php echo $value['TNotification']['id']; ?>">
            <span class="message url-redirect"><?= $value['TNotification']['content']; ?></span>
        </td>
        <td><?= $value['TNotification']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->element('pagining_links') ?>