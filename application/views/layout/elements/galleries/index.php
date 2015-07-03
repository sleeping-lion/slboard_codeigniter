<article id="sl_main_gallery" class="sl_main_list">
	<h3><?php echo _('Gallery') ?></h3>
	<a class="prev browse left hidden-xs"></a>
	<div class="scrollable">
		<?php if(isset($common_data['galleries'])): ?>		
		<div class="items">
			<?php foreach($common_data['galleries']['list'] as $gallery): ?>
			<ul class="item">
				<?php foreach($gallery as $gallery_value): ?>
				<li>
					<?php echo $this->Html->link($this->Html->image('/files/gallery/photo/'.$gallery_value['Gallery']['id'].'/thumb_'.$gallery_value['Gallery']['photo'], array('alt' =>$gallery_value['Gallery']['title'])),array('controller'=>'galleries','action'=>'index','?'=>array('id'=>$gallery_value['Gallery']['id'])), array('escape' => false));		?>		
				</li>
				<?php endforeach ?>
			</ul>
			<?php endforeach ?>
		<?php unset($common_data['galleries']) ?>
		<?php unset($gallery) ?>
		<?php unset($gallery_value) ?>		
		</div>
		<?php endif ?>
	</div>
	<a class="next browse right hidden-xs"></a>
  <?php echo anchor('galleries',_('more'),array('class'=>'more')) ?>
</article>