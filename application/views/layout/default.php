<?php echo doctype('html5')."\n" ?>
<html lang="ko">
<head>
	<?php echo meta($meta); ?>
	<title><?php echo $title_for_layout; ?></title>
	<link href="/images/favicon.ico" type="image/x-icon" rel="shortcut icon"/>	
	<?php echo $style_for_layout ?>
<?php meta_tags(array('general' => true,'og' => true,'twitter'=> true,'robot'=> true),$common_data['meta_title'],$common_data['meta_description']) ?>
	<?php if(isset($data['tags'])): ?>
	<meta content="<?php echo tag_restore($data['tags']) ?>" name="keywords" />
	<?php else: ?>
	<meta content="정종호,웹프로그래머,웹표준,퍼블리셔,웹개발,리눅스,html,html5,javascript,php,ruby,rails,레일즈,퍼블리싱,publishing,잠자는사자,sl,sleepinglion,sleeping-lion" name="keywords" />
	<?php endif ?>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta name="author" content="Sleeping-Lion" />
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<![endif]-->
  <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script type="text/javascript" src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>    
  <![endif]-->
</head>
<body>
	<?php echo $Layout->element('header') ?>
	<div id="mom">
		<section id="main" class="container">					
		<?php if($this -> router -> fetch_class()=='home'): ?>
		<?php echo $Layout->element('jumbotron') ?>
		<hr class="none">
		<div id="main_main">
		<div class="sub_main">
	<?php if(isset($common_data['ad'])): ?>
	<?php if($common_data['ad']): ?>
	<?php echo $Layout->element('ad') ?>
	<?php endif ?>	
	<?php endif ?>	
			<?php echo $contents_for_layout ?>			
		</div>
		<?php echo $Layout->element('aside') ?>			

</div>
		<?php else: ?>		
		<?php echo $Layout->element('page_header') ?>
		
		<div class="sub_main">
			<?php echo $Layout->element('message') ?>
			
	<?php if(isset($common_data['ad'])): ?>
	<?php if($common_data['ad']): ?>
	<?php echo $Layout->element('ad') ?>
	<?php endif ?>
	<?php endif ?>	
			<?php echo $contents_for_layout ?>

		</div>		
		<?php echo $Layout->element('aside') ?>
		<?php endif ?>
		</section>
	</div>
	<?php echo $Layout->element('footer') ?>
<div class="slboard_overlay" id="overlay"></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog"></div>	
	<?php echo "\n".$script_for_layout."\n" ?>
</body>
</html>
