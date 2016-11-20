<?php
/**
 * Additional inline styles.
 *
 * These additional styles pull styling info
 * from customizations in GeneratePress.
 *
 * @package GenerateChild
 * @link https://github.com/tomusborne/GeneratePress/blob/7bb38855e0e92b3585956f8c3757b46a57d8e31c/inc/add-ons/colors.php
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( !function_exists('generate_get_color_defaults') && !function_exists('generate_advanced_css') ) :

  function generate_advanced_css() {

    $generate_settings = wp_parse_args( 
      get_option( 'generate_settings', array() ), 
      generate_get_color_defaults() 
    );

    $visual_css = array (
      
      // Form button-outline
      '.button-outline,
      .button-outline:visited' => array(
        'border-color' => $generate_settings['form_button_background_color'],
        'color' => $generate_settings['form_button_text_color']
      ),
      
      // Form button-outline hover
      '.button-outline:hover,
      .button-outline:focus' => array(
        'border-color' => $generate_settings['form_button_background_color_hover'],
        'color' => $generate_settings['form_button_text_color_hover']
      )

    );

    $output = '';
    foreach ($visual_css as $k => $properties) {
      if(!count($properties))
        continue;
      $temporary_output = $k . ' {';
      $elements_added = 0;
      foreach($properties as $p => $v) {
        if(empty($v))
          continue;
        $elements_added++;
        $temporary_output .= $p . ': ' . $v . '; ';
      }
      $temporary_output .= "}";
      if($elements_added > 0)
        $output .= $temporary_output;
    }
    
    $output = str_replace(array("\r", "\n", "\t"), '', $output);
    return $output;

  }

  /**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_color_scripts', 50 );
	function generate_color_scripts() {
		wp_add_inline_style( 'generate-style', generate_advanced_css() );
	}

endif;