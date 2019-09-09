<?php foreach ($listAddMember as $member): ?>
    <div class="form-check check-popup checkbox-item">
        <input class="form-check-input checkMember" name="memberID" type="checkbox"
               value="<?= $member['TUser']['id']; ?>">
        <label class="form-check-label"><?= $member['TUser']['username']; ?></label>
    </div>
<?php endforeach; ?>