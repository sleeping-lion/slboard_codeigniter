<article id="sl_tag_cloud" class="box sl_aside">
  <div class="box_header">
    <h2><?php echo _('Tag') ?></h2>
    <div class="box_icon">
      <a href="#" class="btn_minimize"><i class="glyphicon glyphicon-chevron-up"></i></a>
      <a href="#" class="btn_close"><i class="glyphicon glyphicon-remove"></i></a>
    </div>
  </div>
	<div class="box_content">

	<div id="myCanvasContainer">
		<canvas width="350" height="350" id="myCanvas">
			<p>Anything in here will be replaced on browsers that support the canvas element</p>
		</canvas>
	</div>	
	<div id="tags">
		<ul>
			<?php if(isset($common_data['tags'])): ?>
			<?php $taglist=tag_cloud($common_data['tags'],array('css1','css2','css3','css4')) ?>				
			<?php foreach($taglist as $value): ?>				
			<li><?php echo anchor('/tags/'.urlencode($value['name']),$value['name'],array('class'=>$value['class'])) ?></li>
			<?php endforeach ?>
			<?php unset($value) ?>
			<?php unset($taglist) ?>
			<?php endif ?>	
		</ul>
	</div>
	
	</div> 
</article>

