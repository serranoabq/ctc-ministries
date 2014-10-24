<?php
/**
 * Ministry Fields
 *
 * Meta boxes and admin columns.
 *
 * @package    CTC Ministries
 * @copyright  Copyright (c) 2014, Justin Serrano
 * @link       https://github.com/serranoabq/ctc-ministries
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**********************************
 * TITLE FIELD
 **********************************/

/**
 * Change "Enter title here"
 *
 * @since 0.9
 * @param string $title Default title placeholder
 * @return string Modified placeholder
 */
function ctc_ministry_title_text( $title ) {

	$screen = get_current_screen();

	if  ( 'ctc_ministry' == $screen->post_type ) {
		$title = __( 'Enter ministry name here', 'ctc-ministry' );
	}

	return $title;

}

add_filter( 'enter_title_here', 'ctc_ministry_title_text' );

/**********************************
 * META BOXES
 **********************************/

/**
 * Ministry details
 *
 * @since 0.9
 */
function ctc_add_meta_box_ministry_details() {

	// Configure Meta Box
	$meta_box = array(

		// Meta Box
		'id' 				=> 'ctc_ministry_details', // unique ID
		'title' 		=> _x( 'Ministry Details', 'meta box', 'ctc-ministry' ),
		'post_type'	=> 'ctc_ministry',
		'context'	=> 'normal', 
		'priority'	=> 'high', 

		// Fields
		'fields' => array(


			// POC
			'_ctc_ministry_poc' => array(
				'name'						=> __( 'Point of Contact Name', 'ctc-ministry' ),
				'after_name'			=> '', 
				'desc'						=> __( "Enter the name of the person to contact for this ministry", 'ctct-ministry' ),
				'type'						=> 'text', 
				'checkbox_label'	=> '', 
				'options'					=> array(), 
				'upload_button'		=> '', 
				'upload_title'		=> '', 
				'upload_type'			=> '', 
				'default'					=> '', 
				'no_empty'				=> false, 
				'allow_html'			=> false, 
				'attributes'			=> array(), 
				'class'						=> 'ctmb-medium', 
				'field_attributes'	=> array(), 
				'field_class'			=> '', 
				'custom_sanitize'	=> '', 
				'custom_field'		=> '', 
			),

			// Phone
			'_ctc_ministry_phone' => array(
				'name'						=> _x( 'POC Phone', 'metabox', 'ctc-ministry' ),
				'after_name'			=> '', 
				'desc'						=> '',
				'type'						=> 'text', 
				'checkbox_label'	=> '', 
				'options'					=> array(), 
				'upload_button'		=> '', 
				'upload_title'		=> '', 
				'upload_type'			=> '', 
				'default'					=> '', 
				'no_empty'				=> false, 
				'allow_html'			=> false, 
				'attributes'			=> array(), 
				'class'						=> 'ctmb-medium', 
				'field_attributes'	=> array(), 
				'field_class'			=> '', 
				'custom_sanitize'	=> '', 
				'custom_field'		=> '', 
			),

			// Email
			'_ctc_ministry_email' => array(
				'name'						=> __( 'POC Email', 'location meta box', 'ctc-ministry' ),
				'after_name'			=> '', 
				'desc'						=> '',
				'type'						=> 'text', 
				'checkbox_label'	=> '', 
				'options'					=> array(), 
				'upload_button'		=> '', 
				'upload_title'		=> '', 
				'upload_type'			=> '', 
				'default'					=> '', 
				'no_empty'				=> false, 
				'allow_html'			=> false, 
				'attributes'			=> array(), 
				'class'						=> 'ctmb-medium', 
				'field_attributes'	=> array(), 
				'field_class'			=> '', 
				'custom_sanitize'	=> 'sanitize_email', 
				'custom_field'		=> '', 
			),

		),

	);

	// Add Meta Box
	new CT_Meta_Box( $meta_box );

}

add_action( 'admin_init', 'ctc_add_meta_box_ministry_details' );

/**********************************
 * ADMIN COLUMNS
 **********************************/

/**
 * Change person list column content
 *
 * @since 0.9
 * @param string $column Column being worked on
 */
function ctc_ministry_columns_content( $column ) {

	global $post;

	switch ( $column ) {

		// Thumbnail
		case 'ctc_ministry_thumbnail' :

			if ( has_post_thumbnail() ) {
				echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, array( 80, 80 ) ) . '</a>';
			}

			break;

		// Position
		case 'ctc_ministry_poc' :
 
			echo get_post_meta( $post->ID , '_ctc_person_poc' , true );

			break;

	}

}

add_action( 'manage_posts_custom_column' , 'ctc_ministry_columns_content' ); // add content for columns


?>