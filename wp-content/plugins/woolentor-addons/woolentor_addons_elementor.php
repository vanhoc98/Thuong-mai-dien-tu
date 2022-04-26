<?php
/**
 * Plugin Name: WooLentor - WooCommerce Elementor Addons + Builder
 * Description: The WooCommerce elements library for Elementor page builder plugin for WordPress.
 * Plugin URI: 	https://woolentor.com/
 * Version: 	1.4.6
 * Author: 		HasThemes
 * Author URI: 	https://hasthemes.com/plugins/woolentor-pro/
 * License:  	GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: woolentor
 * Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WOOLENTOR_VERSION', '1.4.6' );
define( 'WOOLENTOR_ADDONS_PL_ROOT', __FILE__ );
define( 'WOOLENTOR_ADDONS_PL_URL', plugins_url( '/', WOOLENTOR_ADDONS_PL_ROOT ) );
define( 'WOOLENTOR_ADDONS_PL_PATH', plugin_dir_path( WOOLENTOR_ADDONS_PL_ROOT ) );

// Plugins Name
define( 'WOOLENTOR_ITEM_NAME', 'WooLentor - WooCommerce Elementor Addons + Builder' );

// Required File
require_once WOOLENTOR_ADDONS_PL_PATH.'includes/helper-function.php';
require_once WOOLENTOR_ADDONS_PL_PATH.'init.php';

// Include file
include_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/custom-metabox.php' );
include_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/admin/admin-init.php' );

// Check Plugins is Installed or not
function woolentor_is_plugins_active( $pl_file_path = NULL ){
    $installed_plugins_list = get_plugins();
    return isset( $installed_plugins_list[$pl_file_path] );
}

// This notice for Elementor is not installed or activated or both.
function woolentor_check_elementor_status(){
    $elementor = 'elementor/elementor.php';
    if( woolentor_is_plugins_active($elementor) ) {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );
        $message = __( '<strong>Woolentor Addons for Elementor</strong> requires Elementor plugin to be active. Please activate Elementor to continue.', 'woolentor' );
        $button_text = esc_html__( 'Activate Elementor', 'woolentor' );
    } else {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = sprintf( __( '<strong>Woolentor Addons for Elementor</strong> requires %1$s"Elementor"%2$s plugin to be installed and activated. Please install Elementor to continue.', 'woolentor' ), '<strong>', '</strong>' );
        $button_text = esc_html__( 'Install Elementor', 'woolentor' );
    }
    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', $message, $button );
}

// This notice for WooCommerce is not installed or activated or both.
function woolentor_check_woocommerce_status(){
    $woocommerce = 'woocommerce/woocommerce.php';
    if( woolentor_is_plugins_active($woocommerce) ) {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $woocommerce . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $woocommerce );
        $message = __( '<strong>Woolentor Addons for Elementor</strong> requires WooCommerce plugin to be active. Please activate WooCommerce to continue.', 'woolentor' );
        $button_text = __( 'Activate WooCommerce', 'woolentor' );
    } else {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
        $message = sprintf( __( '<strong>Woolentor Addons for Elementor</strong> requires %1$s"WooCommerce"%2$s plugin to be installed and activated. Please install WooCommerce to continue.', 'woolentor' ), '<strong>', '</strong>' );
        $button_text = __( 'Install WooCommerce', 'woolentor' );
    }
    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', __( $message ), $button );
}

// Load Plugins
function woolentor_load_plugin() {
    load_plugin_textdomain( 'woolentor' );

    if ( ! is_plugin_active( 'woocommerce/woocommerce.php' )) {
        add_action('admin_notices', 'woolentor_check_woocommerce_status' );
        return ;
    }

    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'woolentor_check_elementor_status' );
        return;
    }
}
add_action( 'plugins_loaded', 'woolentor_load_plugin' );

// Add settings link on plugin page.
function woolentor_pl_setting_links( $links ) {
    $woolentor_settings_link = '<a href="admin.php?page=woolentor">'.esc_html__( 'Settings', 'woolentor' ).'</a>'; 
    array_unshift( $links, $woolentor_settings_link );
    if( !is_plugin_active('woolentor-addons-pro/woolentor_addons_pro.php') ){
        $links['woolentorgo_pro'] = sprintf('<a href="https://hasthemes.com/plugins/woolentor-pro/" target="_blank" style="color: #39b54a; font-weight: bold;">' . esc_html__('Go Pro','woolentor') . '</a>');

    }
    return $links; 
} 
$woolentor_plugin_name = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$woolentor_plugin_name", 'woolentor_pl_setting_links' );

// Plugins After Install
register_activation_hook(__FILE__, 'woolentor_plugin_activate');
add_action('admin_init', 'woolentor_plugin_redirect_option_page');
function woolentor_plugin_activate() {
    add_option('woolentor_do_activation_redirect', true);
}
function woolentor_plugin_redirect_option_page() {
    if ( get_option('woolentor_do_activation_redirect', false) ) {
        delete_option('woolentor_do_activation_redirect');
        if( !isset( $_GET['activate-multi'] ) ){
            wp_redirect( admin_url("admin.php?page=woolentor") );
        }
    }
}

// Customize rating html
if( !function_exists('woolentor_wc_get_rating_html') ){
    function woolentor_wc_get_rating_html(){
        if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) { return; }
        global $product;
        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();
        if ( $rating_count > 0 ) {
            $rating_whole = $average / 5*100;
            $wrapper_class = is_single() ? 'rating-number' : 'top-rated-rating';
            ob_start();
        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">
            <span class="ht-product-ratting">
                <span class="ht-product-user-ratting" style="width: <?php echo esc_attr( $rating_whole );?>%;">
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                    <i class="sli sli-star"></i>
                </span>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
                <i class="sli sli-star"></i>
            </span>
        </div>
        <?php
            $html = ob_get_clean();
        } else { $html  = ''; }
        return $html;
    }
}

/**
* Usages: Compare button shortcode [yith_compare_button] From "YITH WooCommerce Compare" plugins.
* Plugins URL: https://wordpress.org/plugins/yith-woocommerce-compare/
* File Path: yith-woocommerce-compare/includes/class.yith-woocompare-frontend.php
* The Function "woolentor_compare_button" Depends on YITH WooCommerce Compare plugins. If YITH WooCommerce Compare is installed and actived, then it will work.
*/
function woolentor_compare_button( $buttonstyle = 1 ){
    if( !class_exists('YITH_Woocompare') ) return;
    global $product;
    $product_id = $product->get_id();
    $comp_link = home_url() . '?action=yith-woocompare-add-product';
    $comp_link = add_query_arg('id', $product_id, $comp_link);

    if( $buttonstyle == 1 ){
        echo do_shortcode('[yith_compare_button]');
    }else{
        echo '<a title="'. esc_attr__('Add to Compare', 'woolentor') .'" href="'. esc_url( $comp_link ) .'" class="woolentor-compare compare" data-product_id="'. esc_attr( $product_id ) .'" rel="nofollow">'.esc_html__( 'Compare', 'woolentor' ).'</a>';
    }

}

