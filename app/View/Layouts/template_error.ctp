<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        echo $this->Html->css('style');
        echo $this->Html->css('detail');
        echo $this->Html->css("user_homepage");
        echo $this->Html->css('detail');
    ?>
    <?php echo $this->Html->script('web-app'); ?>
    <?php echo $this->Html->script("comment"); ?>
</head>
<body>
    <div id="wrapper">
        <div id="page-content-wrapper">
            <?php echo $this->fetch('content'); ?>
        </div>
        <!-- /#content-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>
</html>
