<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();

/**
 * Elementor category
 */
function woolentor_elementor_init(){
    \Elementor\Plugin::instance()->elements_manager->add_category(
        'woolentor-addons',
        [
            'title'  => __( 'Woolentor Addons','woolentor'),
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','woolentor_elementor_init');

/**
* Elementor Version check
* Return boolval
*/
function woolentor_is_elementor_version( $operator = '<', $version = '2.6.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 * Render icon html.
 */
function woolentor_render_icon( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
    // Check if its already migrated
    $migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
    // Check if its a new widget without previously selected icon using the old Icon control
    $is_new = empty( $settings[ $old_icon_id ] );

    $attributes['aria-hidden'] = 'true';

    if ( woolentor_is_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
        \Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
    } else {
        if ( empty( $attributes['class'] ) ) {
            $attributes['class'] = $settings[ $old_icon_id ];
        } else {
            if ( is_array( $attributes['class'] ) ) {
                $attributes['class'][] = $settings[ $old_icon_id ];
            } else {
                $attributes['class'] .= ' ' . $settings[ $old_icon_id ];
            }
        }
        printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
    }
}

/**
 *  Taxonomy List
 * @return array
 */
function woolentor_taxonomy_list( $taxonomy = 'product_cat' ){
    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}


/**
 * Get Post List
 * return array
 */
function woolentor_post_name( $post_type = 'post' ){
    $options = array();
    $options['0'] = __('Select','woolentor');
    $all_post = array( 'posts_per_page' => -1, 'post_type'=> $post_type );
    $post_terms = get_posts( $all_post );
    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ){
        foreach ( $post_terms as $term ) {
            $options[ $term->ID ] = $term->post_title;
        }
        return $options;
    }
}

/*
 * Elementor Templates List
 * return array
 */
function woolentor_elementor_template() {
    $templates = '';
    if( class_exists('\Elementor\Plugin') ){
        $templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
    }
    $types = array();
    if ( empty( $templates ) ) {
        $template_lists = [ '0' => __( 'Do not Saved Templates.', 'woolentor' ) ];
    } else {
        $template_lists = [ '0' => __( 'Select Template', 'woolentor' ) ];
        foreach ( $templates as $template ) {
            $template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
        }
    }
    return $template_lists;
}

/*
 * Plugisn Options value
 * return on/off
 */
function woolentor_get_option( $option, $section, $default = '' ){
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

function woolentor_get_option_label_text( $option, $section, $default = '' ){
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        if( !empty($options[$option]) ){
            return $options[$option];
        }
        return $default;
    }
    return $default;
}

/*
 * HTML Tag list
 * return array
 */
function woolentor_html_tag_lists() {
    $html_tag_list = [
        'h1'   => __( 'H1', 'woolentor' ),
        'h2'   => __( 'H2', 'woolentor' ),
        'h3'   => __( 'H3', 'woolentor' ),
        'h4'   => __( 'H4', 'woolentor' ),
        'h5'   => __( 'H5', 'woolentor' ),
        'h6'   => __( 'H6', 'woolentor' ),
        'p'    => __( 'p', 'woolentor' ),
        'div'  => __( 'div', 'woolentor' ),
        'span' => __( 'span', 'woolentor' ),
    ];
    return $html_tag_list;
}

/* Category list */
function woolentor_get_product_category_list( $id = null, $taxonomy = 'product_cat', $limit = 1 ) { 
    $terms = get_the_terms( $id, $taxonomy );
    $i = 0;
    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    foreach ( $terms as $term ) {
        $i++;
        $link = get_term_link( $term, $taxonomy );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        echo '<a href="' . esc_url( $link ) . '">' . $term->name . '</a>';
        if( $i == $limit ){
            break;
        }else{ continue; }
    }
}

if( class_exists('WooCommerce') ){

    /* Custom product badge */
    function woolentor_custom_product_badge( $show = 'yes' ){
        global $product;
        $custom_saleflash_text = get_post_meta( get_the_ID(), '_saleflash_text', true );
        if( $show == 'yes' ){
            if( !empty( $custom_saleflash_text ) && $product->is_in_stock() ){
                if( $product->is_featured() ){
                    echo '<span class="ht-product-label ht-product-label-left hot">' . esc_html( $custom_saleflash_text ) . '</span>';
                }else{
                    echo '<span class="ht-product-label ht-product-label-left">' . esc_html( $custom_saleflash_text ) . '</span>';
                }
            }
        }
    }

    /* Sale flash*/
    function woolentor_sale_flash( $offertype = 'default' ){
        global $product;
        if( $product->is_on_sale() && $product->is_in_stock() ){
            if( $offertype !='default' && $product->get_regular_price() > 0 ){
                $_off_percent = (1 - round($product->get_price() / $product->get_regular_price(), 2))*100;
                $_off_price = round($product->get_regular_price() - $product->get_price(), 0);
                $_price_symbol = get_woocommerce_currency_symbol();
                $symbol_pos = get_option('woocommerce_currency_pos', 'left');
                $price_display = '';
                switch( $symbol_pos ){
                    case 'left':
                        $price_display = '-'.$_price_symbol.$_off_price;
                    break;
                    case 'right':
                        $price_display = '-'.$_off_price.$_price_symbol;
                    break;
                    case 'left_space':
                        $price_display = '-'.$_price_symbol.' '.$_off_price;
                    break;
                    default: /* right_space */
                        $price_display = '-'.$_off_price.' '.$_price_symbol;
                    break;
                }
                if( $offertype == 'number' ){
                    echo '<span class="ht-product-label ht-product-label-right">'.$price_display.'</span>';
                }elseif( $offertype == 'percent'){
                    echo '<span class="ht-product-label ht-product-label-right">'.$_off_percent.'%</span>';
                }else{ echo ' '; }

            }else{
                echo '<span class="ht-product-label ht-product-label-right">'.esc_html__( 'Sale!', 'woolentor' ).'</span>';
            }
        }
    }

    // Result Count
    function woolentor_product_result_count( $total, $perpage, $paged ){
        wc_set_loop_prop( 'total', $total );
        wc_set_loop_prop( 'per_page', $perpage );
        wc_set_loop_prop( 'current_page', $paged );
        $geargs = array(
            'total'    => wc_get_loop_prop( 'total' ),
            'per_page' => wc_get_loop_prop( 'per_page' ),
            'current'  => wc_get_loop_prop( 'current_page' ),
        );
        wc_get_template( 'loop/result-count.php', $geargs );
    }

    // product shorting
    function woolentor_product_shorting( $getorderby ){
        ?>
        <div class="woolentor-custom-sorting">
            <form class="woocommerce-ordering" method="get">
                <select name="orderby" class="orderby">
                    <?php
                        $catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
                            'menu_order' => __( 'Default sorting', 'woolentor' ),
                            'popularity' => __( 'Sort by popularity', 'woolentor' ),
                            'rating'     => __( 'Sort by average rating', 'woolentor' ),
                            'date'       => __( 'Sort by latest', 'woolentor' ),
                            'price'      => __( 'Sort by price: low to high', 'woolentor' ),
                            'price-desc' => __( 'Sort by price: high to low', 'woolentor' ),
                        ) );
                        foreach ( $catalog_orderby as $id => $name ){
                            echo '<option value="' . esc_attr( $id ) . '" ' . selected( $getorderby, $id, false ) . '>' . esc_attr( $name ) . '</option>';
                        }
                    ?>
                </select>
                <?php
                    // Keep query string vars intact
                    foreach ( $_GET as $key => $val ) {
                        if ( 'orderby' === $key || 'submit' === $key )
                            continue;
                        if ( is_array( $val ) ) {
                            foreach( $val as $innerVal ) {
                                echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
                            }
                        } else {
                            echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
                        }
                    }
                ?>
            </form>
        </div>
        <?php
    }

    // Custom page pagination
    function woolentor_custom_pagination( $totalpage ){
        echo '<div class="ht-row woocommerce"><div class="ht-col-xs-12"><nav class="woocommerce-pagination">';
            echo paginate_links( apply_filters(
                    'woocommerce_pagination_args', array(
                        'base'=> esc_url( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ), 
                        'format'    => '', 
                        'current'   => max( 1, get_query_var( 'paged' ) ), 
                        'total'     => $totalpage, 
                        'prev_text' => '&larr;', 
                        'next_text' => '&rarr;', 
                        'type'      => 'list', 
                        'end_size'  => 3, 
                        'mid_size'  => 3 
                    )
                )       
            );
        echo '</div></div></div>';
    }

    // Change Product Per page
    if( woolentor_get_option( 'enablecustomlayout', 'woolentor_woo_template_tabs', 'on' ) == 'on' ){
        function woolentor_custom_number_of_posts() {
            $limit = woolentor_get_option( 'shoppageproductlimit', 'woolentor_woo_template_tabs', 2 );
            $postsperpage = apply_filters( 'product_custom_limit', $limit );
            return $postsperpage;
        }
        add_filter( 'loop_shop_per_page', 'woolentor_custom_number_of_posts' );
    }


}