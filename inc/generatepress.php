<?php
/**
 * GeneratePress related tweaks.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @link https://docs.generatepress.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Access GP Premium beta plugins.
 * This can now be done from within WordPress:
 * @link https://docs.generatepress.com/article/beta-testing/
 */
// add_action( 'after_setup_theme','gpc_beta_tester' );
function gpc_beta_tester() {
    add_filter( 'generate_premium_beta_tester','__return_true' ); 
}

/**
 * Move logo above title and tagline
 * @link https://gist.github.com/generatepress/4cfa628cec96088dcbf8dd8cf399b83e
 */
 if ( ! function_exists( 'generate_header_items' ) ) :
    function generate_header_items() {
        generate_construct_header_widget(); // Header widget
        generate_construct_logo(); // Site logo
        generate_construct_site_title(); // Site title and tagline
    }
endif;

/**
 * Decide what capability your admin users need to see GeneratePress meta boxes.
 * Requires GeneratPress addons:
 * @link https://generatepress.com/premium/
 * @link https://docs.generatepress.com/article/generate_metabox_capability/
 */
// add_filter( 'generate_metabox_capability', 'gpc_custom_metabox_capability', 10 );
function gpc_gp_custom_metabox_capability() {
    return 'view_gp_metaboxes';
}

/**
 * Hide GeneratePress meta boxes on specified post types.
 * Requires GeneratPress addons:
 * @link https://generatepress.com/premium/
 * @link https://generatepress.com/forums/topic/hide-screen-options-on-custom-post-type/#post-238774
 * @link https://generatepress.com/forums/reply/469741/
 */
add_action( 'add_meta_boxes', 'gpc_remove_meta_boxes', 999 );
function gpc_remove_meta_boxes() {
    $excluded_post_types = array( 'post' );
	remove_meta_box('generate_layout_options_meta_box', $excluded_post_types, 'normal'); // Disable all layout options
	remove_meta_box('generate_layout_options_meta_box', $excluded_post_types, 'side'); // Disable all layout options
	remove_meta_box('_generate_use_sections_metabox', $excluded_post_types, 'side'); // Disable sections

    // remove members meta box on selected post types
    $members_excluded_post_types = array( 'page', 'post', );
    remove_meta_box( 'members-cp', $members_excluded_post_types, 'advanced' );
}