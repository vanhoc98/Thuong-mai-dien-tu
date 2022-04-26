<?php 
function filter_plugin_updates( $value ) {
     unset( $value->response['siteorigin-panels/siteorigin-panels.php'] );
     unset( $value->response['black-studio-tinymce-widget/black-studio-tinymce-widget.php'] );
    // unset( $value->response['regenerate-thumbnails/regenerate-thumbnails.php'] );
    // unset( $value->response['sassy-social-share/sassy-social-share.php'] );
    unset( $value->response['woocommerce/woocommerce.php'] );
    // unset( $value->response['woocommerce-checkout-manager/woocommerce-checkout-manager.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' ); 

//  REMOVE ALL NOTIFICATION UPDATE PLUGIN
 remove_action('load-update-core.php','wp_update_plugins');
  //add_filter('pre_site_transient_update_plugins','__return_null');

// REMOVE NOTIFICATION UPDATE CORE 
//add_action('after_setup_theme','remove_core_updates');
function remove_core_updates()
{
 if(! current_user_can('update_core')){return;}
 add_action('init', create_function('$a',"remove_action( 'init', 'wp_version_check' );"),2);
 add_filter('pre_option_update_core','__return_null');
 add_filter('pre_site_transient_update_core','__return_null');
}