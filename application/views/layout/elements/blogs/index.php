<article id="sl_main_blog" class="sl_main_list">
	<h3><?php echo _('Blog') ?></h3>
	<?php if(isset($common_data['blogs'])): ?>
	<ul>
		<?php foreach ($common_data['blogs']['list'] as $index => $blog): ?>
		<li <?php if(5<$index+1): ?><?php echo 'class="nm"' ?><?php endif ?>>
				<?php echo anchor('blogs/view/'.$blog['id'],$blog['title']); ?>
			</li>
		<?php endforeach ?>
		<?php unset($common_data['blogs']) ?>
		<?php unset($blog) ?>
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('blogs',_('more'),array('class'=>'more')) ?>
</article>