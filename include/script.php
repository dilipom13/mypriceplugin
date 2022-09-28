<?php
add_action("admin_enqueue_scripts", "my_admin_scripts");
function my_admin_scripts() { 

    // custom script file
    wp_register_script('custom', 
                        plugin_dir_url( __DIR__ ) .'assets/js/custom.js',   //
                        array (),
                        false, false
                     );
     wp_localize_script('custom', 'ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('example_ajax_nonce'),
    ));

    wp_enqueue_script('custom');

    // validation script file
    wp_register_script('validatecustom', 
                        plugin_dir_url( __DIR__ ) .'assets/js/jquery.validate.min.js',   //
                        array (),
                        false, false);
    wp_enqueue_script('validatecustom');

// validation css file
wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __DIR__ ) . 'assets/css/custom.css', false, '1.0.0' );
wp_enqueue_style( 'custom_wp_admin_css' );
}