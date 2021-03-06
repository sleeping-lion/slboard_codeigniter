<section id="sl_gallery_add">
	<?php echo validation_errors() ?>	
	<?php echo form_open(null,array('role'=>'form')) ?>
  	<div class="form-group">
  		<label for="sl_title"><?php echo _('label_title') ?></label>
  		<input type="text" class="form-control" id="sl_title" name="title" maxlength="60" required="required" />
  	</div>	
  	<div class="form-group">
  		<label for="sl_content"><?php echo _('label_content') ?></label>
  		<textarea id="sl_content" name="content" class="form-control" required="required"></textarea>
  	</div>
  	<div class="form-group">
    	<label for="sl_photo"><?php echo _('label_photo') ?></label>
    	<input type="file" name="userfile" id="sl_photo"  />
  	</div>
  	<input type="submit" class="btn btn-primary" value="<?php echo _('submit') ?>" />
	<?php echo form_close() ?>
</section>
