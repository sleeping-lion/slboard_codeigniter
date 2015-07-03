<article id="sl_blog_categories" class="box sl_aside">
  <div class="box_header">
    <h2><?php echo _('Blog') ?></h2>
    <div class="box_icon">
      <a href="#" class="btn_minimize"><i class="glyphicon glyphicon-chevron-up"></i></a>
      <a href="#" class="btn_close"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
  </div>
	<div class="box_content">
		<ul>
			<li <?php if(empty($this->input->get('blog_category_id'))): ?>class="active"<?php endif ?>><a href=""><?php echo _('All') ?></a></li>
    	<?php if(isset($common_data['blogCategories'])): ?>
    	<?php foreach($common_data['blogCategories']['list'] as $blogCategory): ?> 		
    	<?php if(empty($blogCategory['blog_category_id'])): ?>
			<li>
      	<?php if($blogCategory['leaf']): ?>
      	<?php echo anchor('/blogs?blog_category_id='.$blogCategory['id'],$blogCategory['title'].'('.$blogCategory['blogs_count'].')') ?>
      	<?php else: ?>
      	<span class="c_pointer"><span><?php echo $blogCategory['title'] ?></span><span class="cursor">&nbsp;&gt;&gt;</span></span>  	
      	<?php endif ?>
      	<ul>
    			<?php foreach($common_data['blogCategories']['list'] as $blogSubCategory): ?>
      		<?php if($blogCategory['id']==$blogSubCategory['blog_category_id']): ?>
      		<li <?php if($this->input->get('blog_category_id')): ?><?php if($this->input->get('blog_category_id')==$blogSubCategory['id']): ?>class="active"<?php endif ?><?php endif ?>>
      		<?php echo anchor('/blogs?blog_category_id='.$blogSubCategory['id'],$blogSubCategory['title'].'('.$blogSubCategory['blogs_count'].')') ?>
      		</li>
      		<?php endif ?>
      		<?php endforeach ?>
      	</ul>
     	</li>
     <?php endif ?>
     <?php endforeach ?>     	
    	<?php else: ?>
			<li><?php echo _('No Article') ?></li>
    	<?php endif ?>
		</ul>
		<?php echo anchor('/blogs',_('more')) ?>
	</div> 
</article>