<div id="sl_tag_cloud">
	<div id="myCanvasContainer">
		<canvas width="350" height="350" id="myCanvas">
			<p>Anything in here will be replaced on browsers that support the canvas element</p>
		</canvas>
	</div>
	<div id="tags">
		<ul>
			<?php foreach($data['aside_tags'] as $index=>$value): ?>
			<li><a href="/boards/poll_communities/index.php?tag=<?=$value['name'] ?>" class="css_class"><?php echo $value['name'] ?></a></li>
			<?php endforeach ?>
		</ul>
	</div>
</div>