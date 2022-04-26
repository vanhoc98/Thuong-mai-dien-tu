<?php 

/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 8;
  return $cols;
}
// REMOVE SIDEBAR SINGLE PRODUCT
add_action( 'wp', 'bbloomer_remove_sidebar_product_pages' );

function bbloomer_remove_sidebar_product_pages() {
  if ( is_product() ) {
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
  }
}

