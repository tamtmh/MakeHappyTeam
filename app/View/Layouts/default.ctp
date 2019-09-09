<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'MHT ');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>|
		<?php echo $this->fetch('title'); ?>
	</title>
    <link rel="icon" href="/img/logo.png" type="image/ico">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<?php
		echo $this->Html->css('style');
		echo $this->Html->css('detail');
		echo $this->Html->css("user_homepage");
		echo $this->Html->css('detail');
        echo $this->Html->css('responsive');
	?>
</head>
<body>
	<div class="header-wrapper">
		<?php echo $this->element("header"); ?>
	</div>

	<div id="container" class="container-fuild containerDefault">
		<div class="row contentall">
            <?php echo $this->element('popup_team'); ?>
            <?php if (!isset($hideSidebar)): ?>
                <div class="sidebar col-md-2 col-sm-2">
                    <?php echo $this->element('listTeam'); ?>
                </div>
            <?php endif; ?>
			<div class="main-content col-md-9 col-sm-9" <?php echo (isset($hideSidebar))? 'style="margin: 0 auto;"' : '';?>>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php echo $this->element("footer"); ?>
	</div>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--    datepicker range-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

	<?php echo $this->Html->script('web-app'); ?>
	<?php echo $this->Html->script("comment"); ?>
</body>
</html>
