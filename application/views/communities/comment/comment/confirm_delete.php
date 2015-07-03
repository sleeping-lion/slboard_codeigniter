<section id="section_community" class="section_content">
	<?php echo form_open('/communities/comments/comments/delete/'.$id,array('id'=>"community_delete_form")) ?>			
		<p>
			정말로 댓글 <?php echo $id ?>번을 삭제합니까?
		</p>
		<div class="form-group">
			<input type="submit" class="btn btn-primary btn-larghe" value="삭제" />
		</div>			
	</form>
</section>
