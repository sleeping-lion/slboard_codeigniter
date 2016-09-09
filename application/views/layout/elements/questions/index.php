<article id="sl_main_question" class="sl_main_list">
	<h3><?php echo _('Question') ?></h3>
	<?php if(isset($data['questions'])): ?>
	<ul>
		<?php foreach ($data['questions']['list'] as $index => $value): ?>
		<li>
			<?php echo anchor('/questions/'.$value['id'],$value['title']) ?>
		</li>		
		<?php endforeach ?>
		<?php unset($value) ?>
		<?php unset($data['questions']) ?>	
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('questions',_('more'),array('class'=>'more','title'=>_('more'))) ?>
</article>