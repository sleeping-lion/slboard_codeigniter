<section id="sl_blog_index" itemscope itemprop="blogPosts" itemtype="http://schema.org/Blog">
	<?php echo $Layout->element('category') ?>
	<?php if($data['total']): ?>
	<?php foreach ($data['list'] as $blog): ?>
	<article class="media" itemscope itemprop="blogPost" itemtype="http://schema.org/Blog">
		<?php if(isset($blog['photo'])): ?>
		<?php echo anchor('/blogs/'.$blog['id'],'<img src="" />',array('class'=>'pull-left')) ?>			
		<?php endif ?>
		<div class="media-body">
			<h4 class="media-heading" itemprop="name"></h4>
			<p itemprop="description">
				<?php echo anchor('/blogs/'.$blog['id'],$blog['description']) ?>
			</p>
		</div>
	</article>
	<?php endforeach; ?>
	<?php unset($blogs) ?>
	<?php unset($blog) ?>	
	<?php else: ?>
	<article>
	<p><?php echo __('No Article') ?></p>
	</article>
	<?php endif ?>
	<div id="sl_index_bottom_menu">
		<?php echo $this->pagination->create_links(); ?>
		<?php echo $Layout->element('search'); ?>		
		<?php if($this->session->userdata('admin')): ?>
			<?php echo anchor('/blogs/add','<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'._('new_link'),array('class'=>"btn btn-default col-xs-12 col-md-2")) ?>
		<?php endif ?>
	</div>
</section>
