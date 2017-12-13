<?php
/**
 * User and role related tweaks.
 *
 * Requires Members plugin by Justin Tadlock.
 * @link https://wordpress.org/plugins/members/
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @link https://docs.generatepress.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get current user.
 */
$gpc_current_user = wp_get_current_user();

/**
 * Give Editors and Shop Managers access to menus and widgets.
 */
add_action( 'admin_menu', 'gpc_editor_menu_page_removing', 999 );
function gpc_editor_menu_page_removing() {
  global $gpc_current_user;
  if ( array_intersect( array( 'editor', 'shop_manager' ), (array) $gpc_current_user->roles ) ) {
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'edit.php?post_type=wp_show_posts' );
    remove_menu_page( 'edit.php?post_type=generate_page_header' );
    add_menu_page( 'Menus', 'Menus', 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 60 );
    add_menu_page( 'Widgets', 'Widgets', 'edit_theme_options', 'widgets.php', '', 'dashicons-layout', 61 );
  }
}

/**
 * Enqueue admin scripts and styles.
 */
add_action( 'admin_enqueue_scripts', 'gpc_load_admin_style' );
function gpc_load_admin_style() {
  global $gpc_current_user;
  if ( array_intersect( array( 'editor', 'shop_manager' ), (array) $gpc_current_user->roles ) ) {
    wp_enqueue_style( 'admin-editor-role-css', get_stylesheet_directory_uri() . '/admin/css/role-editor.css', false, GPC_VERSION, 'all' );
  }
}