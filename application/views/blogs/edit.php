<section id="sl_blog_edit">
	<?php echo validation_errors() ?>
	<?php echo form_open(null,array('role'=>'form')) ?>
	<input type="hidden" name="id" value="<?php echo $data['content']['id'] ?>" />
  	<div class="form-group">
  		<label for="sl_title"><?php echo _('label_title') ?></label>
  		<input type="text" class="form-control" id="sl_title" name="title" value="<?php echo $data['content']['title'] ?>" maxlength="60" required="required" />
  	</div>
  	<div class="form-group">
  		<label for="sl_content"><?php echo _('label_content') ?></label>
  		<textarea id="sl_content" name="content" class="form-control" required="required"><?php echo $data['content']['content'] ?></textarea>
  	</div>
  	<input type="submit" class="btn btn-primary" value="<?php echo _('submit') ?>" />
	<?php echo form_close() ?>
</section>
