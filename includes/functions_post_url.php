<?php
//Submits new post.
//$title = Title of post
//$url = media url
//$content= Description
//category =Album name
//$detail_layout = layout name for post detail page. Not required if lightbox is enabled.
function flexi_submit_url($title, $url, $content, $category, $detail_layout, $tags = '')
{
 $post_type    = 'flexi';
 $taxonomy     = 'flexi_category';
 $tag_taxonomy = 'flexi_tag';

 $newPost            = array('id' => false, 'error' => false);
 $newPost['error'][] = "";
 $file_count         = 0;
 if (empty($title)) {
  $newPost['error'][] = 'required-title';
 }

 $newPost['error'][] = apply_filters('flexi_verify_submit', "");

 if (flexi_allowed_embed_url($url) == '') {
  $newPost['error'][] = 'invalid-url';
 }

 foreach ($newPost['error'] as $e) {
  if (!empty($e)) {
   //error_log("Error: ".$e);
   unset($newPost['id']);
   return $newPost;
  }
 }
 $postData = flexi_prepare_post($title, $content, $post_type);

 do_action('flexi_insert_before', $postData);
 $newPost['id'] = wp_insert_post($postData);
 if ($newPost['id']) {

  $post_id = $newPost['id'];

  //Submit extra fields data
  for ($z = 1; $z <= 10; $z++) {
   if (isset($_POST['flexi_field_' . $z])) {
    add_post_meta($post_id, 'flexi_field_' . $z, $_POST['flexi_field_' . $z]);
   }
  }

  //Ended to submit extra fields
  if ('' != $category) {
   wp_set_object_terms($post_id, array($category), $taxonomy);
  }

  if (taxonomy_exists($tag_taxonomy)) {
   //Set TAGS
   if ('' != $tags) {
    wp_set_object_terms($post_id, explode(",", $tags), $tag_taxonomy);
   }
  }

  //Assign detail_layout layout
  add_post_meta($post_id, 'flexi_layout', $detail_layout);
  //Assign Flexi URL
  add_post_meta($post_id, 'flexi_url', $url);
  //Assign Flexi Type
  add_post_meta($post_id, 'flexi_type', 'url');
  //Assign thumbnail
  $em    = new Flexi_oEmbed();
  $thumb = $em->getUrlThumbnail($url, $post_id);
  add_post_meta($post_id, 'flexi_image', $thumb);

 } else {
  $newPost['error'][] = 'post-fail';
 }

 do_action('flexi_insert_after', $newPost);
 return $newPost;

}

function flexi_allowed_embed_url($url)
{
 $check_file = ABSPATH . 'wp-includes/class-wp-oembed.php';
 if (file_exists($check_file)) {
  require_once ABSPATH . 'wp-includes/class-wp-oembed.php';
 } else {
  require_once ABSPATH . 'wp-includes/class-oembed.php';
 }

 $oembed = new WP_oEmbed;
 if (wp_http_validate_url($url)) {
  $raw_provider = parse_url($oembed->get_provider($url));
  if (isset($raw_provider['host'])) {

   $check = false;
   if (false !== strpos($raw_provider['host'], 'youtube')) {

    $check = true;
   } else if (false !== strpos($raw_provider['host'], 'vimeo')) {

    $check = true;
   } else {

    $check = false;
   }
   return $check;
   //www.dailymotion.com

   // return true;
  }
 }
 return false;

}
