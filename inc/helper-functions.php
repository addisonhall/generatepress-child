<?php
/**
 * Helper functions for whatever is helpful ;-)
 *
 * Must be included in functions.php
 *
 * @package GenerateChild
 */

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