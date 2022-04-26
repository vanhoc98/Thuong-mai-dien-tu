<?php

/**
 * Get Post List
 * return array
 */
function htslider_post_name( $post_type = 'post' ){
    $options = array();
    $options['0'] = __('Select','ht-slider');
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
 * Get Taxonomy
 * return array
 */
function htslider_get_taxonomies( $texonomy = 'category' ){
    $options = array();
    $options['0'] = __('Select','ht-slider');
    $terms = get_terms( array(
        'taxonomy' => $texonomy,
        'hide_empty' => true,
    ));
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            $options[ $term->slug ] = $term->name;
        }
        return $options;
    }
}