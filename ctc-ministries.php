<?php
/*
    Plugin Name: Church Ministries
    Description: Plugin to add a Ministry post type. Along the same lines as Church Theme Content, it only handles the information collection, not the display. It does not require CTC. A compatible theme is required to 
    Version: 1.0
    Author: Justin R. Serrano
*/

// No direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once( sprintf( "%s/ctc-ministries-class.php", dirname(__FILE__) ) );

if( class_exists( 'CTC_Ministries' ) ) {
	new CTC_Ministries();
}

// Clear rewrite rules so post type URLS can take effect
function ctc_ministry_activation() {
	add_action( 'init', 'ctc_ministry_flush_rewrite_rules', 11 ); // after post types, taxonomies registered
}

register_activation_hook( __FILE__, 'ctc_ministry_activation' );

/**
 * Flush rewrite rules
 *
 * @since 0.9
 */
function ctc_ministry_flush_rewrite_rules() {
	flush_rewrite_rules();
}

?>
