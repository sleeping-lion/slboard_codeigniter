<article id="slboard_main_notice" class="sl_main_list">
	<h3><?php echo _('notice') ?></h3>
	<?php if($data['notice_total']): ?>
	<ul>
		<?php foreach($data['notice_list'] as $index=>$notice_value): ?>
		<li>
			<a href="/boards/notices/show.php?id=<?php echo $notice_value['id'] ?>"><?php echo truncate($notice_value['title']) ?></a>
			<span class="sl_created_at"><?php echo get_format_date($notice_value['created_at']) ?></span>
		</li>
		<?php endforeach ?>
	</ul>
	<?php else: ?>
	<p><?php echo _('no_data') ?></p>
	<?php endif ?>
	<a class="more" href="/boards/notices"><?php echo _('link_more') ?></a>
</article>