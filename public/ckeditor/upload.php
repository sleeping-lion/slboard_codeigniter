<?php
	require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'setting.php';
	
	$clean = filter_input_array(INPUT_GET, array('CKEditorFuncNum' => FILTER_VALIDATE_INT));

	$clean['upload']=check_file($_FILES['upload']);
	move_file($clean['upload'],'ckeditor',$_SESSION['USER_ID']);
	
	if( class_exists("Imagick") ) {
	/*** the image file ***/
$image = UPLOAD_DIRECTORY.'/ckeditor/'.$_SESSION['USER_ID'].'/'.$clean['upload']['name'];
/*** a new imagick object ***/
$im = new Imagick();
/*** ping the image ***/
$im->pingImage($image);
/*** read the image into the object ***/
$im->readImage( $image );
/*** thumbnail the image ***/
$im->resizeImage(760,0,Imagick::FILTER_LANCZOS,1);
/*** Write the thumbnail to disk ***/
$im->writeImage();
/*** Free resources associated with the Imagick object ***/
$im->destroy();
echo UPLOAD_DIRECTORY.'/ckeditor/'.$_SESSION['USER_ID'].'/'.$clean['upload']['name'];
	} else {
				echo '2';
	}
	
  	// require WEBROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'phpThumb' . DIRECTORY_SEPARATOR . 'phpThumb.config.php';
	$url='/uploads/ckeditor/'.$_SESSION['USER_ID'].'/'.$clean['upload']['name'];

	echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$clean['CKEditorFuncNum'].',"'.$url.'","업로드 완료")</script>';
