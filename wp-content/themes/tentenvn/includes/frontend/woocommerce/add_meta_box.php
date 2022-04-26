<?php 

## ---- 1. Backend ---- ##
// Adding a custom Meta container to admin products pages
add_action( 'add_meta_boxes', 'create_custom_meta_box' );
if ( ! function_exists( 'create_custom_meta_box' ) )
{
  function create_custom_meta_box()
  {
    add_meta_box(
      'custom_product_meta_box',  __( 'Thông số kỹ thuật', 'cmb' ), 'add_custom_content_meta_box', 'product', 'normal','default'
    );
  }
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box' ) ){
  function add_custom_content_meta_box( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $tskt = get_post_meta($post->ID, $prefix.'tskt_ip', true) ? get_post_meta($post->ID, $prefix.'tskt_ip', true) : '';
        $args['textarea_rows'] = 6;

        wp_editor( $tskt, 'tskt_ip', $args );


        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
      }
    }

//Save the data of the Meta field
    add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );
    if ( ! function_exists( 'save_custom_content_meta_box' ) )
    {

      function save_custom_content_meta_box( $post_id ) {
        $prefix = '_bhww_'; // global $prefix;

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'custom_product_field_nonce' ] ) ) {
          return $post_id;
        }
        $nonce = $_REQUEST[ 'custom_product_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
          return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
          return $post_id;
        }

        // Check the user's permissions.
        if ( 'product' == $_POST[ 'post_type' ] ){
          if ( ! current_user_can( 'edit_product', $post_id ) )
            return $post_id;
        } else {
          if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
        }

        // Sanitize user input and update the meta field in the database.
        update_post_meta( $post_id, $prefix.'tskt_ip', wp_kses_post($_POST[ 'tskt_ip' ]) );
      }
    }

## ---- 2. Front-end ---- ##

// Create custom tabs in product single pages
    add_filter( 'woocommerce_product_tabs', 'custom_product_tabs' );
    function custom_product_tabs( $tabs ) {
      global $post;

      $product_tskt = get_post_meta( $post->ID, '_bhww_tskt_ip', true );

      if ( ! empty( $product_tskt ) )
        $tabs['tskt_tab'] = array(
          'title'    => __( 'Thông số kỹ thuật', 'woocommerce' ),
          'priority' => 10,
          'callback' => 'tskt_product_tab_content'
        );

      return $tabs;
    }

// Remove description heading in tabs content
    add_filter('woocommerce_product_description_heading', '__return_null');

// Add content to custom tab in product single pages (1)
    function tskt_product_tab_content() {
      global $post;

      $product_tskt = get_post_meta( $post->ID, '_bhww_tskt_ip', true );

      if ( ! empty( $product_tskt ) ) {
        // Updated to apply the_content filter to WYSIWYG content
        echo apply_filters( 'the_content', $product_tskt );
      }
    }