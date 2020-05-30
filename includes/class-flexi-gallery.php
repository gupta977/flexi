<?php
//[flexi-gallery] shortcode
//Below query works only for page number
//For load more & scroll use flexi_load_more.php

class Flexi_Shortcode_Gallery
{
 public $pop;
 public function __construct()
 {
//For easy understanding two shortcode is created with different name.
  add_shortcode('flexi-gallery', array($this, 'flexi_gallery'));
  add_shortcode('flexi-primary', array($this, 'flexi_gallery'));
  add_action('flexi_shortcode_processed', array($this, 'pass_shortcode_params'));

  $query_arg = array();
  $aa        = "..";
 }

 public function flexi_gallery($params)
 {
  global $post;
  global $wp_query;
  $atts = array();

  //Check if the gallery is meant for sidebar
  $clear = false; //If true, will clear all the extra stuff like pagination, tags, labels will be hidden
  if (isset($params['clear']) && 'true' == $params['clear']) {
   $clear = true;
  }

  //var_dump($params);
  //Album
  //Get redirected sub album
  $term_slug  = get_query_var('flexi_category');
  $term       = get_term_by('slug', $term_slug, 'flexi_category');
  $album_name = "";
  if ("" != $term_slug && true == $term && false == $clear) {
   $album_name = $term->name;
  }

  if ("" != $term_slug && false == $clear) {
   //album mentioned in url
   $album = $term_slug;

  } else if (isset($params['album'])) {
   //album at shortcode parameter
   $album = trim($params['album']);
  } else {
   $album = '';

  }

  //Tags
  $show_tag = false;
  if (flexi_get_option('gallery_tags', 'flexi_image_layout_settings', 1) == 1) {
   $show_tag = true;
  }
  if (isset($params['tag_show'])) {
   if ('off' == $params['tag_show']) {
    $show_tag = false;
   } else {
    $show_tag = true;
   }

  }

  //TAGs Keyword
  //Get tags
  $tag_slug = get_query_var('flexi_tag', "");
  $tag      = get_term_by('slug', $tag_slug, 'flexi_tag');
  $tag_name = "";
  if ("" != $tag_slug && true == $tag && false == $clear) {
   $tag_name = $tag->name;
  }

  if ("" != $tag_slug && false == $clear) {
   $keyword = $tag_slug;
//Check if flexi_tag available in URL
  } else if (isset($params['tag'])) {
//Check if tag is mentioned in shortcode
   $keyword = trim($params['tag']);
  } else {
   $keyword = '';
   //Blank keyword if not available.
  }

  //Page Navigation
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

  if (isset($params['perpage']) && $params['perpage'] > 0) {
   $postsperpage = $params['perpage'];
  } else {
   $postsperpage = flexi_get_option('perpage', 'flexi_image_layout_settings', 10);
  }

  if (isset($params['column']) && $params['column'] > 0) {
   $column = $params['column'];
  } else {
   $column = flexi_get_option('column', 'flexi_image_layout_settings', 3);
  }

  if (isset($params['width']) && $params['width'] > 0) {
   $width = $params['width'];
  } else {
   $width = flexi_get_option('t_width', 'flexi_media_settings', 150);
  }

  if (isset($params['height']) && $params['height'] > 0) {
   $height = $params['height'];
  } else {
   $height = flexi_get_option('t_height', 'flexi_media_settings', 150);
  }

  //Search
  if (isset($_GET['search']) && false == $clear) {
   $search = $_GET['search'];
  } else {
   $search = "";
  }

  //Order or sorting
  $orderby = '';
  if (isset($params['orderby'])) {
   $orderby = $params['orderby'];
  }

  //Author
  $username = get_query_var('flexi_user', "");
  if ("" != $username && false == $clear) {
   $user = $username;
  } else if (isset($params['user'])) {
   $user = $params['user'];
  } else {
   $user = "";
  }

  //Publish Status
  $post_status = array('publish');

  if ("show_mine" == $user) {
   if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $user         = $current_user->user_login;
    //$post_status  = array('draft', 'publish', 'pending');
   }

  }
  $atts['user'] = $user;

  //Popup
  if (isset($params['popup'])) {
   $popup = $params['popup'];
  } else {
   $popup = flexi_get_option('lightbox_switch', 'flexi_detail_settings', 1);
  }

