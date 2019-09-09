<?php echo $this->Html->css("user_homepage"); ?>
<?php echo $this->Html->script("home"); ?>
<div class="form-user col-xl-6 col-lg-10 col-md-12 col-sm-12 col-12">
    <p class="title-form">Create Account</p>
    <?php echo $this->Form->create("signup"); ?>
        <div class="form-group row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 iconuser"><i class="fa fa-user fa-lg" aria-hidden="true"></i></div>
            <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10 col-10 info">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 iconuser"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></div>
            <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10 col-10 info">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 iconuser"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></div>
            <div class="col-xl-9 col-lg-10 col-md-10 col-sm-10 col-10 info">
                <input type="password" name="password" id="pass" class="form-control" placeholder="Password" onkeyup="checkPassSignUp(); return false;" required>
            </div>
        </div>
        <div id="error-nwlpass"></div>

        <div class="row">
            <div class="col-sm-12 col-sm-12 col-12 buttonSignup">
                <button type="submit" class="btn login">Sign up</button>
            </div>
            <div class="signup">
                <span class="txt1">
                    Don’t have an account?
                </span>
                <a class="txt2" href="/login">
                    Login here
                </a>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
</div>