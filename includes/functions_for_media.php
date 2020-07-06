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
 $ftype = flexi_get_type($post);
 if ('large' == $size) {

  if ("mp4" == $ftype || "pdf" == $ftype) {
   $thumb_url = get_post_meta($post->ID, 'flexi_file', 1);
  } else if ("url" == $ftype) {
   $thumb_url = get_post_meta($post->ID, 'flexi_url', 1);
  } else if ("image" == $ftype || "plain" == $ftype) {

   $image_attributes = wp_get_attachment_image_src(get_post_meta($post->ID, 'flexi_image_id', 1), $size);
   if ($image_attributes) {
    return $image_attributes[0];
   } else {
    $thumb_url = FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
   }

  } else {

   $thumb_url = FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';

  }
  return $thumb_url;

 } else {

  if ("url" == $ftype) {
   return get_post_meta($post->ID, 'flexi_image', '')[0];
  } else if ("video" == $ftype || "audio" == $ftype || "other" == $ftype) {
   return FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
  } else {
   $image_attributes = wp_get_attachment_image_src(get_post_meta($post->ID, 'flexi_image_id', 1), $size);
   if ($image_attributes) {
    return $image_attributes[0];
   } else {
    return FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
   }
  }
 }

 return FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
}

//Return the type of flexi post is image,video,audio,url,other
function flexi_get_type($post)
{
 $flexi_type = get_post_meta($post->ID, 'flexi_type', '');

 if (isset($flexi_type[0])) {
  if ("video" == $flexi_type[0] || "audio" == $flexi_type[0] || "other" == $flexi_type[0]) {
   $rawfile  = get_post_meta($post->ID, 'flexi_file', 1);
   $filetype = wp_check_filetype($rawfile);
   $ext      = $filetype['ext'];
   if ("pdf" == $ext) {
    return "pdf";
   } else if ("mp4" == $ext) {
    return "mp4";
   } else if ("mp3" == $ext) {
    return "mp3";

   } else {
    return $flexi_type[0];
   }

  } else {
   return $flexi_type[0];
  }
 } else {
  return 'image';
 }
}

//Generates large preview for detail page
function flexi_large_media($post, $class = 'flexi_large_image')
{

 $flexi_type = flexi_get_type($post);
 //flexi_log($flexi_type);
 if ("url" == $flexi_type) {
  $media_url = esc_url(flexi_image_src('large', $post));
  $attr      = array('src' => $media_url);
  return wp_oembed_get($attr['src']);

 } else if ("video" == $flexi_type || "mp4" == $flexi_type) {
  $video = flexi_file_src($post, true);
  $attr  = array('src' => $video);
  $src   = wp_check_filetype($video)['ext'];
  //flexi_log($src);
  if ('mp4' == $src || 'm4v' == $src || 'webm' == $src || 'ogv' == $src || 'wmv' == $src || 'flv' == $src || 'mp4' == $src) {
   return wp_video_shortcode($attr); //mp4, m4v, webm, ogv, wmv, flv
  } else {
   return '';
  }

 } else if ("audio" == $flexi_type || "mp3" == $flexi_type) {
  $audio = flexi_file_src($post, true);
  $attr  = array('src' => $audio);
  return wp_audio_shortcode($attr);

 } else {
  $media_url = esc_url(flexi_image_src('large', $post));
  //flexi_log($media_url . '---' . $flexi_type);
  return "<img id='" . $class . "' class='" . $class . "' src='" . $media_url . "' >";
 }

}

//Get link and added attributes of the image based on lightbox
function flexi_image_data($size = 'full', $post = '', $popup = "on")
{
 //flexi_log($popup);
 if ("off" == $popup) {
  $lightbox = false;
 } else {
  $lightbox = true;
 }

 $data          = array();
 $data['title'] = $post->post_title;

 if ('' == $post) {
  global $post;
 }

 if ($lightbox) {
  if ('inline' == $popup) {
   $data['url']   = 'javascript:;';
   $data['src']   = '#flexi_inline_' . $post->ID;
   $data['extra'] = 'data-fancybox-trigger';
   $data['popup'] = 'flexi_show_popup_' . $popup;
  } else if ('custom' == $popup) {
   $nonce         = wp_create_nonce("flexi_ajax_popup");
   $data['url']   = 'javascript:;';
   $data['src']   = admin_url('admin-ajax.php?action=flexi_ajax_post_view&id=' . $post->ID . '&nonce=' . $nonce);
   $data['extra'] = 'data-fancybox data-type="ajax"';
   $data['popup'] = 'flexi_show_popup_' . $popup;
  } else {
   $data['url']   = flexi_image_src('large', $post);
   $data['src']   = $data['url'];
   $data['extra'] = 'data-fancybox-trigger';
   $data['popup'] = 'flexi_show_popup_' . $popup;
  }
 } else {
  $data['url']   = get_permalink($post->ID);
  $data['src']   = $data['url'];
  $data['extra'] = '';
  $data['popup'] = 'flexi_media_holder';
 }

 $data['type'] = flexi_get_type($post);

 return $data;
}

//FFMPEG generate thumbnails
function flexi_ffmpeg($video, $post_id)
{
 $flexi_post = get_post($post_id);

 if (!function_exists('wp_generate_attachment_metadata')) {
  require_once ABSPATH . 'wp-admin/includes/image.php';
 }
 $upload_dir_paths = wp_upload_dir();

 $ffmpegpath = "E:\\ffmpeg\bin\\ffmpeg.exe";
 $image_name = $post_id . '_thumbnail.jpg';
 $input      = $video;
 $output     = $upload_dir_paths['path'] . "/" . $image_name; // Create image file name

 if (make_jpg($input, $output, $ffmpegpath)) {

  $image_data       = file_get_contents($output); // Get image data
  $unique_file_name = wp_unique_filename($upload_dir_paths['path'], $image_name); // Generate unique name

  // Create the image  file on the server
  file_put_contents($output, $image_data);

  // Check image file type
  $wp_filetype = wp_check_filetype($output, null);

  // Set attachment data
  $attachment = array(
   'post_mime_type' => $wp_filetype['type'],
   'post_title'     => sanitize_file_name($image_name),
   'post_content'   => '',
   'post_status'    => 'inherit',
  );

  // Create the attachment
  $attach_id = wp_insert_attachment($attachment, $output, $post_id);
  // Define attachment metadata
  $attach_data = wp_generate_attachment_metadata($attach_id, $output);

  // Assign metadata to attachment
  wp_update_attachment_metadata($attach_id, $attach_data);

  add_post_meta($post_id, 'flexi_image_id', $attach_id);
  add_post_meta($post_id, 'flexi_image', wp_get_attachment_url($attach_id));

  echo 'success';

 } else {
  echo 'bah!';
 }

 //echo exec('dir');
 //extension_loaded('ffmpeg') or die('Error in loading ffmpeg');

}

function make_jpg($input, $output, $ffmpegpath, $fromdurasec = "01")
{

 if (!file_exists($input)) {
  return false;
 }

 $command = "$ffmpegpath -i $input -an -ss 00:00:$fromdurasec -r 1 -vframes 1 -f mjpeg -y $output";

 @exec($command, $ret);
 if (!file_exists($output)) {
  return false;
 }

 if (filesize($output) == 0) {
  return false;
 }

 return true;
}
