<section id="sl_faq_index">
	<?php echo $Layout->element('category') ?>
	<article>
		<?php if($data['total']): ?>
		<?php foreach($data['list'] as $index=>$value): ?>		
		<div class="panel <?php if(isset($faq)): ?><?php if($faq['Faq']['id']==$value['id']): ?>panel-primary<?php else: ?>panel-default<?php endif ?><?php else: ?>panel-default<?php endif ?>">
  		<h3 class="panel-heading">
  			<?php echo anchor('/faqs?id='.$value['id'],$value['title']) ?>
  		</h3>
  		<?php if(isset($faq)): ?>
			<?php if($faq['Faq']['id']==$value['Faq']['id']): ?>
			<div class="panel-body">
				<div class="faq_content">
				<?php echo nl2br($faq['FaqContent']['content']) ?>
				</div>
				<div class="sl_faq_menu">
					<?php echo anchor('/faqs/edit/'.$value['id'],_('Edit'),array('class'=>'btn btn-default')) ?>
				</div>
			</div>
			<?php else: ?>
			<div class="panel-body" style="display:none">
				<div class="faq_content">
					
				</div>
				<div class="sl_faq_menu">
					<?php echo anchor('/faqs/edit/'.$value['id'],_('Edit'),array('class'=>'btn btn-default')) ?>
				</div>				
			</div>				
			<?php endif ?>
			<?php else: ?>
			<div class="panel-body" style="display:none">
				<div class="faq_content">
					
				</div>
				<div class="sl_faq_menu">
					<?php echo anchor('/faqs/edit/'.$value['id'],_('Edit'),array('class'=>'btn btn-default')) ?>
				</div>				
			</div>
			<?php endif ?>
  	</div>
  	<?php endforeach ?>
		<?php else: ?>
		<p><?php echo _('No Article') ?></p>
		<?php endif ?>
		<?php unset($value) ?>		 	
  </article>	
	<div id="sl_index_bottom_menu">
		<?php echo $this->pagination->create_links(); ?>
		<?php echo $Layout->element('search'); ?>		
		<?php if($this->session->userdata('admin')): ?>
			<?php echo anchor('/faqs/add','<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'._('new_link'),array('class'=>"btn btn-default col-xs-12 col-md-2")) ?>
		<?php endif ?>
	</div>
</section>