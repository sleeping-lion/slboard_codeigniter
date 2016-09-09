<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

//인자로 들어오는 값을 2번 쓰는 잉여함수
function bar_color($index) {
	$dd = $index % 4;

	switch($dd) {
		case 0 :
			return 'success';
			break;
		case 1 :
			return 'info';
			break;
		case 2 :
			return 'warning';
			break;
		case 3 :
			return 'danger';
			break;
	}
}

function tag_cloud(Array $tags, Array $classes) {
	$max_count = $tags[0]['taggings_count'];

	foreach ($tags as $index => $value) {
		$c_index = (($value['taggings_count'] / $max_count) * (count($classes) - 1));
		$tags[$index]['class'] = $classes[round($c_index)];
	}

	$name = array();
	foreach ($tags as $index => $row) {
		$name[$index] = $row['name'];
	}

	shuffle($name);
	array_multisort($name, SORT_DESC, $tags);

	return $tags;
}

function tag_restore($tags) {
	if(!is_array($tags))
		return '';
	
	$cc=count($tags);
	
	if(!$cc)
		return '';
	
	$tag_s='';
	
	foreach($tags as $index=>$value) {
		$tag_s.=$value['name'];
		if($index+1<$cc)
			$tag_s.=',';
	}
	return $tag_s;
}

function sl_date($date,$type=1) {

	switch($type) {
		case 'w3c' :
			$date=str_replace(' ', 'T', $date);
			break;
		default :
			$time=strtotime($date);
			$date=date('Y-m-d',$time);
	}
	
	return $date;
}


function sl_get_thumb($url,$type='origin') {
	switch($type) {
		case 'large' :
			$prefix='large_thumb';
			break;
		case 'medium' :
			$prefix='medium_thumb';
			break;
		case 'small' :
			$prefix='small_thumb';
			break;
		default : 
			break;
	}	
	
	if(isset($prefix)) {
		$pathinfo=pathinfo($url);
		$url=$pathinfo['dirname'].'/'.$prefix.'_'.$pathinfo['basename'];
	}

	return $url;
} 

function sl_show_anchor($url, $title, Array $options = array()) {
	parse_str($_SERVER['QUERY_STRING'], $qs_a);
	
	$e=explode('/',uri_string());
	
	if(count($e)) {
		if($e[0]=='tags') {
			$qs_a['tag']=$e[1];
		}
	}
	
	$count = count($qs_a);
	
	if ($count) {
		$i=0;
		foreach($qs_a as $key=>$value) {
			if($i) {
				$url.='&';
			} else {
				$url.='?';
			}
			$url.=$key.'='.$value;
			$i++;
		}
	}

	return anchor($url, $title, $options);
}

function sl_index_anchor($url, $title, Array $options = array()) {
	parse_str($_SERVER['QUERY_STRING'], $qs_a);
	$count = count($qs_a);
	
	if(array_key_exists('tag',$qs_a)) {
		$url='/tags/'.$qs_a['tag'];
		unset($qs_a['tag']);
	}
	
	if ($count) {
		$i=0;
		foreach($qs_a as $key=>$value) {
			if($i) {
				$url.='&';
			} else {
				$url.='?';
			}
			$url.=$key.'='.$value;
			$i++;
		}
	}

	return anchor($url, $title, $options);
}

function sl_active_class($className, $classonly = false) {
	$return = false;

	$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);

	if (is_array($className)) {
		if (in_array($segments[1], $className)) {
			$return = true;
		}
	} else {
		if (!strcmp($segments[1], $className)) {
			$return = true;
		}
	}

	if ($return) {
		if ($classonly) {
			return ' active';
		} else {
			return 'class="active"';
		}
	} else {
		return false;
	}
}
?>