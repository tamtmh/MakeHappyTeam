<?php echo $this->Html->css("user_homepage"); ?>
<?php echo $this->Html->script("home"); ?>
<div id="reset_pass" class="col-md-6">
    <div class="avatar avatar_round">
        <?php echo $this->Html->image('reset.png'); ?>
    </div>
    <p class="title-form">Reset your password</p>
    <i class="note">Please enter a new password</i>
    <br/><br/>
    <form method="post">
        <div class="form-group row input-reset">
            <div class="col-md-1 col-ms-1 col-1 iconuser"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></div>
            <div class="col-md-9 col-sm-9 col-9 info">
                <input name="password" type="password" id="pass1" class="form-control" placeholder="New password" required onkeyup="checkPass(); return false;">
            </div>
        </div>
        <div id="error-nwlpass1"></div>
        <div class="form-group row">
            <div class="col-md-1 col-ms-1 col-1 iconuser"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></div>
            <div class="col-md-9 col-sm-9 col-9 info">
                <input name="confirm-password" type="password" id="pass2" class="form-control" placeholder="Re-enter password" required onkeyup="checkPass(); return false;">
            </div>
        </div>
        <div class="text-danger" style="text-align: center" <?php if (!isset($error)) echo 'hidden'?>><?php if(isset($error)) echo $error; ?></div>
        <div id="error-nwlpass2"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12 btn-reset">
                <button type="submit" class="btn"><i class="fa fa-check" aria-hidden="true"></i>Confirm</button>
            </div>
        </div>
    </form>
</div>
<script>

</script>