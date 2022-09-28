<?php
/**
 * Plugin Name:       Price Management Plugin
 * Plugin URI:        https://pricemanagement.com/plugins/the-pricemanagement/
 * Description:       Handle the pricemanagement with this plugin.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Price Management Group
 * Author URI:        https://author.pricemanagement.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://pricemanagement.com/my-plugin/
 * Text Domain:       my-pricemanagement-plugin
 * Domain Path:       /languages
 */


if ( ! defined( 'WC_PM_FILE' ) ) {
    define( 'WC_PM_FILE', __FILE__ );
}

/**
 * Register a Price Management menu page.
 */
function wpdocs_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Price Management', 'my-pricemanagement-plugin' ),
        'Price Management',
        'manage_options',
        'pricemanagement',
        'my_custom_menu_page',
        'dashicons-welcome-widgets-menus',
        6
    );
    
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

// wp-admin pricemanagement fields
include_once dirname( WC_PM_FILE ) . '/include/price-management-fields.php';

// wp-admin enqueue script file
include_once dirname( WC_PM_FILE ) . '/include/script.php';

// wp-admin pricemanagement wp-ajax files
include_once dirname( WC_PM_FILE ) . '/function/price-management-function.php';


/*---- Woocommerce Front Side ----*/

function product_life_cycle_main_function($price, $product){

        
        return $price;
}
add_filter('woocommerce_product_get_price', 'product_life_cycle_custom_price', 99, 2);
add_filter('woocommerce_product_get_regular_price', 'product_life_cycle_custom_price', 99, 2);
add_filter('woocommerce_product_variation_get_regular_price', 'product_life_cycle_custom_price', 99, 2);
add_filter('woocommerce_product_variation_get_price', 'product_life_cycle_custom_price', 99, 2);


function product_life_cycle_custom_price($price, $product) {

        global $current_user;
        $user_role = get_option('user_role');
        $management_save = get_option( 'management_save' );
        $user_roles = $current_user->roles;
        $user_role = array_shift($user_roles);

        $administrator = $management_save['administrator'];
        $editor = $management_save['editor'];
        $author = $management_save['author'];
        $contributor = $management_save['contributor'];
        $subscriber = $management_save['subscriber'];
        
        if($user_role == 'administrator')
        {
            
            $price =((int)$price + $administrator);
            
        }

        if($user_role == 'editor')
        {
            
            $price =((int)$price + $editor);
        }

        if($user_role == 'author')
        {
            $price =((int)$price + $author);
        }

        if($user_role == 'contributor')
        {
            $price =((int)$price + $contributor);
        }

        if($user_role == 'subscriber')
        {
            $price =((int)$price + $subscriber);
        }
        
        return product_life_cycle_main_function($price, $product);
    }

add_filter('woocommerce_variation_prices_price', 'product_life_cycle_custom_variable_price', 99, 3);
add_filter('woocommerce_variation_prices_regular_price', 'product_life_cycle_custom_variable_price', 99, 3);
    function product_life_cycle_custom_variable_price($price, $variation, $product) {
        
        wc_delete_product_transients($variation->get_id());
        return product_life_cycle_main_function($price, $product);
    }

