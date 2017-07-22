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
 * Display video tutorials link.
 */
function gpc_tutorials_dashboard_widget() {
  wp_add_dashboard_widget(
    'gpc_tutorials_dashboard_widget', // Widget slug.
    'Video Tutorials', // Title.
    'gpc_tutorials_dashboard_widget_function' // Display function.
  );	
}
add_action( 'wp_dashboard_setup', 'gpc_tutorials_dashboard_widget' );
function gpc_tutorials_dashboard_widget_function() {
  echo '<p>You may access video tutorials for this website here:</p>
  <p><a href="https://vimeo.com/" target="_blank">Coming soon</a><br>
  Password: NA</p>';
}

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
function gpc_shortcodes_dashboard_widget_function() {
  echo '<p>Any custom shortcodes for use on your site will appear here.</p>';
  echo '<dl>';
  echo '<dt>[gpc_output_staff]</dt>';
  echo '<dd>Output a list of staff members.</dd>';
  echo '</dl>';
}