  $atts['popup'] = $popup;

  //evalue data
  if (isset($params['evalue'])) {
   $evalue = $params['evalue'];
  } else {
   $evalue = "";
  }

  //attach value
  if (isset($params['attach'])) {
   $attach = $params['attach'];
  } else {
   $attach = "";
  }

  //Current page ID
  $cur_page_id = get_the_ID();

  //filter value
  if (isset($params['filter'])) {
   $filter = $params['filter'];
  } else {
   $filter = "";
  }

  //padding
  if (isset($params['padding'])) {
   $padding = $params['padding'] . 'px';
  } else {
   $padding = flexi_get_option('image_space', 'flexi_gallery_appearance_settings', 0) . 'px';
  }

  //hover_effect
  if (isset($params['hover_effect'])) {
   $hover_effect = $params['hover_effect'];
  } else {
   $hover_effect = flexi_get_option('hover_effect', 'flexi_gallery_appearance_settings', 'flexi_effect_2');
  }

  //hover_effect
  if (isset($params['hover_caption'])) {
   $hover_caption = $params['hover_caption'];
  } else {
   $hover_caption = flexi_get_option('hover_caption', 'flexi_gallery_appearance_settings', 'flexi_caption_4');
  }

  //Layout
  if (isset($params['layout'])) {
   $layout = trim($params['layout']);
  } else {
   $layout = flexi_get_option('gallery_layout', 'flexi_image_layout_settings', 'masonry');
  }

  //Navigation
  if (isset($params['navigation'])) {
   $navigation = trim($params['navigation']);
  } else {
   $navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'button');
  }

  //If for sidebar, reset the variables
  if ($clear) {
   $navigation    = "off"; //Disable any type of pagination
   $show_tag      = false; //Disable tags above gallery
   $paged         = 1; //Reset to first page
   $popup         = mt_rand(); //Random number assign to make popup unique at sidebar
   $atts['popup'] = $popup;
   //flexi_log($atts);
  }

