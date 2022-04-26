<?php
/**
 * Plugin Name: HT Slider For Elementor
 * Description: The Slider is a elementor addons for WordPress.
 * Plugin URI:  https://htplugins.com/
 * Author:      HT Plugins
 * Author URI:  https://profiles.wordpress.org/htplugins/
 * Version:     1.0.2
 * License:     GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ht-slider
 * Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly

define( 'HTSLIDER_VERSION', '1.0.2' );
define( 'HTSLIDER_PL_URL', plugins_url( '/', __FILE__ ) );
define( 'HTSLIDER_PL_PATH', plugin_dir_path( __FILE__ ) );

// Required File
require_once HTSLIDER_PL_PATH.'include/custom-post-type.php';
require_once HTSLIDER_PL_PATH.'include/helpers_function.php';

//Enqueue style
function htslider_assests_enqueue() {

    wp_enqueue_style('animate-min', HTSLIDER_PL_URL . 'assests/css/animate.min.css', '', HTSLIDER_VERSION );
    wp_enqueue_style('htslider-widgets', HTSLIDER_PL_URL . 'assests/css/ht-slider-widgets.css', '', HTSLIDER_VERSION );

    // Register Style
    wp_register_style( 'slick', HTSLIDER_PL_URL . 'assests/css/slick.min.css', array(), HTSLIDER_VERSION );

    // Script register
    wp_register_script( 'slick', HTSLIDER_PL_URL . 'assests/js/slick.min.js', array(), HTSLIDER_VERSION, TRUE );
    wp_register_script( 'htslider-active', HTSLIDER_PL_URL . 'assests/js/active.js', array('slick'), HTSLIDER_VERSION, TRUE );
}
add_action( 'wp_enqueue_scripts', 'htslider_assests_enqueue' );

// Elementor Widgets File Call
function htslider_elementor_widgets(){
    include( HTSLIDER_PL_PATH.'include/elementor_widgets.php' );
}
add_action('elementor/widgets/widgets_registered','htslider_elementor_widgets');

// Check Plugins is Installed or not
if( !function_exists( 'htslider_is_plugins_active' ) ){
    function htslider_is_plugins_active( $pl_file_path = NULL ){
        $installed_plugins_list = get_plugins();
        return isset( $installed_plugins_list[$pl_file_path] );
    }
}

// Load Plugins
function htslider_load_plugin() {
    load_plugin_textdomain( 'ht-slider' );
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'htslider_check_elementor_status' );
        return;
    }
}
add_action( 'plugins_loaded', 'htslider_load_plugin' );

// Check Elementor install or not.
function htslider_check_elementor_status(){
    $elementor = 'elementor/elementor.php';
    if( htslider_is_plugins_active( $elementor ) ) {
        if( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $elementor . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $elementor );

        $message = '<p>' . __( 'HT Slider Addons not working because you need to activate the Elementor plugin.', 'ht-slider' ) . '</p>';
        $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'ht-slider' ) ) . '</p>';
    } else {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return;
        }
        $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = '<p>' . __( 'HT Slider Addons not working because you need to install the Elementor plugin', 'ht-slider' ) . '</p>';
        $message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'ht-slider' ) ) . '</p>';
    }
    echo '<div class="error"><p>' . $message . '</p></div>';
}


//Slider Post template
function htslider_canvas_template( $single_template ) {
    global $post;
    if ( 'htslider_slider' == $post->post_type ) {
        $elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
        if ( file_exists( $elementor_2_0_canvas ) ) {
            return $elementor_2_0_canvas;
        } else {
            return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
        }
    }
    return $single_template;
}
add_filter( 'single_template', 'htslider_canvas_template' );


?>