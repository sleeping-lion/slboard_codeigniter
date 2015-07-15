	<ol class="nav nav-tabs">		
		<?php if(count($data['category']['list'])): ?>
			<?php foreach($data['category']['list'] as $value): ?>
			<li <?php if($categoryId==$value['id']): ?>class="active"<?php endif ?>>
				<?php echo anchor('/faqs/index?faq_category_id='.$value['id'],$value['title']) ?>
		  </li>
			<?php endforeach ?>
			<?php unset($value) ?>
		<?php else: ?>	
		<li><?php echo _('No Category') ?></li>
		<?php endif ?>
	</ol>