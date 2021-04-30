<?php
/**
 * WP Widget related tweaks.
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 * @link https://docs.generatepress.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Hide unwanted widgets
 * @link https://codex.wordpress.org/Function_Reference/unregister_widget
 */
add_action( 'widgets_init', 'remove_calendar_widget' );
function remove_calendar_widget() {
	// unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	// unregister_widget('WP_Widget_Archives');
	// unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Media_Audio');
	// unregister_widget('WP_Widget_Media_Image');
	unregister_widget('WP_Widget_Media_Video');
	unregister_widget('WP_Widget_Media_Gallery');
	unregister_widget('WP_Widget_Meta');
	// unregister_widget('WP_Widget_Search');
	// unregister_widget('WP_Widget_Text');
	// unregister_widget('WP_Widget_Categories');
	// unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	// unregister_widget('WP_Nav_Menu_Widget');
	// unregister_widget('WP_Widget_Custom_HTML');
}

/**
 * Remove widget title if starts with !
 */
add_filter( 'widget_title', 'gpc_remove_widget_title' );
function gpc_remove_widget_title( $widget_title ) {
    if ( substr ( $widget_title, 0, 1 ) == '!' )
        return;
    else
        return ( $widget_title );
}