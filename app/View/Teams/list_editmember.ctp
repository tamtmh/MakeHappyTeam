<?php foreach ($listMemberInTeam as $key => $val): ?>
    <tr class="user-id checkbox-item" data-id="<?php echo $val['TUserTeam']['id']; ?>"
        data-teamId="<?php echo $val['TUserTeam']['team_id']; ?>"
        id="<?php echo $val['TUserTeam']['id']; ?>">
        <th scope="row"><?= $key + 1; ?></th>
        <td><?= $val['TUser']['username'] ?></td>
        <td>
            <select class="select-popup role-team" id="role-team-edit">
                <?php foreach ($listRoleTeam as $role): ?>
                    <option <?php if ($val['TUserTeam']['role_team_id'] == $role['TRoleTeam']['id']): ?> selected <?php endif; ?>
                            value="<?= $role['TRoleTeam']['id']; ?>">
                        <?= $role['TRoleTeam']['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="delete-member-in-team">
            <i class="fa fa-times" aria-hidden="true"></i>
        </td>
    </tr>
<?php endforeach; ?>