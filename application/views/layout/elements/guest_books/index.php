<article id="sl_main_guest_book" class="sl_main_list">
	<h3><?php echo _('Guest Book') ?></h3>
	<?php if(isset($common_data['guest_books'])): ?>
	<ul>
		<?php foreach ($common_data['guest_books']['list'] as $index => $quest_book): ?>
		<li>
			<?php echo anchor('guest_books/view/'.$guest_book['id'],$quest_book['title']) ?>
			<span class="sl_created_at"><?php echo $quest_book['created_at'] ?></span>
		</li>		
		<?php endforeach ?>
		<?php unset($common_data['guest_books']) ?>
		<?php unset($quest_book) ?>		
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('guest_books',_('more'),array('class'=>'more')) ?>
</article>