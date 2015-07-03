<section id="sl_board_contact_new">
	<?php echo validation_errors() ?>	
	<?php echo form_open(null,array('role'=>'form')) ?>
<div class="form-group">
<div class="input text">
	<label for="name">Name</label><input type="text" id="name" class="form-control" name="name">
</div>
</div>
<div class="form-group">
<div class="input email">
	<label for="email">Email</label><input type="email" id="email" class="form-control" name="email">
	</div>
</div>
<div class="form-group">
<div class="input tel"><label for="phone">Phone</label><input type="tel" id="phone" class="form-control" name="phone"></div></div>
<div class="form-group">
<div class="input text"><label for="title">Title</label><input type="text" id="title" class="form-control" name="title"></div></div>
<div class="form-group">
<div class="input text"><label for="contactcontent-content">Content</label><input type="text" id="contactcontent-content" class="form-control" name="ContactContent[content]"></div></div>
<div class="form-group">
<button type="submit" class="btn btn-primary">Save Article</button></div>
</form>
</section>