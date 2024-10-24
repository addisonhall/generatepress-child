<?php
/**
 * Content security policy with nonces. Doesn't work great with caching.
 *
 * Do some security stuff to harden WordPress.
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set empty nonce variable
 */
$csp_nonce = '';

/**
 * Generate nonce for Content Security Policy
 */
if ( ! is_admin() ) {
    $csp_nonce = bin2hex(openssl_random_pseudo_bytes(32));
}

/**
 * Content Security Policy settings.
 */
$csp_settings_arr = array(
    "base-uri" => array(
        "'self'"
    ),
    'default-src' => array(
        "'self'"
    ),
    'object-src' => array(
        "'none'"
    ),
    'style-src' => array(
        "'self'",
        "'unsafe-inline'"
    ),
    'connect-src' => array(
        "'self'",
        "https://www.google-analytics.com",
        "https://www.analytics.google.com",
        "https://www.googletagmanager.com",
        "https://l.clarity.ms",
        "https://www.cloudways.com"
    ),
    'script-src' => array(
        "'nonce-$csp_nonce'",
        "'strict-dynamic'",
        "'unsafe-inline'",
        "http:",
        "https:",
    ),
    'img-src' => array(
        "'self'",
        "https://www.google-analytics.com",
        "https://www.googletagmanager.com",
        "https://www.clarity.ms",
        "https://c.clarity.ms",
        "https://c.bing.com",
        "https://www.cloudways.com"
    ),
    'form-action' => array(
        "'self'",
        "https://www.cloudways.com"
    )
);

/**
 * Generate header with Content Security Policy
 */
add_action( 'send_headers', 'gpc_add_content_security_header' );
function gpc_add_content_security_header() {
    if ( is_admin() ) return;
    global $csp_settings_arr;
    $csp_settings_str = '';
    foreach( $csp_settings_arr as $setting => $values ) {
        $csp_settings_str .= $setting . ' ';
        foreach( $values as $value ) {
            $csp_settings_str .= $value . ' ';
        }
        $csp_settings_str .= '; ';
    }
    header( "Content-Security-Policy: $csp_settings_str" );
}

/**
 * Add nonce to all inline scripts for CSP.
 */
add_filter( 'wp_inline_script_attributes', 'gpc_add_nonce_to_inline_scripts' );
function gpc_add_nonce_to_inline_scripts( $attr ) {
    if ( is_admin() ) return $attr;
    $attr = array();
    global $csp_nonce;
    $attr = array(
        'type' => 'text/javascript',
        'nonce' => $csp_nonce,
    );
    return $attr;
}

/**
 * Add nonce to all scripts for CSP.
 */
add_filter( 'script_loader_tag', 'gpc_add_nonce_to_scripts' );
function gpc_add_nonce_to_scripts( $html ) {
    if ( is_admin() || ( strpos( $html, 'nonce=') ) ) return $html;
    global $csp_nonce;
    $html = str_replace( '<script', '<script nonce="' . $csp_nonce . '"', $html );
    return $html;
}

/**
 * Add nonce to GeneratePress A11y script.
 */
add_filter( 'generate_print_a11y_script', 'gpc_add_nonce_to_a11y_script', 99 );
function gpc_add_nonce_to_a11y_script( $print ) {
    if ( ! is_admin() ) {
        global $csp_nonce;
        // Add GP's small a11y script inline, but with nonce.
        printf(
            '<script nonce="' . $csp_nonce . '" id="generate-a11y">%s</script>',
            '!function(){"use strict";if("querySelector"in document&&"addEventListener"in window){var e=document.body;e.addEventListener("mousedown",function(){e.classList.add("using-mouse")}),e.addEventListener("keydown",function(){e.classList.remove("using-mouse")})}}();'
        );
    }
}