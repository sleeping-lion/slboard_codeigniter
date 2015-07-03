<article id="comment_view<?php echo $comment_index ?>" class="comment">
	<div class="comment_img">
		<?php if($comment_comment['photo']): ?>
			<a href="/uploads/users/<?php echo $comment_comment['photo'] ?>" class="simple_image"><img width="100" height="100" src="/uploads/users/thumb_<?php echo  $comment_comment['photo'] ?>" alt="<?php echo $comment['nickname'] ?>" /></a>
		<?php else: ?>
			<img src="/images/anon.jpg" alt="사진" />
		<?php endif ?>
	</div>
	<div class="comment_content">
		<div class="agree_disagree">
		<?php echo $comment_comment['title'] ?>
	</div>		
	<?php echo nl2br($comment_comment['content']) ?>
	</div>
	<ul class="tr_menu">	
	<?php if($this->session->userdata('user_id')==$comment_comment['user_id']): ?>
		<li><?php echo anchor('/communities/comments/comments/confirm_delete/'.$comment_comment['id'],_('delete_link'),array('class'=>"btn btn-white comment-delete-button",'title'=>"댓글 삭제")) ?></li>
	<?php endif ?>
</article>