<?php
/**
 * Additional inline styles.
 *
 * These additional styles pull styling
 * info from customizations in GeneratePress.
 * It requires the Colors portion of the
 * premium add-on.
 *
 * @package GenerateChild
 * @link https://generatepress.com/downloads/generate-colors/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'gpc_base_inline_css_func' ) ) :

  function gpc_base_inline_css_func() {

    // Get our settings
    $gpc_settings = wp_parse_args( 
      get_option( 'generate_settings', array() ),
      generate_get_color_defaults()
    );

    // Initiate our CSS class
    $gpc_css = new GeneratePress_CSS;

    // Form button-outline
    $gpc_css->set_selector( '.button.button-outline, .button.button-outline:visited, .woocommerce .button.button-outline, .woocommerce .button.button-outline:visited' );
		$gpc_css->add_property( 'border-color', esc_attr( $gpc_settings[ 'form_button_background_color' ] ) );
		$gpc_css->add_property( 'color', esc_attr( $gpc_settings[ 'form_button_background_color' ] ) );

    // Form button-outline hover
    $gpc_css->set_selector( '.button.button-outline:hover, .button.button-outline:focus, .woocommerce .button.button-outline:hover, .woocommerce .button.button-outline:focus' );
		$gpc_css->add_property( 'border-color', esc_attr( $gpc_settings[ 'form_button_background_color_hover' ] ) );
		$gpc_css->add_property( 'color', esc_attr( $gpc_settings[ 'form_button_background_color_hover' ] ) );

    // Allow us to hook CSS into our output
    // do_action( 'gpc_base_inline_css', $gpc_css );

		// Return our dynamic CSS
		return $gpc_css->css_output();

  }

endif;

add_action( 'wp_enqueue_scripts', 'gpc_add_inline_styles' );
function gpc_add_inline_styles() {
  $gpc_css = gpc_base_inline_css_func();
  wp_add_inline_style( 'gpc-base', $gpc_css );
}