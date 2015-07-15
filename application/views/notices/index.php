<section id="sl_notice_index">
	<article class="table-responsive">
		<table class="table table-striped" border="0" cellpadding="0" cellspacing="0">
			<colgroup>
				<col />
				<col />
				<col />				
				<col />
				<col />
				<col />
				<col />				
			</colgroup>
			<thead>
				<tr>
					<th class="sl_t_id hidden-sm hidden-xs"><?php echo _('label_id') ?></th>		
					<th class="sl_t_title"><?php echo _('label_title') ?></th>
					<th class="sl_t_count"><?php echo _('label_comment_count')?></th>
					<th class="sl_t_count"><?php echo _('label_count') ?></th>
					<th class="sl_t_created_at"><?php echo _('label_created_at') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if($data['total']): ?>
				<?php foreach($data['list'] as $index=>$value): ?>
				<tr>
					<td class="sl_t_id hidden-sm hidden-xs"><?php echo $value['id'] ?></td>	
					<td class="sl_t_title"><?php echo sl_show_anchor('notices/view/'.$value['id'],$value['title'],array('sl_page'=>$this->uri->segment(2))) ?></td>
					<td class="sl_t_count"></td>
					<td class="sl_t_count"><?php echo $value['count'] ?></td>
					<td class="sl_t_created_at"><?php echo $value['created_at'] ?></td>
				</tr>
				<?php endforeach ?>
				<?php else: ?>
				<tr>
					<td colspan="5" class="no_data"><?php echo _('no_data') ?></td>
				</tr>
				<?php endif ?>
		</tbody>
	</table>
	</article>
	<div id="sl_index_bottom_menu">
		<?php echo $this->pagination->create_links(); ?>
		<?php echo $Layout->element('search'); ?>		
		<?php if($this->session->userdata('admin')): ?>
			<?php echo anchor('/notices/add','<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'._('new_link'),array('class'=>"btn btn-default col-xs-12 col-md-2")) ?>
		<?php endif ?>
	</div>
</section>
