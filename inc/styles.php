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

if ( !function_exists( 'gpc_base_inline_css' ) ) :

  function gpc_base_inline_css() {

    $gpc_settings = wp_parse_args( 
      get_option( 'generate_settings', array() ),
      generate_get_color_defaults()
    );

    $gpc_visual_css = array (
      
      // Form button-outline
      '.button.button-outline,
			.button.button-outline:visited' => array(
        'border-color' => $gpc_settings['form_button_background_color'],
        'color' => $gpc_settings['form_button_background_color']
      ),
      
      // Form button-outline hover
      '.button.button-outline:hover,
			.button.button-outline:focus' => array(
        'border-color' => $gpc_settings['form_button_background_color_hover'],
        'color' => $gpc_settings['form_button_background_color_hover']
      )

    );

    // Output the above CSS
		$output = '';
		foreach($gpc_visual_css as $k => $properties) {
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
	add_action( 'wp_enqueue_scripts', 'gpc_color_scripts' );
	function gpc_color_scripts() {
		wp_add_inline_style( 'gpc-base', gpc_base_inline_css() );
	}

endif;