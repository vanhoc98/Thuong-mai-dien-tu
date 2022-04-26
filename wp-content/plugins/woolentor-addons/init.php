<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

if ( ! function_exists('is_plugin_active')) { include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }

if ( !class_exists( 'Woolentor_Elementor_Addons_Init' ) ) {

    class Woolentor_Elementor_Addons_Init{

        private static $_instance = null;
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct(){
            if ( class_exists( 'WooCommerce' ) ) {
                add_action( 'after_setup_theme', array( $this, 'woolentor_woocommerce_setup' ) );
                add_action( 'elementor/widgets/widgets_registered', array( $this, 'woolentor_includes_widgets' ) );
                
                add_action( 'init', array( $this, 'woolentor_register_scripts' ) );
                add_action( 'wp_enqueue_scripts', array( $this,'woolentor_enqueue_frontend_scripts' ) );
                add_action( 'init', array( $this, 'woolentor_file_includes_hooks' ) );
                $this->woolentor_file_includes();
            }
        }

        // Support WooCommerce
        public function woolentor_woocommerce_setup() {
            if( woolentor_get_option( 'enablecustomlayout', 'woolentor_woo_template_tabs', 'on' ) == 'on' ){
                add_theme_support( 'woocommerce' );
                add_theme_support( 'wc-product-gallery-zoom' );
                add_theme_support( 'wc-product-gallery-lightbox' );
                add_theme_support( 'wc-product-gallery-slider' );
            }
        }

        // Include Widgets File
        public function woolentor_includes_widgets(){

            $wl_element_manager = array(
                'product_tabs',
                'add_banner',
                'special_day_offer'
            );
            if( !is_plugin_active('woolentor-addons-pro/woolentor_addons_pro.php') ){
                $wl_element_manager[] = 'universal_product';
            }

            // WooCommerce Builder
            if( woolentor_get_option( 'enablecustomlayout', 'woolentor_woo_template_tabs', 'on' ) == 'on' ){
                $wlb_element  = array(
                    'wb_archive_product',
                    'wb_product_title',
                    'wb_product_related',
                    'wb_product_add_to_cart',
                    'wb_product_additional_information',
                    'wb_product_data_tab',
                    'wb_product_description',
                    'wb_product_short_description',
                    'wb_product_price',
                    'wb_product_rating',
                    'wb_product_reviews',
                    'wb_product_image',
                    'wl_product_video_gallery',
                    'wb_product_upsell',
                    'wb_product_stock',
                    'wb_product_meta',
                    'wb_product_call_for_price',
                    'wb_product_suggest_price',
                );
            }else{ $wlb_element  = array(); }
            $wl_element_manager = array_merge( $wl_element_manager, $wlb_element );

            foreach ( $wl_element_manager as $element ){
                if (  ( woolentor_get_option( $element, 'woolentor_elements_tabs', 'on' ) === 'on' ) && file_exists( WOOLENTOR_ADDONS_PL_PATH.'includes/widgets/'.$element.'.php' ) ){
                    require_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/widgets/'.$element.'.php' );
                }
            }

        }

        // Include File
        Public function woolentor_file_includes(){
            if( woolentor_get_option( 'enablecustomlayout', 'woolentor_woo_template_tabs', 'on' ) == 'on' ){
                include_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/wl_woo_shop.php' );
                include_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/archive_product_render.php' );
                include_once ( WOOLENTOR_ADDONS_PL_PATH.'includes/class.product_video_gallery.php' );
                if( !is_admin() && !is_plugin_active('woolentor-addons-pro/woolentor_addons_pro.php') && woolentor_get_option( 'enablerenamelabel', 'woolentor_rename_label_tabs', 'off' ) == 'on' ){
                    include( WOOLENTOR_ADDONS_PL_PATH.'includes/rename_label.php' );
                }
            }
        }

        // Include File Under Init Hook.
        public function woolentor_file_includes_hooks(){
            if( !is_plugin_active('woolentor-addons-pro/woolentor_addons_pro.php') && woolentor_get_option( 'enableresalenotification', 'woolentor_sales_notification_tabs', 'off' ) == 'on' ){
                include( WOOLENTOR_ADDONS_PL_PATH. 'includes/class.sale_notification.php' );
            }
        }

        // Register frontend scripts
        public function woolentor_register_scripts(){
            
            // Register Css file
            wp_register_style(
                'htflexboxgrid',
                WOOLENTOR_ADDONS_PL_URL . 'assets/css/htflexboxgrid.css',
                array(),
                WOOLENTOR_VERSION
            );
            
            wp_register_style(
                'simple-line-icons',
                WOOLENTOR_ADDONS_PL_URL . 'assets/css/simple-line-icons.css',
                array(),
                WOOLENTOR_VERSION
            );

            wp_register_style(
                'woolentor-widgets',
                WOOLENTOR_ADDONS_PL_URL . 'assets/css/woolentor-widgets.css',
                array(),
                WOOLENTOR_VERSION
            );

            wp_register_style(
                'slick',
                WOOLENTOR_ADDONS_PL_URL . 'assets/css/slick.css',
                array(),
                WOOLENTOR_VERSION
            );

            // Register JS file
            wp_register_script(
                'slick',
                WOOLENTOR_ADDONS_PL_URL . 'assets/js/slick.min.js',
                array('jquery'),
                WOOLENTOR_VERSION,
                TRUE
            );

            wp_register_script(
                'countdown-min',
                WOOLENTOR_ADDONS_PL_URL . 'assets/js/jquery.countdown.min.js',
                array('jquery'),
                WOOLENTOR_VERSION,
                TRUE
            );

            wp_register_script(
                'woolentor-widgets-scripts',
                WOOLENTOR_ADDONS_PL_URL . 'assets/js/woolentor-widgets-active.js',
                array('jquery'),
                WOOLENTOR_VERSION,
                TRUE
            );

            $localizeargs = array(
                'woolentorajaxurl' => admin_url( 'admin-ajax.php' ),
            );
            wp_localize_script( 'woolentor-widgets-scripts', 'woolentor_addons', $localizeargs );

        }

        // enqueue frontend scripts
        public function woolentor_enqueue_frontend_scripts(){
            // CSS File
            wp_enqueue_style( 'htflexboxgrid' );
            wp_enqueue_style( 'font-awesome' );
            wp_enqueue_style( 'simple-line-icons' );
            wp_enqueue_style( 'slick' );
            wp_enqueue_style( 'woolentor-widgets' );
            if ( is_rtl() ) {
              wp_enqueue_style(  'woolentor-widgets-rtl',  WOOLENTOR_ADDONS_PL_URL . 'assets/css/woolentor-widgets-rtl.css', array(), WOOLENTOR_VERSION );
            }
        }
    }
    
    Woolentor_Elementor_Addons_Init::instance();

}