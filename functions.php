<?php
/**
 * GeneratePress Child Theme functions and definitions
 *
 * All functions are prefixed with gpc_
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GPC_VERSION', '1.0');

/**
 * Get current user.
 */
$gpc_current_user = wp_get_current_user();

/**
 * Hide admin bar.
 */
show_admin_bar( false );

/**
 * Show all the Google fonts.
 * @link https://docs.generatepress.com/article/customizing-the-google-font-list/
 */
add_filter( 'generate_number_of_fonts', 'gp_show_all_available_google_fonts' );
function gp_show_all_available_google_fonts() {
	return 'all';
}

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'gpc_scripts' );
function gpc_scripts() {
	wp_enqueue_style( 'gpc-base', get_stylesheet_directory_uri() . '/css/base.css', false, GPC_VERSION, 'all');
	wp_enqueue_script( 'gpc-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), GPC_VERSION, true );
}

/**
 * Enqueue admin scripts and styles.
 */
add_action( 'admin_enqueue_scripts', 'gpc_load_admin_style' );
function gpc_load_admin_style() {
  global $gpc_current_user;
  if ( in_array( 'editor', (array) $gpc_current_user->roles ) ) {
    wp_enqueue_style( 'admin-editor-role-css', get_stylesheet_directory_uri() . '/admin/css/role-editor.css', false, GPC_VERSION, 'all' );
  }
}

/**
 * Add .has-js class to html element.
 */
add_action( 'generate_before_header','gpc_add_js_class' );  
function gpc_add_js_class() { ?> 
	<script>
		jQuery('html').addClass('has-js');
	</script>
<?php }

/**
 * Add custom capability for GeneratePress meta boxes.
 * Requires GeneratPress addons:
 * @link https://generatepress.com/premium/
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
 */
add_action( 'add_meta_boxes', 'gpc_remove_meta_boxes', 999 );
function gpc_remove_meta_boxes() {
  // Posts
	remove_meta_box('generate_de_meta_box', 'post', 'side'); // Disable elements
	remove_meta_box('generate_footer_widget_meta_box', 'post', 'side'); // Footer widgets
	remove_meta_box('generate_layout_meta_box', 'post', 'side'); // Sidebar layout
	remove_meta_box('generate_page_builder_meta_box', 'post', 'side'); // Page builder integration
	remove_meta_box('generate_page_header_meta_box', 'post', 'normal'); // Page header
  // Pages
	remove_meta_box('generate_footer_widget_meta_box', 'page', 'side'); // Footer widgets
	remove_meta_box('generate_page_builder_meta_box', 'page', 'side'); // Page builder integration
}

/**
 * Give Editors access to menus and widgets.
 */
add_action( 'admin_menu', 'gpc_editor_menu_page_removing', 999 );
function gpc_editor_menu_page_removing() {
  global $gpc_current_user;
  if ( in_array( 'editor', (array) $gpc_current_user->roles ) ) {
    remove_menu_page( 'themes.php' );
    add_menu_page( 'Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 60 );
    add_menu_page( 'Widgets', 'Widgets', 'edit_theme_options', 'widgets.php', '', 'dashicons-layout', 61 );
  }
}

/**
 * Responsive embedded video.
 */
add_filter( 'embed_oembed_html', 'gpc_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'gpc_embed_html' ); // Jetpack
function gpc_embed_html( $html ) {
	return '<div class="video-container">' . $html . '</div>';
}

/**
 * Initialize ACF Google Maps.
 */
// add_action('acf/init', 'gpc_acf_init');
function gpc_acf_init() {
	acf_update_setting('google_api_key', 'key_goes_here');
}

/**
 * Enable shortcodes in widgets.
 */
add_filter( 'widget_text' , 'do_shortcode' );

/**
 * Enable further custom styles.
 */
require get_stylesheet_directory() . '/inc/styles.php';

/**
 * Include optimizations.
 */
require get_stylesheet_directory() . '/inc/optimizations.php';

/**
 * Include Sub Menu widget.
 */
require get_stylesheet_directory() . '/inc/sub-menu-widget.php';

/**
 * Include custom image sizes.
 */
// require get_stylesheet_directory() . '/inc/image-sizes.php';

/**
 * ACF relationship helpers. Uncomment to use.
 */
// require get_stylesheet_directory() . '/inc/acf-relationships.php';

/**
 * Reset custom post type output. Uncomment to use.
 */
// require get_stylesheet_directory() . '/inc/cpt-output-reset.php';

/**
 * Include new custom post type output. Uncomment to use.
 */
// require get_stylesheet_directory() . '/inc/cpt-output-custom.php';

/**
 * Include shortcodes. Uncomment to use.
 */
// require get_stylesheet_directory() . '/inc/shortcodes.php';

/**
 * Include dashboard widgets.
 */
// require get_stylesheet_directory() . '/inc/dashboard-widgets.php';
