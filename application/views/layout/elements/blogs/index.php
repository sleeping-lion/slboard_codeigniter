<article id="sl_main_blog" class="sl_main_list">
	<h3><?php echo _('Blog') ?></h3>
	<?php if($data['blogs']['total']): ?>
	<div class="row">
		<?php foreach ($data['blogs']['list'] as $index => $value): ?>
				<?php echo anchor('/blogs/'.$value['id'],img(array('src'=>'images/ajax-loader.gif','data-original'=>sl_get_thumb($value['photo_url'],'small'),'width'=>100,'height'=>100,'alt'=>$value['title'],'class'=>'lazy')),array('class'=>'col-xs-4 col-lg-2')) ?>				
				<noscript>
					<?php echo anchor('/blogs/'.$value['id'],img(array('src'=>sl_get_thumb($value['photo_url'],'small'),'width'=>100,'height'=>100,'alt'=>$value['title'])),array('class'=>'col-xs-4 col-lg-2')) ?>
				</noscript>
		<?php endforeach ?>
		<?php unset($value) ?>		
		<?php unset($data['blogs']) ?>
  </div>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('blogs',_('more'),array('class'=>'more','title'=>_('more'))) ?>
</article>