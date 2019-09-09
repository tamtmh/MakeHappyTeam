<?php
	echo $this->Html->css('report_create');
?>
<?php echo $this->element("name_team"); ?>
<hr>
<div class="row">
	<div class="col-md-2 col-sm-2 col-5 emoji">
		<h5>Status</h5>
		<?php echo $this->Html->image('emoji/emoji_'.$report['TReport']['emoji_id'].'.gif'); ?>
	</div>
	<div class="col-md-2 col-sm-2 col-5 score">
		<h5>Score</h5>
		<p>
			<?php echo $report['TReport']['score']; ?>
		</p>
	</div>
	<div class="col-md-7 col-sm-7 col-11 status" >
		<h4 style ="margin: 7%;">
			<?php echo $report['TReport']['status']; ?>
		</h4>
	</div>
</div>
<div class="report">
	<i class="fa fa-tasks fa-lg" style="padding-right: 7px;"></i><span>Report</span>
</div>
<hr>
<div class="row form-question">
	<form action="" method="post">
		<div class="content1">
			<div class="form-title">1. Problem</div>
			<div class="form-text">
				<textarea class="form-control" required name="data[TReport][Problem]" rows="3" cols="50"></textarea>
			</div>
		</div>
		<div class="content2">
			<div class="form-title">2. Did it affect to work?</div>
			<label><input type="radio" class="radio" value="yes" name="data[TReport][Did it affect to work?]" /> Yes</label>
			<label><input type="radio" class="radio" value="no" name="data[TReport][Did it affect to work?]" /> No</label>

		</div>
		<div class="content3">
			<div class="form-title">3. How did it affect to work?</div>
			<div class="form-text">
				<textarea class="form-control" required rows="3" name="data[TReport][How did it affect to work?]" cols="50"></textarea>
			</div>
		</div>
		<div class="content4">
			<div class="form-title">4. How do you think how to fix the problem and affect?</div>
			<div class="form-text">
				<textarea class="form-control" required rows="3" name="data[TReport][How do you think how to fix the problem and affect?]" cols="50"></textarea>
			</div>
		</div>
		<div class="content5">
			<div class="form-title">5. What do you want leader help you?</div>
			<div class="form-text">
				<textarea class="form-control" required rows="3" name="data[TReport][What do you want leader help you?]" cols="50"></textarea>
			</div>
		</div>
		<div class="button"><button type="submit" class="btn btn-primary">Send</button></div>
	</form>
</div>