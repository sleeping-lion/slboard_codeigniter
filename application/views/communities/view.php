<section id="poll_community_view">
  	<div class="poll_count" style="margin:30px 10%;width:80%">
	<?php if($data['content']['comment_count']): ?>
	<?php if($data['polls']['total']): ?>		
	<?php foreach($data['polls']['list'] as $index=>$value): ?>
<div class="progress">
	<?php $percentage=($value['count']/$data['content']['comment_count'])*100 ?>
  <div class="progress-bar progress-bar-striped progress-bar-<?php echo bar_color($index)  ?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage ?>%;">
  <?php echo $value['title'] ?> : <?php echo $value['count'] ?> / <?php echo $percentage ?>%
  </div>
</div>
 <?php endforeach ?>
 <?php endif ?>
 <?php endif ?>
  	</div>		
  <div id="poll_community_content" class="slboard_content">	  	
    <div class="sl_content_header">
      <h3 itemprop="name"><?php echo $data['content']['title'] ?></h3>
    </div>
    <div class="sl_content_main">
     		<p class="sl_content_info"><span  itemprop="author" class="none"><?php echo $data['content']['nickname'] ?></span>&nbsp;&nbsp;&nbsp; <?php echo _('label_created_at') ?> : <span itemprop="dateCreated"><?php echo $data['content']['created_at'] ?></span><span class="none" itemprop="dateModified"><?php $data['content']['updated_at'] ?></span></p>    	
      <div class="sl_content_text" itemprop="text"><?php echo nl2br($data['content']['content']) ?></div>
      <div class="tag">
      <h4><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> <?=_('tag') ?></h4>
      <ul>
      	<?php foreach($data['tags'] as $index=>$value): ?>
      	<li><?php echo anchor('/communities?tag='.$value['name'],$value['name']) ?></li>
      	<?php endforeach ?>
      </ul>
      <div class="clear">&nbsp;</div>
      </div>
    </div>
  </div>
	<?php include 'bottom_menu.php' ?>
	<section class="comments">
			<?php if($data['comments']['total']): ?>
			<?php foreach($data['comments']['list'] as $index=>$comment): ?>
				<?php include __DIR__.DIRECTORY_SEPARATOR.'comment/index.php' ?>
			<?php endforeach ?>
			<?php endif ?>
	</section>
        <div class="new_comment_form">
				<?php include __DIR__.DIRECTORY_SEPARATOR.'comment/add.php' ?>
        </div>	
	<?php include __DIR__.DIRECTORY_SEPARATOR.'bottom_menu.php' ?>        
</section>