/**
* Usages: "woolentor_add_to_wishlist_button()" function is used  to modify the wishlist button from "YITH WooCommerce Wishlist" plugins.
* Plugins URL: https://wordpress.org/plugins/yith-woocommerce-wishlist/
* File Path: yith-woocommerce-wishlist/templates/add-to-wishlist.php
* The below Function depends on YITH WooCommerce Wishlist plugins. If YITH WooCommerce Wishlist is installed and actived, then it will work.
*/

function woolentor_add_to_wishlist_button( $normalicon = '<i class="fa fa-heart-o"></i>', $addedicon = '<i class="fa fa-heart"></i>', $tooltip = 'no' ) {
    global $product, $yith_wcwl;

    if ( ! class_exists( 'YITH_WCWL' ) || empty(get_option( 'yith_wcwl_wishlist_page_id' ))) return;

    $url          = YITH_WCWL()->get_wishlist_url();
    $product_type = $product->get_type();
    $exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
    $classes      = 'class="add_to_wishlist"';
    $add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
    $browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
    $added        = get_option( 'yith_wcwl_product_added_text' );

    $output = '';

    $output  .= '<div class="'.( $tooltip == 'yes' ? '' : 'tooltip_no' ).' wishlist button-default yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
        $output .= '<div class="yith-wcwl-add-button';
            $output .= $exists ? ' hide" style="display:none;"' : ' show"';
            $output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' >'.$normalicon.'<span class="ht-product-action-tooltip">'.esc_html( $add ).'</span></a>';
            $output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
        $output .= '</div>';

        $output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="" href="' . esc_url( $url ) . '">'.$addedicon.'<span class="ht-product-action-tooltip">'.esc_html( $browse ).'</span></a></div>';
        $output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="">'.$addedicon.'<span class="ht-product-action-tooltip">'.esc_html( $added ).'</span></a></div>';
    $output .= '</div>';
    return $output;
}

/*
* Quickview
*/
function woolentor_wc_quickview() {
    // Get product from request.
    if ( isset( $_POST['data'] ) && (int) $_POST['data'] ) {
        global $post, $product, $woocommerce;
        $id      = ( int ) $_POST['data'];
        $post    = get_post( $id );
        $product = get_product( $id );
        if ( $product ) {
            include WOOLENTOR_ADDONS_PL_PATH.'includes/quickview-content.php';
        }
    }
    exit;
}
add_action( 'wp_ajax_woolentor_product_quickview', 'woolentor_wc_quickview' );
add_action( 'wp_ajax_nopriv_woolentor_product_quickview', 'woolentor_wc_quickview' );