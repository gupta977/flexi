<?php
//Functions related to media only
//Get attachment detail
function flexi_get_attachment($attachment_id)
{
 $attachment = get_post($attachment_id);
 return array(
  'alt'         => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
  'caption'     => $attachment->post_excerpt,
  'description' => $attachment->post_content,
  'href'        => get_permalink($attachment->ID),
  'src'         => $attachment->guid,
  'title'       => $attachment->post_title,
 );
}

//Get full size media server path.
//TRUE return full http url
//FALSE return server core path
function flexi_file_src($post, $url = true)
{
 $ftype = flexi_get_type($post);

 if ("image" == $ftype || '' == $ftype) {
  $rawfile = get_post_meta($post->ID, 'flexi_image_id', 1);
 } else if ("url" == $ftype) {
  $rawfile = '';
 } else {
  $rawfile = get_post_meta($post->ID, 'flexi_file_id', 1);
 }

 if ('' != $rawfile) {
  if ($url) {
   return wp_get_attachment_url($rawfile);
  } else {
   return get_attached_file($rawfile);
  }
 } else {
  return '';
 }

}



//Return image url
function flexi_image_src($size = 'thumbnail', $post)
{
 $image_attributes = wp_get_attachment_image_src(get_post_meta($post->ID, 'flexi_image_id', 1), $size);
 $ftype            = flexi_get_type($post);

 if ($image_attributes) {
  return $image_attributes[0];
 } else {
  //If no image ID found, check if it has direct URL for thumbnail & large size for video URL
  //Use flexi_large_media() at detail page

  if ('large' == $size) {
   $thumb_url = get_post_meta($post->ID, 'flexi_url', '');
  } else {
   $thumb_url = get_post_meta($post->ID, 'flexi_image', '');
  }
  if (!empty($thumb_url)) {
   return $thumb_url[0];
  } else {

   return FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
  }
 }
}

//Return the type of flexi post is image,video,audio,url,other
function flexi_get_type($post)
{
 $flexi_type = get_post_meta($post->ID, 'flexi_type', '');
 if (isset($flexi_type[0])) {
  return $flexi_type[0];
 } else {
  return '';
 }
}

//Generates large preview for detail page
function flexi_large_media($post, $class = 'flexi_large_image')
{

 $flexi_type = flexi_get_type($post);

 if ("url" == $flexi_type) {
  $media_url = esc_url(flexi_image_src('large', $post));
  $attr      = array('src' => $media_url);
  return wp_oembed_get($attr['src']);

 } else if ("video" == $flexi_type) {
  $video = flexi_file_src($post, true);
  $attr  = array('src' => $video);
  return wp_video_shortcode($attr);

 } else if ("audio" == $flexi_type) {
  $audio = flexi_file_src($post, true);
  $attr  = array('src' => $audio);
  return wp_audio_shortcode($attr);

 } else {
  $media_url = esc_url(flexi_image_src('large', $post));
  return "<img id='" . $class . "' src='" . $media_url . "' >";
 }

}

//Get link and added attributes of the image based on lightbox
function flexi_image_data($size = 'full', $post = '', $popup = "on")
{
 //flexi_log($popup);
 if ("on" == $popup || '1' == $popup) {
  $popup    = 1;
  $lightbox = true;
 } else {
  $popup    = 0;
  $lightbox = false;
 }

 $data          = array();
 $data['title'] = get_the_title();

 if ('' == $post) {
  global $post;
 }

 if ($lightbox) {
  $data['url']   = flexi_image_src('large', $post);
  $data['extra'] = 'data-fancybox-trigger';
  $data['popup'] = 'flexi_show_popup';
 } else {
  $data['url']   = get_permalink();
  $data['extra'] = '';
  $data['popup'] = 'flexi_media_holder';
 }
 return $data;
}