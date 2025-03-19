<?php
/**
 * Customize Wordpress login.
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Use the site logo for the Wordpress login screen.
 */
add_action( 'login_head', 'gpc_custom_login_logo' );
function gpc_custom_login_logo() {
    if ( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        $logo_url = $image[0];
        echo '<style type="text/css">
        h1 a { background-image:url(' . $logo_url . ') !important; background-size:auto !important; background-size:contain !important; width:310px !important; height:100px !important; }
        </style>';
    }
}

/**
 * Custom login URL.
 *
 * @since 2.8.0
 * @since 4.2.0 The `$force_reauth` parameter was added.
 * @see https://developer.wordpress.org/reference/hooks/login_url/#user-contributed-notes
 *
 * @param string $login_url    The login URL. Not HTML-encoded.
 * @param string $redirect     The path to redirect to on login, if supplied.
 * @param bool   $force_reauth Whether to force reauthorization, even if a cookie is present.
 *
 * @return string
 */
// add_filter( 'login_url', 'gpc_custom_login_url', 10, 3 );
function gpc_custom_login_url( $login_url, $redirect, $force_reauth ){
    // This will append /custom-login/ to you main site URL as configured in general settings (ie https://domain.com/custom-login/)
    $login_url = site_url( '/sign-in/', 'login' );
    if ( ! empty( $redirect ) ) {
        $login_url = add_query_arg( 'redirect_to', urlencode( $redirect ), $login_url );
    }
    if ( $force_reauth ) {
        $login_url = add_query_arg( 'reauth', '1', $login_url );
    }
    return $login_url;
}

/**
 * Custom registration URL.
 * 
 * Enable ONLY if you need a custom user registration page.
 * 
 * @see https://developer.wordpress.org/reference/hooks/register_url/#user-contributed-notes
 */
// add_filter( 'register_url', 'gpc_custom_registration_url' );
function gpc_custom_registration_url( $url ) {
    if ( is_admin() ) {
        return $url;
    }
    return '/register/';
}