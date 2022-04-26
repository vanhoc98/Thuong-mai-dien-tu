<?php 

include 'lcp/lcp-widget.php';
include 'lcp/lcp-options.php';
require_once 'lcp/lcp-catlistdisplayer.php';

class ListCategoryPosts{
  private static $default_params = null;
  public static function default_params(){
    if (self::$default_params === null) {
      self::$default_params = array(
        'id' => '0',
        'name' => '',
        'orderby' => '',
        'order' => '',
        'numberposts' => '',
        'date' => 'no',
        'date_tag' => 'span',
        'date_class' =>'aio_date',
        'dateformat' => get_option('date_format'),
        'date_modified' => '',
        'date_modified_tag' => '',
        'date_modified_class' => '',
        'author' => 'no',
        'author_posts_link' => 'no',
        'author_tag' =>'span',
        'author_class' => 'aio_author',
        'author_posts' => '',
        'template' => '',
        'excerpt' => 'no',
        'excerpt_size' => '55',
        'excerpt_strip' => 'yes',
        'excerpt_overwrite' => 'no',
        'excerpt_tag' =>'div',
        'excerpt_class' =>'aio_excerpt',
        'exclude' => '0',
        'excludeposts' => '0',
        'offset' => '0',
        'tags' => '',
        'exclude_tags' => '',
        'currenttags' => '',
        'content' => 'no',
        'content_tag' => '',
        'content_class' => '',
        'display_id' => 'no',
        'catlink' => 'no',
        'catname' => 'no',
        'catlink_string' => '',
        'catlink_tag' =>'',
        'catlink_class' => '',
        'child_categories' => 'yes',
        'comments' => 'no',
        'comments_tag' => '',
        'comments_class' => '',
        'starting_with' => '',
        'thumbnail' => 'no',
        'thumbnail_size' => 'thumbnail',
        'thumbnail_class' => '',
        'force_thumbnail' => '',
        'title_tag' => 'h4',
        'title_class' => 'aio_title_post',
        'title_limit' => '0',
        'post_type' => '',
        'post_status' => '',
        'post_parent' => '0',
        'post_suffix' => '',
        'show_protected' => 'no',
        'class' => 'aio_catlist',
        'conditional_title' => '',
        'conditional_title_tag' => '',
        'conditional_title_class' => '',
        'customfield_name' => '',
        'customfield_value' =>'',
        'customfield_display' =>'',
        'customfield_display_glue' => '',
        'customfield_display_name' =>'',
        'customfield_display_name_glue' => ' : ',
        'customfield_display_separately' => 'no',
        'customfield_orderby' =>'',
        'customfield_tag' => '',
        'customfield_class' => '',
        'taxonomy' => '',
        'taxonomies_and' => '',
        'taxonomies_or' => '',
        'terms' => '',
        'categorypage' => '',
        'category_count' => '',
        'category_description' => 'no',
        'morelink' => '',
        'morelink_class' => '',
        'morelink_tag' => '',
        'posts_morelink' => '',
        'posts_morelink_class' => '',
        'year' => '',
        'monthnum' => '',
        'search' => '',
        'link_target' => '',
        'pagination' => '',
        'pagination_next' => '>>',
        'pagination_prev' => '<<',
        'no_posts_text' => "",
        'instance' => '0',
        'no_post_titles' => 'no',
        'link_titles' => true,
        'link_dates' => 'no',
        'after' => '',
        'after_year' => '',
        'after_month' => '',
        'after_day' => '',
        'before' => '',
        'before_year' => '',
        'before_month' => '',
        'before_day' => '',
        'tags_as_class' => 'no',
        'pagination_bookmarks' => '',
      );
    }
    return self::$default_params;
  }

  /**
   * Gets the shortcode parameters and instantiate plugin objects
   * @param $atts
   * @param $content
   */
  static function catlist_func($atts, $content = null) {
    $atts = shortcode_atts(self::default_params(), $atts);

    if($atts['numberposts'] == ''){
      $atts['numberposts'] = get_option('numberposts');
    }
    if($atts['pagination'] == 'yes' ||
       (get_option('lcp_pagination') === 'true' &&
        $atts['pagination'] !== 'false') ){
      lcp_pagination_css();
    }
    $catlist_displayer = new CatListDisplayer($atts);
    return $catlist_displayer->display();
  }
}

add_shortcode( 'catlist', array('ListCategoryPosts', 'catlist_func') );

// function lpc_meta($links, $file) {
//   $plugin = plugin_basename(__FILE__);

//   if ($file == $plugin):
//     return array_merge(
//       $links,
//       array( sprintf('<a href="http://wordpress.org/extend/plugins/list-category-posts/other_notes/">%s</a>', __('How to use','list-category-posts')) ),
//       array( sprintf('<a href="http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/#support">%s</a>', __('Donate','list-category-posts')) ),
//       array( sprintf('<a href="https://github.com/picandocodigo/List-Category-Posts">%s</a>', __('Fork on Github','list-category-posts')) )
//     );
//   endif;

//   return $links;
// }

// add_filter( 'plugin_row_meta', 'lpc_meta', 10, 2 );

//adds a default value to numberposts on plugin activation
function set_default_numberposts() {
    add_option('numberposts', 10);
}
register_activation_hook( __FILE__, 'set_default_numberposts' );

// function load_i18n(){
//   load_plugin_textdomain( 'list-category-posts', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
// }
// add_action( 'plugins_loaded', 'load_i18n' );
