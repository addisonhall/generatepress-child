<?php
/**
 * Add widgets to the dashboard.
 *
 * Must be included in functions.php
 *
 * THE FOLLOWING ARE ALL ONLY EXAMPLES. DUPLICATE AND MODIFY AS NEEDED.
 *
 * @package GenerateChild
 */
 
/**
 * Display custom shortcodes.
 */
function gpc_shortcodes_dashboard_widget() {
	wp_add_dashboard_widget(
    'gpc_shortcodes_dashboard_widget', // Widget slug.
    'Shortcodes', // Title.
    'gpc_shortcodes_dashboard_widget_function' // Display function.
  );	
}
add_action( 'wp_dashboard_setup', 'gpc_shortcodes_dashboard_widget' );
function gpc_shortcodes_dashboard_widget_function() { ?>
	<p>These are shortcodes you can use within a page or post to display data:</p>
  <dl>
    <dt>[sample_short_code]</dt>
    <dd>Show a custom post type list?</dd>
  </dl>
<?php } ?>