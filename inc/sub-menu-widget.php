<?php
/**
 * Much needed contextual sub-menu for GeneratePress.
 *
 * This adds a GPC Sub Menu widget that will output
 * a contextual portion of the primary menu to use
 * as a sub menu on inner pages.
 *
 * TODO: Convert this to a plugin!
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
    $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : 'In this section';
    $menu_theme_location = isset( $instance[ 'menu_theme_location' ] ) ? $instance[ 'menu_theme_location' ] : 'primary';

    require get_stylesheet_directory() . '/inc/sub-menu.php';
    $sub_menu_output = wp_nav_menu( array( 'theme_location' => $menu_theme_location, 'sub_menu' => true, 'echo' => false ) );

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
    $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : 'In this section';
    $menu_theme_location = isset( $instance[ 'menu_theme_location' ] ) ? $instance[ 'menu_theme_location' ] : 'primary';
    // Get menu theme locations
    $menus = get_registered_nav_menus();

    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'menu_theme_location' ); ?>"><?php _e( 'Select menu theme location:' ); ?></label>
      <select id="<?php echo $this->get_field_id( 'menu_theme_location' ); ?>" name="<?php echo $this->get_field_name( 'menu_theme_location' ); ?>">
        <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
        <?php foreach ( $menus as $location => $description ) : ?>
          <option value="<?php echo esc_attr( $location ); ?>" <?php selected( $menu_theme_location, $location ); ?>>
            <?php echo esc_html( $description ); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </p>
    <?php 
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    if ( ! empty( $new_instance['title'] ) ) {
      $instance['title'] = sanitize_text_field( $new_instance['title'] );
    }
    if ( ! empty( $new_instance['menu_theme_location'] ) ) {
      $instance['menu_theme_location'] = sanitize_text_field( $new_instance['menu_theme_location'] );
    }
    return $instance;
  }

} // Class gpc_sub_menu_widget ends here