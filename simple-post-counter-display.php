<?php
   /*
   Plugin Name: Display Simple Post View Count
   Plugin URI: https://wordpress.org/plugins/simple-post-counter-display/
   description: A plugin to simple post count display
   Version: 1.0.0
   Author: aistechnolabs
   Author URI: https://www.aistechnolabs.com/
   License: GPL1
   */
   
   
// only include add-on once
define( 'SPCD_PATH', plugin_dir_path(__FILE__) );
require_once( SPCD_PATH . 'spcd-function.php' );

/**
 * Admin side js and css 
 * Plugins URL
 */
define( 'SPCD_URL', plugins_url('', __FILE__));

// Admin side css add 
function spcd_ev_load_custom_wp_admin_style() {
    wp_register_style('style', SPCD_URL . '/css/style.css', false, '1.0.0');
    wp_enqueue_style('style');
}
add_action('admin_enqueue_scripts', 'spcd_ev_load_custom_wp_admin_style');

?>