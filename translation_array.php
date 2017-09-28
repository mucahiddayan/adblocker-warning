<?php 
require_once  $_SERVER["DOCUMENT_ROOT"]."/wp-load.php";
$other_pages = explode (';',get_option( 'abw_other_pages'));
$translation_array = array(
	'pages' => array(
		'home' => wpautop(get_post(get_option( 'abw_home' ))->post_content),
		'anleitung' => wpautop(get_post(get_option( 'abw_anleitung'))->post_content)
	),
	'development' => get_option( 'abw_development'),
	'activated'=> get_option( 'abw_activated'),
	'other_pages' => $other_pages,
	'column' => 'PASSWORD',
	'plugin_url' => home_url()
);

foreach ($other_pages as $key => $value) {
	$pages = explode(':',$value);			
$translation_array['pages'][$pages[0]] = wpautop(get_post($pages[1])->post_content);#array($pages[1]);
}

if($_POST['func'] == 'adblocker_warning'){
	echo json_encode($translation_array);
}
