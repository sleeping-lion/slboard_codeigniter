<article id="sl_main_question" class="sl_main_list">
	<h3><?php echo _('Question') ?></h3>
	<?php if(isset($common_data['questions'])): ?>
	<ul>
		<?php foreach ($common_data['questions']['list'] as $index => $question): ?>
		<li>
			<?php echo anchor('questions/view/'.$question['id'],$question['title']) ?>
			<span class="sl_created_at"><?php echo $question['created_at'] ?></span>
		</li>		
		<?php endforeach ?>
		<?php unset($common_data['questions']) ?>
		<?php unset($question) ?>		
  </ul>
  <?php else: ?>
  <p><?php echo _('No Article') ?></p>
  <?php endif ?>
  <?php echo anchor('questions',_('more'),array('class'=>'more')) ?>
</article>