<article id="sl_main_guest_book" class="sl_main_list">
	<h3><?php echo _('Guest Book') ?></h3>
	<?php if(isset($data['guest_books'])): ?>
	<ul>
		<?php foreach ($data['guest_books']['list'] as $index => $value): ?>
		<li>
			<?php echo anchor('/guest_books/'.$value['id'],$value['title']) ?>
			<span class="sl_created_at hidden-xs"><?php echo sl_date($value['created_at']) ?></span>
		</li>		
		<?php endforeach ?>
		<?php unset($value) ?>
		<?php unset($data['guest_books']) ?>		
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('guest_books',_('more'),array('class'=>'more','title'=>_('more'))) ?>
</article>