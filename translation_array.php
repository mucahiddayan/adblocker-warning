<?php 
require_once  $_SERVER["DOCUMENT_ROOT"]."/wp-load.php";
$other_pages = explode (';',get_option( 'abw_other_pages'));
$translation_array = array(
	'pages' 					=> array(
		'home'					=> wpautop(get_post(get_option( 'abw_home' ))->post_content),
		'anleitung' 			=> wpautop(get_post(get_option( 'abw_anleitung'))->post_content)
	),
	'development' 				=> get_option( 'abw_development'),
	'activated'					=> get_option( 'abw_activated'),
	'margin_side'				=> get_option( 'abw_margin_side'),
	'margin_top'				=> get_option( 'abw_margin_top'),
	'overlay_background_color'	=> get_option( 'abw_overlay_background_color','#ffffff'),
	'overlay_opacity'			=> get_option( 'abw_overlay_opacity','0'),
	'overlay_box_shadow_top'	=> get_option( 'overlay_box_shadow_top','40'),
	'overlay_box_shadow_side'	=> get_option( 'overlay_box_shadow_side','0'),
	'overlay_box_shadow_blur'	=> get_option( 'overlay_box_shadow_blur','60'),
	'overlay_box_shadow_spread'	=> get_option( 'overlay_box_shadow_spread','0'),
	'other_pages' 				=> $other_pages,
	'column' 					=> 'PASSWORD',
	'plugin_url' 				=> home_url()
);

foreach ($other_pages as $key => $value) {
	$pages = explode(':',$value);			
$translation_array['pages'][$pages[0]] = wpautop(get_post($pages[1])->post_content);#array($pages[1]);
}

if($_POST['func'] == 'adblocker_warning'){
	echo json_encode($translation_array);
}

if($POST['func'] == 'TEST'){
	print 'Test';
}
