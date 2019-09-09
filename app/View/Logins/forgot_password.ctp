<?php echo $this->Html->css("user_homepage"); ?>
<div id= "forgot_pass" class="col-md-6">
    <div class="avatar avatar_round">
        <?php echo $this->Html->image('forgot.png'); ?>
    </div>
    <p class="title-form">Forgot Password</p>
    <i class="note">Enter your email to reset your password</i>
    <br/><br/>
    <form method="post">
        <div class="form-group row">
            <div class="col-md-1 col-ms-1 col-1 iconuser"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></div>
            <div class="col-md-9 col-sm-9 col-9 info">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="text-danger" style="padding-top: 5px;" <?php if(!isset($error)) echo 'hidden';?>><?php if (isset($error)) echo $error;?></div>
            <div class="text-success" style="padding-top: 5px;" <?php if(!isset($message)) echo 'hidden';?>><?php if (isset($message)) echo $message;?></div>
        </div>
        <div class="form-group row" style="margin-right: -9px">
            <div class="col-md-12 col-sm-12 col-12 btnforgot">
                <button type="submit" id="send" class="btn"><i class="fa fa-paper-plane" aria-hidden="true"></i>  Submit</button>
            </div>
        </div>
    </form>
</div>