<?php
/**
 * Much needed contextual sub-menu for GeneratePress.
 *
 * This adds a GPC Sub Menu widget that will output
 * a contextual portion of the primary menu to use
 * as a sub menu on inner pages.
 *
 * @package GenerateChild
 * @link https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Register and load the widget
function gpc_load_sub_menu_widget() {
	register_widget( 'gpc_sub_menu_widget' );
}
add_action( 'widgets_init', 'gpc_load_sub_menu_widget' );

// Creating the widget 
class gpc_sub_menu_widget extends WP_Widget {

  function __construct() {
    parent::__construct(

    // Base ID of your widget
    'gpc_sub_menu_widget', 

    // Widget name will appear in UI
    __('GPC Sub Menu Widget', 'gpc_sub_menu_widget_domain'), 

    // Widget description
    array( 'description' => __( 'A contextual sub-menu for GeneratePress', 'gpc_sub_menu_widget_domain' ), ) 
    );
  }

  // Creating widget front-end

  public function widget( $args, $instance ) {
    require get_stylesheet_directory() . '/inc/sub-menu.php';
    $title = apply_filters( 'widget_title', $instance['title'] );
    $sub_menu_output = wp_nav_menu( array( 'theme_location' => 'primary', 'sub_menu' => true, 'link_after' => '', 'echo' => false ) );

    if ( $sub_menu_output ) {
      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

      // This is where you run the code and display the output
      echo $sub_menu_output;
      echo $args['after_widget'];
    }
  }
      
  // Widget Backend 
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'In this section', 'gpc_sub_menu_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
  $instance = array();
  $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
  return $instance;
  }

} // Class gpc_sub_menu_widget ends here