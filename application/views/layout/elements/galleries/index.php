<?php if($data['galleries']['total']): ?>
<?php $data['galleries']['list'] = array_chunk($data['galleries']['list'], 6); ?>
<?php endif ?>
<article id="sl_main_gallery" class="sl_main_list carousel slide" data-ride="carousel">
	<h3><?php echo _('Gallery') ?></h3>
	<?php if($data['galleries']['total']): ?>
	<ol class="carousel-indicators">
		<?php foreach($data['galleries']['list'] as $index=>$value): ?>
		<li data-target="#sl_main_gallery" data-slide-to="<?php echo $index ?>" <?php if(!$index): ?>class="active"<?php endif ?>></li>
		<?php endforeach ?>
		<?php unset($index) ?>
		<?php unset($value) ?>
	</ol>
	<?php endif ?>
	<?php if($data['galleries']['total']): ?>
	<div class="row">
	<div class="carousel-inner " role="listbox" style="clear:both">
		<?php foreach($data['galleries']['list'] as $index=>$value): ?>
		<div class="item<?php if(!$index): ?> active<?php endif ?>">
			<?php foreach($value as $index2=>$gallery): ?>
			<?php echo anchor('/galleries/'.$gallery['id'],img(array('src'=>'images/ajax-loader.gif','data-original'=>sl_get_thumb($gallery['photo_url'],'small'),'width'=>100,'height'=>100,'alt'=>$gallery['title'],'class'=>'lazy')),array('class'=>'col-xs-4 col-lg-2')) ?>
			<noscript>
				<?php echo anchor('/galleries/'.$gallery['id'],img(array('src'=>sl_get_thumb($gallery['photo_url'],'small'),'width'=>100,'height'=>100,'alt'=>$gallery['title'])),array('class'=>'col-xs-4 col-lg-2')) ?>
			</noscript>
			<?php endforeach ?>
	    </div>
	<?php endforeach ?>
  </div>
</div>  
	<?php else: ?>
	<div>
		<p><?php echo _('no_data') ?></p>
	</div>
	<?php endif ?>
  <!-- Controls -->
  <a class="left carousel-control hidden-xs" href="#sl_main_gallery" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control hidden-xs" href="#sl_main_gallery" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  <?php echo anchor('galleries',_('more'),array('class'=>'more','title'=>_('more'))) ?>
</article>