<?php


//Show Total Sales
add_action( 'woocommerce_single_product_summary', 'bbloomer_product_sold_count', 11 );

function bbloomer_product_sold_count() {
  global $product;
  $units_sold = get_post_meta( $product->get_id(), 'total_sales', true );
  if ( $units_sold ) echo '<p class="tg_sold_out">' . sprintf( __( 'Số lượng đã bán: <strong>%s</strong>', 'woocommerce' ), $units_sold ) . '</p>';
}


// Add button checkout single product 
function add_content_after_addtocart() {

    // get the current post/product ID
  $current_product_id = get_the_ID();

    // get the product based on the ID
  $product = wc_get_product( $current_product_id );

    // get the "Checkout Page" URL
  $checkout_url = WC()->cart->get_checkout_url();

    // run only on simple products
  if( $product->is_type( 'simple' ) ){
    echo '<a href="'.$checkout_url.'?add-to-cart='.$current_product_id.'" class="single_add_to_cart_button button alt">Thanh toán ngay</a>';
  }
}
add_action( 'woocommerce_after_add_to_cart_button', 'add_content_after_addtocart' );

// Remove sku single product
function bbloomer_remove_product_page_sku( $enabled ) {
    if ( !is_admin() && is_product() ) {
        return false;
    }
 
    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'bbloomer_remove_product_page_sku' );

function template_chooser($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'products' )   
  {
    return locate_template('single-product/archive-product.php');  //  redirect to archive-search.php
  }   
  return $template;   
}
add_filter('template_include', 'template_chooser');   

// Add minus plus ajax
function jh_add_script_to_footer(){
    if( ! is_admin() ) { ?> 
    <script>
jQuery(document).ready(function($){
$(document).on('click', '.plus', function(e) { // replace '.quantity' with document (without single quote)
    $input = $(this).prev('input.qty');
    var val = parseInt($input.val());
    var step = $input.attr('step');
    step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
    $input.val( val + step ).change();
});
$(document).on('click', '.minus',  // replace '.quantity' with document (without single quote)
    function(e) {
    $input = $(this).next('input.qty');
    var val = parseInt($input.val());
    var step = $input.attr('step');
    step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
    if (val > 0) {
        $input.val( val - step ).change();
    }
});
});
</script>
<?php
    }
}
add_action( 'wp_footer', 'jh_add_script_to_footer' );

// Move price under short description single product 
function move_single_product_price() {
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 29);
}
add_action('woocommerce_single_product_summary', 'move_single_product_price', 1);