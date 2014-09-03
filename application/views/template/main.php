<?php echo $basejs?>
<?php echo $header ?>
<div id="main" role="main" class="container-fluid">
	<div class="row">
		
	<?php if($this->ion_auth->logged_in()){ ?>

		<div class="col-sm-3 col-md-2 sidebar sidebar-default">
			<?php echo $leftbar; ?>
		</div>
		<div class="col-sm-9 col-md-10 main" style="">
			<?php echo $content_body; ?>
		</div>
		
	<?php }else{?>

		<div class="col-sm-12 col-md-12 main">
			<?php echo $content_body; ?>
		</div>

	<?php }?>
	</div>
</div>
<?php echo $footer ?>
