<section id="slboard_user_agree">
	<?php echo validation_errors(); ?>
	<?php echo form_open() ?>
		<article>
			<h3>회원 이용약관</h3>
			<?php require 'agreement1.php' ?>
		 <div class="checkbox">
		 	<label>
			<input type="checkbox" name="agree1" id="agree1" value="1" />상기 내용에 동의 합니다.
			</label>
		</div>					
		</article>
		<article>
			<h3>개인정보 수집 및 이용에 대한 안내</h3>
			<?php require 'agreement2.php' ?>
		 <div class="checkbox">
		 	<label>
			<input type="checkbox" name="agree2" id="agree2" value="1" /> 상기 내용에 동의 합니다.
			</label>
		</div>			
		</article>
		<br />
		<div id="sl_content_bottom_buttons">
			<a href=""  class="btn btn-default"><?php echo _('disagree') ?></a>&nbsp;&nbsp;<input type="submit" class="btn btn-primary" value="<?php echo _('agree') ?>" />
		</div>
	</form>
</section>