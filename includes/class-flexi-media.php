<?php
class Flexi_Media_Settings
{
 public function __construct()
 {
  //add_action('after_setup_theme', array($this, 'custom_image'));
  add_action('flexi_submit_complete', array($this, 'generate_thumbnail'), 10, 1);
 }

 public function generate_thumbnail($post_id)
 {
  //flexi_log($post_id . " is just uploaded");
  $flexi_post = get_post($post_id);
  $info       = new Flexi_Post_Info();
  $type       = $info->post_meta($post_id, 'flexi_type', '');
  if ('video' == $type) {
   $video = $info->media_path($post_id, false);
   $this->flexi_ffmpeg($video, $post_id);
  }
  return true;
 }

//FFMPEG generate thumbnails
 public function flexi_ffmpeg($video, $post_id)
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

  if ($this->make_jpg($input, $output, $ffmpegpath)) {

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

   //echo 'success';

  } else {
   //echo 'bah!';
  }

  //echo exec('dir');
  //extension_loaded('ffmpeg') or die('Error in loading ffmpeg');

 }

 public function make_jpg($input, $output, $ffmpegpath, $fromdurasec = "01")
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

 /*
public function custom_image()
{

$t_width  = flexi_get_option('t_width', 'flexi_media_settings', 150);
$t_height = flexi_get_option('t_height', 'flexi_media_settings', 150);

$m_width  = flexi_get_option('m_width', 'flexi_media_settings', 300);
$m_height = flexi_get_option('m_height', 'flexi_media_settings', 300);

$l_width  = flexi_get_option('l_width', 'flexi_media_settings', 1024);
$l_height = flexi_get_option('l_height', 'flexi_media_settings', 1024);

if (flexi_get_option('crop_thumbnail', 'flexi_media_settings', 0) == 0) {
$crop = false;
} else {
$crop = true;
}

add_image_size('flexi-thumb', $t_width, $t_width, $crop);
add_image_size('flexi-medium', $m_width, $m_width);
add_image_size('flexi-large', $l_width, $l_width);
}
 */
}

$flexi_media = new Flexi_Media_Settings();
