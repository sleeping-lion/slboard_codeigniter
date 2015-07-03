<article id="comment_view<?php echo $index ?>" class="comment">
	<div class="comment_img">
		<?php if($comment['photo']): ?>
			<a href="/uploads/users/<?php echo $comment['photo'] ?>" class="simple_image"><img width="100" height="100" src="/uploads/users/<?php echo $comment['photo'] ?>" alt="<?php echo $comment['nickname'] ?>" /></a>
		<?php else: ?>
			<img src="/images/anon.jpg" alt="사진" />
		<?php endif ?>
	</div>
	<div class="comment_content">
		<div class="agree_disagree">
		<?php echo $comment['title'] ?>
	</div>			
	<?php echo nl2br($comment['content']) ?>
	</div>
	<ul class="tr_menu">
		<!-- <li><a href="" class="show_comment_comment">댓글 보기</a></li> -->
		<li><a href="" class="btn btn-white show_comment_comment_form">댓글 쓰기</a></li>		
	<?php if($this->session->userdata('user_id')==$comment['user_id']): ?>
		<li><?php echo anchor('/communities/comments/confirm_delete/'.$comment['id'],_('delete_link'),array('class'=>"btn btn-white comment-delete-button",'title'=>"댓글 삭제")) ?></li>
	<?php endif ?>
	</ul>
	<section class="comment_comments">
			<?php if($comment['comments']['total']): ?>
			<?php foreach($comment['comments']['list'] as $comment_index=>$comment_comment): ?>
				<?php include __DIR__.DIRECTORY_SEPARATOR.'comment/index.php' ?>
			<?php endforeach ?>
			<?php endif ?>
		<div class="comment_comment_form">
			<?php include __DIR__.DIRECTORY_SEPARATOR.'comment/add.php' ?>
		</div>
	</section>
</article>