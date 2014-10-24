<?php
/**
 * Ministries Class
 *
 * @package    CTC Ministries
 * @copyright  Copyright (c) 2014, Justin Serrano
 * @link       https://github.com/serranoabq/ctc-ministries
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since      0.9
 */


if ( ! class_exists( 'CTC_Ministries' ) ) {
	class CTC_Ministries {
		
		public function __construct() {
			// Church Theme Content is REQUIRED
			if ( ! class_exists( 'Church_Theme_Content' ) ) return;
			if ( is_admin() ) {
				// CTMB_URL is defined in CTC
				if( defined( 'CTMB_URL' ) )
					require_once trailingslashit( 'CTMB_URL' ) . 'ct-meta-box.php';
				else
					require_once require_once( sprintf( "%s/includes/libraries/ct-meta-box/ct-meta-box.php", dirname(__FILE__) ) );
				require_once require_once( sprintf( "%s/ctc-ministries-fields.php", dirname(__FILE__) ) );
			}
			
			add_action( 'init', array( &$this, 'ctc_register_post_type_ministry' ) ); // register post type
			
			add_shortcode( 'ctc_ministry', array( &$this, 'shortcode' ) );
		}
		
/**
 * Register ministry post type
 *
 * @since 0.9
 */
		function ctc_register_post_type_ministry() {
			$args = array(
				'labels' => array(
					'name'								=> __( 'Ministries', 'harvest' ),
					'singular_name'				=> __( 'Ministry', 'harvest' ),
					'add_new' 						=> __( 'Add New Ministry', 'harvest' ),
					'add_new_item' 				=> __( 'Add Ministry', 'harvest' ),
					'edit_item' 					=> __( 'Edit Ministry', 'harvest' ),
					'new_item' 						=> __( 'New Ministry', 'harvest' ),
					'all_items' 					=> __( 'All Ministries', 'harvest' ),
					'view_item' 					=> __( 'View Ministry', 'harvest' ),
					'search_items' 				=> __( 'Search Ministries', 'harvest' ),
					'not_found' 					=> __( 'No ministries found', 'harvest' ),
					'not_found_in_trash' 	=> __( 'No ministries found in Trash', 'harvest' )
				),
				'public' 				=> true,
				'has_archive' 	=> false,
				'rewrite'				=> array(
					'slug' 				=> 'ministries',
					'with_front' 	=> false,
					'feeds'				=> false
				),
				'supports' 			=> array( 'title', 'editor', 'publicize', 'thumbnail' ), 
				'menu_icon'			=> 'dashicons-groups',
				'menu_position'	=> 5 // below Posts
			);
			$args = apply_filters( 'ctc_post_type_ministry_args', $args ); // allow filtering
			
			// Registration
			register_post_type(
				'ctc_ministry',
				$args
			);
		}
		
/**********************************
 * SHORTCODE
 **********************************/
		
		/**
		 * Parse shortcode and insert ministry information
		 * Usage: [ctc_ministry] 
		 *   Optional parameters:
		 *     name = ''
		 *       Ministry post slug to display 
		 *     class = ''
		 *       CSS class to add to div with content 
		 *     before=''
		 *       Markup to insert before the ministry information
		 *     after = ''
		 *       Markup to insert after the ministry information 
		 *
		 * @since 0.9
		 * @param string $attr Shortcode options
		 * @return string Ministry post markup, with thumbnail
		 */
		 public function shortcode( $attr ) {
			$output = apply_filters( array( &$this, 'shortcode' ), '', $attr );
			
			if ( $output != '' ) return $output;
			
			extract( shortcode_atts( array(
				'name'			=>  null,  
				'class'			=>  '',  
				'before'    =>  '',
				'after'     =>  '',
				), $attr ) );
			
			if( ! $name ) return $output;
			
			$args = array( 
				'name' = $name,
				'post_type' => 'ctc_ministry',
				'post_statys' => 'publish',
				'post_per_page' => 1,
			);
			
			global $post;
			$ministries  = get_posts( $args );
			$post = $ministries[0];
			
			// The output of this is as in the post. It is up to the theme to style the output
			// Relevant classes: 
			//  ctc-ministry = main div
			//  ctc-ministry-img = image
			//	ctc-ministry-info = div holding contact information
			//  ctc-ministry-email = email link 
			//  fa-user, fa-envelope, fa-phone = fontawesome icons
			if( $ministries ) {
				setup_postdata($post);
				$poc = get_post_meta( $post->ID, '_ctc_ministry_poc', true ); 
				$email = get_post_meta( $post->ID, '_ctc_ministry_poc_email', true ); 
				$phone = get_post_meta( $post->ID, '_ctc_ministry_poc_phone', true );
				
				$result = '<div class="ctc-ministry ' . $class; . '"> ';
				$result .= '<h3>' . get_the_title(); . '</h3>';
				$result .= '<p> ' . get_the_post_thumbnail( $post->ID, 'post-thumbnail', array( 'class' => 'ctc-ministry-img')) ;
				$result .= get_the_content(); 
				$result .= '</p>';
					
				if( $poc ):
					$result .= '<div class="ctc-ministry-info">';
					$result .= ' <i class="fa-user"></i> <span>'. $poc . '</span><br/>';
					if( $email )
						$result .= ' <i class="fa-envelope"></i> <span><a href="mailto:'. $email .'" class="ctc-ministry-email">'. $email .'</a></span><br/>';
					if( $phone )
						$result .= ' <i class="fa-phone"></i> <span>'. $phone .'</span>';
					$result .= '</div>'
				endif; 
				$result .= '</div>';
			}
			return $before . $result . $after;
		}
	
	
	}
}

?>