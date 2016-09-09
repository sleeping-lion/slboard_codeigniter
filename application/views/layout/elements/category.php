<ol class="nav nav-tabs">		
	<?php if($data['category']['total']): ?>
	<?php foreach($data['category']['list'] as $value): ?>
		<li <?php if($data['category']['current_category_id']==$value['id']): ?>class="active"<?php endif ?>>
			<?php echo anchor($this -> router -> fetch_class().'?'.singular($this -> router -> fetch_class()).'_category_id='.$value['id'],$value['title']) ?>
		</li>
		<?php endforeach ?>
		<?php unset($value) ?>
	<?php else: ?>	
	<li><?php echo _('No Category') ?></li>
	<?php endif ?>
</ol>
