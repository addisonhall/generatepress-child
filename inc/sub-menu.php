<?php
/**
 * Contextual sub menu that filters from primary menu.
 *
 * Must be included in functions.php to use.
 * Also used by sub-menu-widget.php.
 *
 * TODO: Convert this to a plugin!
 *
 * Example usage:
 *
 * // Simple
 * wp_nav_menu( array(
 *   'theme_location' => 'primary',
 *   'sub_menu'       => true
 * ) );
 * 
 * // Direct parent
 * wp_nav_menu( array(
 *   'theme_location' => 'primary',
 *   'sub_menu'       => true,
 *   'direct_parent'  => true
 * ) );
 * 
 * // Show parent
 * wp_nav_menu( array(
 *   'theme_location' => 'primary',
 *   'sub_menu'       => true,
 *   'show_parent'    => true
 * ) );
 * 
 * // Specify parent id to show specific sub-menu
 * wp_nav_menu( array(
 *   'theme_location' => 'primary',
 *   'sub_menu'       => true,
 *   'parent_id'      => 12 // id of parent menu item
 * ) );
 *
 * @package GenerateChild
 * @link https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// add hook
add_filter( 'wp_nav_menu_objects', 'gpc_wp_nav_menu_objects_sub_menu', 10, 2 );
// filter_hook function to react on sub_menu flag
function gpc_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {
    if ( isset( $args->sub_menu ) ) {

        // see if a parent id was provided
        if ( $args->parent_id ) {
            $root_id = (int)$args->parent_id;
        } else {
            $root_id = 0;
            // find the current menu item
            foreach ( $sorted_menu_items as $menu_item ) {
                if ( $menu_item->current ) {
                    // set the root id based on whether the current menu item has a parent or not
                    $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
                    break;
                }
            }
        }
    
        // find the top level parent
        if ( ! isset( $args->direct_parent ) ) {
            $prev_root_id = $root_id;
            while ( $prev_root_id != 0 ) {
                foreach ( $sorted_menu_items as $menu_item ) {
                    if ( $menu_item->ID == $prev_root_id ) {
                        $prev_root_id = $menu_item->menu_item_parent;
                        // don't set the root_id to 0 if we've reached the top of the menu
                        if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
                        break;
                    } 
                }
            }
        }
        $menu_item_parents = array();
        foreach ( $sorted_menu_items as $key => $item ) {
            // init menu_item_parents
            if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
            if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
                // part of sub-tree: keep!
                $menu_item_parents[] = $item->ID;
            } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
                // not part of sub-tree: away with it!
                unset( $sorted_menu_items[$key] );
            }
        }

        // Remove the GP search icon from our sub menu
        if ( function_exists( 'generate_menu_search_icon' ) ) {
            remove_filter( 'wp_nav_menu_items', 'generate_menu_search_icon', 10, 2 );
        }
    
        // Remove the WooCommerce cart from our sub menu
        if ( ! has_filter( 'generate_woocommerce_menu_item_location', 'gpc_move_menu_cart_item' ) ) {
            add_filter( 'generate_woocommerce_menu_item_location', 'gpc_move_menu_cart_item' );
            function gpc_move_menu_cart_item() {
                return false;
            }
        }
        
        return $sorted_menu_items;
    } else {
        return $sorted_menu_items;
    }
}