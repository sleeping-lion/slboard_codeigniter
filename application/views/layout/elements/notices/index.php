<article id="sl_main_guest_book" class="sl_main_list">
	<h3><?php echo _('Notice') ?></h3>
	<?php if(isset($common_data['notices'])): ?>
	<ul>
		<?php foreach ($common_data['notices']['list'] as $index => $notice): ?>
		<li>
			<?php echo anchor('notices/view/'.$notice['id'],$notice['title']) ?>
			<span class="sl_created_at"><?php echo $notice['created_at'] ?></span>
		</li>		
		<?php endforeach ?>
		<?php unset($common_data['notices']) ?>
		<?php unset($notice) ?>		
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('notices',_('more'),array('class'=>'more')) ?>
</article>