//Filter gallery based on images, url and more.
  if (isset($params['filter'])) {
   $filter = trim($params['filter']);

  } else {
   $filter = '';
  }

  if ("" != $album && "" != $keyword) {
   $relation = "AND";
  } else {
   $relation = "OR";
  }

  if ("" != $album || "" != $keyword) {
   $args = array(
    'post_type'      => 'flexi',
    's'              => $search,
    'paged'          => $paged,
    'posts_per_page' => $postsperpage,
    'author_name'    => $user,
    'post_status'    => $post_status,
    'orderby'        => $orderby,
    'order'          => 'DESC',
    'tax_query'      => array(
     'relation' => $relation,
     array(
      'taxonomy' => 'flexi_category',
      'field'    => 'slug',
      'terms'    => explode(',', $album),
      //'terms'    => array( 'mobile', 'sports' ),
      //'include_children' => 0 //It will not include post of sub categories
     ),

     array(
      'taxonomy' => 'flexi_tag',
      'field'    => 'slug',
      'terms'    => explode(',', $keyword),
      //'terms'    => array( 'mobile', 'sports' ),
     ),

    ),
   );
  } else {
   $args = array(
    'post_type'      => 'flexi',
    's'              => $search,
    'paged'          => $paged,
    'posts_per_page' => $postsperpage,
    'author_name'    => $user,
    'post_status'    => $post_status,
    'orderby'        => $orderby,
    'order'          => 'DESC',

   );

  }

  $args['meta_query'] = array('compare' => 'AND');

  //If filter is used as parameter image,url,video
  if ('' != $filter) {
   $filter_array = array(
    'key'     => 'flexi_type',
    'value'   => $filter,
    'compare' => '=',
   );

   array_push($args['meta_query'], $filter_array);
  }

  //flexi_log($args);
  //flexi_log("-----------------");
  //Add meta query for attach page
  if (isset($params['attach']) && "true" == $params['attach']) {

   $attach_array = array(
    'key'     => 'flexi_attach_at',
    'value'   => get_the_ID(),
    'compare' => '=',
   );

   array_push($args['meta_query'], $attach_array);
  }

  //flexi_log($args);

  //Empty array if not logged in
  if (!is_user_logged_in() & isset($params['user']) && "show_mine" == $params['user']) {
   flexi_login_link();

   $args = array();
  }

  if (!empty($args)) {

   $query = new WP_Query($args);

   //Generate tags array
   if ($show_tag) {
    //Get the tags only
    $tags_array = array();
    while ($query->have_posts()): $query->the_post();
     foreach (wp_get_post_terms($post->ID, 'flexi_tag') as $t) {
      $tags_array[$t->slug] = $t->name;
     }
     // this adds to the array in the form ['slug']=>'name'
    endwhile;
    // de-dupe
    $tags_array = array_unique($tags_array);
    natcasesort($tags_array);
    //print_r($tags_array);
   }

   do_action('flexi_shortcode_processed', $atts);
   $count = 0;
   $put   = "";
   ob_start();

   $check_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/loop.php';
   if (file_exists($check_file)) {
    wp_register_style('flexi_' . $layout . '_layout', FLEXI_PLUGIN_URL . '/public/partials/layout/gallery/' . $layout . '/style.css', null, FLEXI_VERSION);
    wp_enqueue_style('flexi_' . $layout . '_layout');
    require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_header.php';
    while ($query->have_posts()): $query->the_post();
     require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_loop.php';
     $count++;
    endwhile;
    require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/attach_footer.php';
    $put = ob_get_clean();
    wp_reset_query();
    wp_reset_postdata();
    if (is_archive() || is_singular() || is_home() || (defined('REST_REQUEST') && REST_REQUEST)) {
     return $put;
    } else {
     return '';
    }
   } else {
    return __("Layout not available", 'flexi') . ': ' . $layout;
   }
  }
 }

 public function pass_shortcode_params($atts = array())
 {
  //flexi_log($atts);
  ob_start();
  if (!is_admin()) {
   ?>
<script>
jQuery(document).ready(function() {
 // console.log("start");
  document.documentElement.style.setProperty('--flexi_padding', jQuery("#padding").text());

<?php
$enable_conflict = flexi_get_option('conflict_disable_fancybox', 'flexi_conflict_settings', 0);
   if ("1" != $enable_conflict) {
    if ('inline' == $atts['popup']) {
     ?>
    jQuery('[data-fancybox-trigger').fancybox({
          selector : '.flexi_show_popup_<?php echo $atts['popup']; ?> a:visible',
          thumbs   : {
      autoStart : false
    },
    protect: false,
    arrows:false,
      });
      <?php
} else {
     ?>
  jQuery('[data-fancybox-trigger').fancybox({
        selector : '.flexi_show_popup_<?php echo $atts['popup']; ?> a:visible',
        thumbs   : {
    autoStart : true
  },
  protect: true,
        caption: function(instance, item) {
          //This is not working on ajax loading. only for for page navigation.
         // return jQuery(this).closest('flexi_media_holder').find('flexi_figcaption').html();
          return jQuery(this).find('.flexi_figcaption').html();


        }
    });
    <?php
}
   }
   ?>

});
</script>

<?php
}
  echo ob_get_clean();

 }

 public function enqueue_styles_head()
 {

  $t_width  = flexi_get_option('t_width', 'flexi_media_settings', 150);
  $t_height = flexi_get_option('t_height', 'flexi_media_settings', 150);
  $m_width  = flexi_get_option('m_width', 'flexi_media_settings', 300);
  $m_height = flexi_get_option('m_height', 'flexi_media_settings', 300);
  $l_width  = flexi_get_option('l_width', 'flexi_media_settings', 600);
  $l_height = flexi_get_option('l_height', 'flexi_media_settings', 400);
  $padding  = '0';
  $put      = "";
  ob_start();

  ?>
<style>
:root {
  --flexi_t_width: <?php echo $t_width; ?>px;
  --flexi_t_height: <?php echo $t_height; ?>px;
  --flexi_m_width: <?php echo $m_width; ?>px;
  --flexi_m_height: <?php echo $m_height; ?>px;
  --flexi_l_width: <?php echo $l_width; ?>px;
  --flexi_l_height: <?php echo $l_height; ?>px;
  --flexi_padding: <?php echo $padding; ?>px;
}
</style>

 <?php
$put = ob_get_clean();
  echo $put;
 }

}
