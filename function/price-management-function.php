<?php
add_action( 'wp_ajax_price_management', 'price_management');
add_action( 'wp_ajax_nopriv_price_management','price_management');
function price_management(){


     if ( !wp_verify_nonce($_POST['nonce'], 'example_ajax_nonce') ){ 
        die('Permission Denied.'); 
    }

    $user_role       = !empty($_POST['user_role'])?$_POST['user_role']:'';
    $management_save = get_option( 'management_save' );
    echo !empty($management_save[$user_role])?$management_save[$user_role]:'';
    wp_die();
    exit;
}

add_action( 'wp_ajax_price_management_save', 'price_management_save');
add_action( 'wp_ajax_nopriv_price_management_save','price_management_save');
function price_management_save(){


    if ( !wp_verify_nonce($_POST['nonce'], 'example_ajax_nonce') ){ 
        die('Permission Denied.'); 
    }

    $user_role  = !empty($_POST['user_role'])?$_POST['user_role']:'';
    $price      = !empty($_POST['price'])?$_POST['price']:'';


    $management_save = get_option( 'management_save' );

    if( empty( $management_save ) ){

        $management_save = array( 
                                    'administrator' => '',
                                    'editor'        => '',
                                    'author'        => '',
                                    'contributor'   => '',
                                    'subscriber'    => '',
                               );

        $management_save[$user_role] = $price;


    } else {

        $management_save[$user_role] = $price;

    }

    

    update_option( 'management_save', $management_save );
    
    exit;
}