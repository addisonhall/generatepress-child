<?php
/**
 * Helper functions for whatever is helpful ;-)
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

/**
 * Class to check for theme stuff
 */
class Utils_Themes {

    /**
     * Check if specified theme is currently active
     * 
     * @param string $theme_name Theme name as specified in theme style.css
     * @return bool True if theme is currently active, false otherwise.
     */
    public static function is_active( $theme_name ) {
        $current_theme = wp_get_theme();
        $is_theme_active = false;
        if ( $current_theme === $theme_name ) {
            $is_theme_active = true;
        }
        return $is_theme_active;
    }

    /**
     * Check if specified theme is currently active parent theme
     * 
     * @param string $theme_name Theme name as specified in theme style.css
     * @return bool True if theme is currently active parent theme, false otherwise.
     */
    public static function is_parent( $theme_name ) {
        $current_theme = wp_get_theme();
        $is_theme_active = false;
        if ( $current_theme->parent()->get( 'Name' ) === $theme_name ) {
            $is_theme_active = true;
        }
        return $is_theme_active;
    }

    /**
     * Check if specified theme is currently active or parent theme
     * 
     * @param string $theme_name Theme name as specified in theme style.css
     * @return bool True if theme is currently active or parent, false otherwise.
     */
    public static function is_active_or_parent( $theme_name ) {
        $current_theme = wp_get_theme();
        $is_theme_active = false;
        if ( $current_theme === $theme_name || $current_theme->parent()->get( 'Name' ) === $theme_name ) {
            $is_theme_active = true;
        }
        return $is_theme_active;
    }
}

/**
 * Class to check if plugin is active
 * 
 * @link https://github.com/mymizan/wp-check-if-plugin-active
*/
class Utils_Plugins {

	/**
	 * Check if a plugin is active
	 *
	 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php
	 * @return bool True if plugin is active, false otherwise.
	 */
	public static function is_active( $plugin_main_file ) {
		// get the list of plugins.
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

		// escape characters that have special meaning in regex.
		$plugin_main_file    = preg_quote( $plugin_main_file, '/' );
		$is_plugin_installed = false;

		// Loop through the active plugins.
		foreach ( $active_plugins as $plugin ) {
			if ( preg_match( '/.+\/' . $plugin_main_file . '/', $plugin ) ) {
				$is_plugin_installed = true;
				break;
			}
		}

		return $is_plugin_installed;
	}

	/**
	 * Check if a plugin is network active
	 *
	 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php
	 * @return bool True if plugin is active, false otherwise.
	 */
	public static function is_network_active( $plugin_main_file ) {

		// if not a multisite, don't check.
		if ( ! is_multisite() ) {
			return false;
		}

		// get the list of plugins.
		$active_plugins = get_site_option( 'active_sitewide_plugins' );

		// escape characters that have special meaning in regex.
		$plugin_main_file = preg_quote( $plugin_main_file, '/' );
		$is_plugin_active = false;

		// Loop through the active plugins.
		foreach ( $active_plugins as $plugin_name => $plugin_activation ) {
			if ( preg_match( '/.+\/' . $plugin_main_file . '/', $plugin_name ) ) {
				$is_plugin_active = true;
				break;
			}
		}

		return $is_plugin_active;
	}

	/**
	 * Check if a must use (mu) plugin exists.
	 *
	 * mu plugins are always active. So there's no need to check if they are
	 * active or not. We just need to check that they are in the list.
	 *
	 * @param string $plugin_main_file main file of the plugin, eg. woocommerce.php
	 * @return bool True if plugin matches, false otherwise.
	 */
	public static function is_mu_active( $plugin_main_file ) {
		$_mu_plugins = get_mu_plugins();

		if ( isset( $_mu_plugins[ $plugin_main_file ] ) ) {
			return true;
		}

		return false;
	}

}

/**
 * Return animation delay times.
 * 
 * @param int $pos Integer to select array position.
 * @return string Returns delay time to work with CSS animations.
 */
add_filter( 'gpc_anim_delay_times', 'func_gpc_anim_delay_times' );
function func_gpc_anim_delay_times( $pos = 0 ) {
    $delay_times = array(
        '',
        '250',
        '500',
        '750',
        '1000',
        '1250',
        '1500',
        '1750',
        '2000'
    );
    return $delay_times[$pos];
}