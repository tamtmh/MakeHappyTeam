<?php echo $this->Html->css("user_homepage"); ?>

<div class="form-user col-md-6">
    <div class="avatar avatar_round">
        <?php echo $this->Html->image('guest.png'); ?>
    </div>
    <form method="post">
        <div class="form-group row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 iconuser"><i class="fa fa-user fa-lg" aria-hidden="true"></i></div>
            <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10 col-10 info">
                <input type="email" class="form-control" placeholder="Email" id="email" name="data[TUser][email]" required>
            </div>
            <div class="text-danger" style="padding-top: 5px;" <?php if(!isset($errorEmail)) echo 'hidden';?>><?php if (isset($errorEmail)) echo $errorEmail;?></div>
        </div>
        <div class="form-group row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 iconuser"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></div>
            <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10 col-10 info">
                <input type="password" class="form-control" placeholder="Password" id="pwd" name="data[TUser][password]" required>
            </div>
            <div class="text-danger" style="padding-top: 5px;" <?php if(!isset($errorPwd)) echo 'hidden';?>><?php if (isset($errorPwd)) echo $errorPwd;?></div>
        </div>

        <div class="row form-option">
            <div class="col-md-6 col-sm-6 col-6 savepass">
                <div class="form-check form-check-login">
                    <input class="form-check-input" type="checkbox" id="gridCheck" name="remember">
                    <label class="form-check-label" for="gridCheck">Save Password</label>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-6 resetpass">
                <a href="/forgot" class="text-primary">Forgot password</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-12 buttonLogin">
                <button type="submit" class="btn login">Login</button>
            </div>
            <div class="signup">
                <span class="txt1">
                    Don’t have an account?
                </span>
                <a class="txt2" href="/signup">
                    Sign Up
                </a>
            </div>
        </div>
    </form>
</div>