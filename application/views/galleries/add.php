<section id="poll_community_new">
	<?php echo validation_errors() ?>	
	<?php echo form_open(null,array('role'=>'form')) ?>
  	<div class="form-group">
  		<label for="sl_title"><?php echo _('label_title') ?></label>
  		<input type="text" class="form-control" id="sl_title" name="title" maxlength="60" required="required" />
  	</div>
  	<div class="form-group">
   		<label for="sl_title"><?php echo _('poll_title') ?></label>
   		<ol id="poll_title">
   			<li><input type="text" class="form-control" name="poll_title[]" maxlength="60" value="찬성" /><input type="button" class="btn poll_delete" value="<?php echo _('delete') ?>" ></li>
   			<li><input type="text" class="form-control" name="poll_title[]" maxlength="60" value="반대" /><input type="button" class="btn poll_delete" value="<?php echo _('delete') ?>" ></li>   			
   		</ol>
    	<input type="button" id="poll_add" class="btn" value="<?php echo _('add') ?>" />
  	</div>  	
  	<div class="form-group">
  		<label for="sl_content"><?php echo _('label_content') ?></label>
  		<textarea id="sl_content" name="content" class="form-control" required="required"></textarea>
  	</div>
  	<div class="form-group">
  		<label for="sl_tag"><?php echo _('label_tag') ?></label>
  		<input type="text" class="form-control" id="sl_tag" name="tag" maxlength="60" required="required" />
  	</div>  	
  	<input type="submit" class="btn btn-primary" value="<?php echo _('submit') ?>" />
	</form>
</section>