<?php
/*
Plugin Name: Timeline Ultimate
Plugin URI: http://paratheme.com/items/timeline-ultimate-timeline-style-grid-for-wordpress/
Description: Fully responsive and mobile ready facebook style timeline for wordpress.
Version: 1.3
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('timeline_um_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('timeline_um_plugin_dir', plugin_dir_path( __FILE__ ) );
define('timeline_um_wp_url', 'http://wordpress.org/plugins/timeline-ultimate' );
define('timeline_um_pro_url', 'http://paratheme.com/items/timeline-ultimate-timeline-style-grid-for-wordpress/' );
define('timeline_um_demo_url', 'http://paratheme.com' );
define('timeline_um_conatct_url', 'http://paratheme.com/contact' );
define('timeline_um_plugin_name', 'Timeline Ultimate' );
define('timeline_um_share_url', 'http://wordpress.org/plugins/timeline-ultimate' );


require_once( plugin_dir_path( __FILE__ ) . 'includes/timeline-um-meta.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/timeline-um-functions.php');


//Themes php files
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat/index.php');



function timeline_um_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('timeline_um_js', plugins_url( '/js/scripts.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script('timeline_um_js', 'timeline_um_ajax', array( 'timeline_um_ajaxurl' => admin_url( 'admin-ajax.php')));
		wp_enqueue_style('timeline_um_style', timeline_um_plugin_url.'css/style.css');

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'timeline_um_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		//ParaAdmin
		wp_enqueue_style('ParaAdmin', timeline_um_plugin_url.'ParaAdmin/css/ParaAdmin.css');
		//wp_enqueue_style('ParaIcons', accordions_plugin_url.'ParaAdmin/css/ParaIcons.css');		
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));
		
		// Style for themes
		wp_enqueue_style('timeline_um-style-flat', timeline_um_plugin_url.'themes/flat/style.css');			

		
	}
add_action("init","timeline_um_init_scripts");







register_activation_hook(__FILE__, 'timeline_um_activation');
register_deactivation_hook(__FILE__, 'timeline_um_deactivation');

function timeline_um_activation()
	{
		$timeline_um_version= "1.2";
		update_option('timeline_um_version', $timeline_um_version); //update plugin version.
		
		$timeline_um_customer_type= "free"; //customer_type "free"
		update_option('timeline_um_customer_type', $timeline_um_customer_type); //update plugin version.
		
		

		
		
	}


function timeline_um_deactivation()
	{
		
		$timeline_um_version = get_option('timeline_um_version');
		
		$api_url = 'http://paratheme.com/installstats/';
		$wp_version = get_bloginfo('version'); // no change
		$domain = get_bloginfo( 'url' ); // no change
		$item_slug = basename(dirname(__FILE__)); // no change
		$item_version = $timeline_um_version; // current item version
		$item_type = 'plugin'; // plugin, theme, addon		
		$action = 'deactivate'; //active, deactivate, install, uninstall
	
		$request_string = array(
				'user-agent' => $wp_version . '; ' . $domain . '; ' . $item_slug . '; ' . $item_version . '; ' . $item_type. '; ' . $action,

				
			);

		wp_remote_post($api_url, $request_string);

		
	}










function timeline_um_display($atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",

				), $atts);


			$post_id = $atts['id'];

			$timeline_um_themes = get_post_meta( $post_id, 'timeline_um_themes', true );

			$timeline_um_display ="";

			if($timeline_um_themes== "flat")
				{
					$timeline_um_display.= timeline_um_body_flat($post_id);
				}

return $timeline_um_display;



}

add_shortcode('timeline_um', 'timeline_um_display');

