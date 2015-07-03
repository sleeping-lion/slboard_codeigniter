<?php echo form_open('/communities/comments/comments/add',array('role'=>"form")) ?>
	<input type="hidden" name="poll_community_comment_id" value="<?php echo $comment['id'] ?>" />
	<?php if($data['polls']['total']): ?>
	<?php foreach($data['polls']['list'] as $index=>$value): ?>
  <div class="form-group">
  	<label for="sl_poll_comment_<?php echo $comment['id'] ?>_<?php echo $index ?>" class="radio-inline">
  		<input type="radio" id="sl_poll_comment_<?php echo $comment['id'] ?>_<?php echo $index ?>" name="poll_id" value="<?php echo $value['id'] ?>" checked="checked" />
  		<?php echo $value['title'] ?>
  	</label>
  </div>
  <?php endforeach ?>
  <?php endif ?>	
  <div class="form-group">
  	<label for="sl_content"><?php echo _('label_content') ?></label>
  	<textarea id="sl_content" name="content" class="form-control" required="required" <?php if(!$this->session->userdata('user_id')): ?>placeholder="로그인후 사용가능합니다."<?php endif ?>></textarea>
  </div>
  <input type="submit" class="btn btn-primary" value="<?php echo _('submit') ?>" />
</form>
