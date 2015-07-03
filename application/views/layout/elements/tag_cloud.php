<div id="sl_tag_cloud">
	<div id="myCanvasContainer">
		<canvas width="350" height="350" id="myCanvas">
			<p>Anything in here will be replaced on browsers that support the canvas element</p>
		</canvas>
	</div>
	<div id="tags">
		<ul>
			<?php if(isset($common_data['tags'])): ?>
			<?php foreach($common_data['tags'] as $index=>$value): ?>
			<li><?php echo anchor('/communities?tag='.$value['name'],$value['name'],array('class'=>'css_class')) ?></li>
			<?php endforeach ?>
			<?php endif ?>
		</ul>
	</div>
</div>