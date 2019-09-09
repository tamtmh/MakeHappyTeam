  <div class="message"><?php echo __('Your password has been updated')?></div>
  <div class="email"><?php if (isset($email)) echo $email;?></div>
  <div class="form-group group-button">
    <button type="submit" id="a_submit" class="btn btn-primary" onclick="window.location.href='<?php echo Router::url(array('controller'=>'Logins', 'action'=> 'login'))?>'"><?php echo __('Sign In');?></button>
  </div>