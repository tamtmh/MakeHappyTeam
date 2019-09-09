<p>Hi <?php echo $user['email']; ?>,</p>

<p>Welcome to Make Happyy Team.</p>

<p>Follow the steps below to start using the service.</p>

<p>1. Set your password by clicking on the link below.</p>

<?php 
	$url = Router::url(array(
	      'controller' => 'Logins',
	      'action' => 'resetPassword',
	      '?' => array('email' => base64_encode($user['email'])),
	      'full_base' =>true
	    ));
	echo $url; 
?>

<p>Thanks,</p>
<p>Make Happy Team.</p>