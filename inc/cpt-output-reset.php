<?php
/**
 * Shut off default post type and taxonomy output.
 *
 * These attempt to shut down the standard output so that we can define our own.
 * Must be included in functions.php
 *
 * THE FOLLOWING ARE ALL ONLY EXAMPLES. DUPLICATE AND MODIFY AS NEEDED.
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Array of post types and taxonomies to affect.
 */
$post_types = array( 'custom_post_type', 'custom_post_type_2' );
$custom_taxonomies = array( 'custom_taxonomy', 'custom_taxonomy_2' );

/**
 * Remove default archive title.
 */
add_action( 'pre_get_posts', 'gpc_remove_archive_title' );
function gpc_remove_archive_title() {
  global $post_types, $custom_taxonomies;
  if ( is_post_type_archive( $post_types ) || is_tax( $custom_taxonomies ) ) {
    remove_action( 'generate_archive_title', 'generate_archive_title' );
  }
}

/**
 * Remove default post image for all archives.
 */
add_action( 'generate_after_entry_header', 'gpc_remove_default_archive_image', 5 );
function gpc_remove_default_archive_image() {
  global $post_types, $custom_taxonomies;
  if ( is_post_type_archive( $post_types ) || is_tax( $custom_taxonomies ) ) {
    remove_action( 'generate_after_entry_header', 'generate_blog_post_image' );
  }
}

/**
 * Remove default post image for single view on specified post types.
 */
add_action( 'generate_before_content', 'gpc_remove_default_single_image', 0 );
function gpc_remove_default_single_image() {
  if ( is_singular( 'custom_post_type' ) || is_singular( 'custom_post_type_2' ) ) {
    remove_action( 'generate_before_content', 'generate_featured_page_header_inside_single', 10 );
    remove_action( 'generate_before_content', 'generate_page_header_single', 10);
    remove_action( 'generate_after_entry_header', 'generate_page_header_single_below_title', 10);
    remove_action( 'generate_after_header', 'generate_page_header_single_above', 10);
  }
}

/**
 * Add custom post archive titles to specified post types and taxonomies
 */
add_action( 'generate_before_main_content', 'gpc_add_custom_archive_title' );
function gpc_add_custom_archive_title() {
  global $post_types, $custom_taxonomies;
  // custom post type
  if ( is_post_type_archive( $post_types ) ) {
    echo '<header class="page-header"><h1 class="page-title">';
    post_type_archive_title();
    echo '</h1></header>';
  }
  // custom taxonomies
  if ( is_tax( $custom_taxonomies ) ) {
    echo '<header class="page-header"><h1 class="page-title">Custom Taxonomy: ';
    single_term_title();
    echo '</h1></header>';
  }
}