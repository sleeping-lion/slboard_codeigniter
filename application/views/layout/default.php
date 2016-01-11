<?php echo doctype('html5')."\n" ?>
<html>
<head>
	<?php echo meta($meta); ?>
	<title><?php echo $title_for_layout; ?></title>
	<link href="/images/favicon.ico" type="image/x-icon" rel="shortcut icon"/>	
	<?php echo $style_for_layout."\n"; ?>
	<meta content="" name="description" />
	<meta content="" name="keywords" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />		
	<meta name="author" content="sleeping-lion" />
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<![endif]-->
</head>
<body itemscope itemtype="<?php echo $common_data['page_itemtype'] ?>">
	<?php echo $Layout->element('header') ?>
	<div id="mom">
		<div id="main" class="container">
		<?php if($this -> router -> fetch_class()=='home'): ?>
		<?php echo $Layout->element('jumbotron') ?>
		<?php else: ?>
		<?php echo $Layout->element('page_header') ?>
		<?php endif ?>
		<section class="sub_main">
			<?php echo $Layout->element('message') ?>
			<?php echo $contents_for_layout ?>
		</section>
		<?php echo $Layout->element('aside') ?>		
		</div>
	</div>
	<?php echo $Layout->element('footer') ?>
	<?php echo "\n".$script_for_layout."\n" ?>	
</body>
</html>
