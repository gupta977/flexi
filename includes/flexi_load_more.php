<?php
//Load more content ajax call
add_action("wp_ajax_flexi_load_more", "flexi_load_more");
add_action("wp_ajax_nopriv_flexi_load_more", "flexi_load_more");

function flexi_load_more()
{
 global $wp_query;
 global $post;
 $paged         = $_REQUEST["max_paged"];
 $layout        = $_REQUEST['gallery_layout'];
 $popup         = $_REQUEST['popup'];
 $album         = $_REQUEST['album'];
 $search        = $_REQUEST['search'];
 $postsperpage  = $_REQUEST['postsperpage'];
 $orderby       = $_REQUEST['orderby'];
 $user          = $_REQUEST['user'];
 $keyword       = $_REQUEST['keyword'];
 $padding       = $_REQUEST['padding'];
 $hover_effect  = $_REQUEST['hover_effect'];
 $hover_caption = $_REQUEST['hover_caption'];
 $evalue        = $_REQUEST['evalue'];
 $column        = $_REQUEST['column'];
 $attach        = $_REQUEST['attach'];
 $attach_id     = $_REQUEST['attach_id'];
 $filter        = $_REQUEST['filter'];
 ob_start();

 // A default response holder, which will have data for sending back to our js file
 $response = array(
  'error' => false,
  'msg'   => 'No Message',
  'count' => '0',
 );

 //var_dump($response);

 //Publish Status
 $post_status = array('publish');

 if (is_user_logged_in()) {

  $current_user = wp_get_current_user();
  $cur_user     = $current_user->user_login;
  if ($cur_user == $user) {
   //$post_status = array('draft', 'publish', 'pending');
  }

 }

 if ("" != $album && "" != $keyword) {
  $relation = "AND";
 } else {
  $relation = "OR";
 }

 if ("" != $album || "" != $keyword) {
  $args = array(
   'post_type'      => 'flexi',
   'paged'          => $paged,
   's'              => $search,
   'posts_per_page' => $postsperpage,
   'orderby'        => $orderby,
   'post_status'    => $post_status,
   'order'          => 'DESC',
   'author_name'    => $user,
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
 if ("true" == $attach && '' != $attach_id) {

  $attach_array = array(
   'key'     => 'flexi_attach_at',
   'value'   => $attach_id,
   'compare' => '=',
  );

  array_push($args['meta_query'], $attach_array);
 }

 $query = new WP_Query($args);

 $put = "";

 //flexi_log($args);
 //echo "----";
 $count = 0;
 while ($query->have_posts()): $query->the_post();
  $tags = flexi_get_taxonomy_raw($post->ID, 'flexi_tag');
  $count++;
  if ('' != $layout) {
   require FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/loop.php';
  }

 endwhile;

 $put = ob_get_clean();
 //$response['msg'] = "hii";
 $response['msg']   = $put;
 $response['count'] = $count;

 $result = json_encode($response);
 echo $result;
 wp_reset_query();
 die();
}
