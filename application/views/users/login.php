<?php echo validation_errors(); ?>
<?php echo $this->session->flashdata('error_message'); ?>
<?php echo form_open('',array('class'=>"form-horizontal",'id'=>"sl_login_form",'role'=>"form" )) ?>
	<input type="hidden" id="message_no_email" value="<?php echo _('not_insert_email') ?>" />
	<input type="hidden" id="message_no_password" value="<?php echo _('not_insert_password') ?>" />
	<input type="hidden" id="message_invalid_email" value="<?php echo _('invalid_email') ?>" />
	<input type="hidden" id="message_invalid_password" value="<?php echo _('invalid_password') ?>" />
	<?php if($this->input->get('redirect')): ?>
	<input type="hidden" name="redirect_url" value="<?php echo $_SERVER['HTTP_REFERER'] ?>"  />
	<?php endif ?>
  <div class="form-group">
    <label for="sl_user_email" class="col-sm-2 control-label"><?php echo _('label_email') ?></label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="sl_user_email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>"  required="required" />  
    </div>
  </div>
  <div class="form-group">
    <label for="sl_user_password" class="col-sm-2 control-label"><?php echo _('label_password') ?></label>
    <div class="col-sm-10"> 
      <input type="password" class="form-control" id="sl_user_password" name="password" value="<?php echo set_value('password'); ?>"  placeholder="Password" required="required" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" id="remember_email"><?php echo _('remember_email') ?>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary"><?php echo _('login') ?></button>
    </div>
  </div>
</form>