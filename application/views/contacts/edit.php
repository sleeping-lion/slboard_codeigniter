<section id="sl_contact_edit">
	<form role="form" action="update.php" method="post">
		<input type="hidden" name="id" value="<?=$data['content']['id'] ?>" />
  	<div class="form-group">
  		<label for="sl_title"><?php echo _('label_title') ?></label>
  		<input type="text" class="form-control" id="sl_title" name="title" value="<?=$data['content']['title'] ?>" maxlength="60" required="required" />
  	</div>
  	<div class="form-group">
  		<label for="sl_content"><?php echo _('label_content') ?></label>
  		<textarea id="sl_content" name="content" class="form-control" required="required"><?=$data['content']['content'] ?></textarea>
  	</div>
  	<input type="submit" class="btn btn-primary" value="<?php echo _('submit') ?>" />
	</form>
</section>
