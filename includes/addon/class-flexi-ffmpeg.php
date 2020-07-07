<?php
class Flexi_Addon_FFMPEG
{
 public function __construct()
 {

  add_filter('flexi_settings_fields', array($this, 'add_extension'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  add_action('flexi_activated', array($this, 'set_value'));

 }

 //add_filter flexi_settings_tabs
 public function add_tabs($new)
 {
  $tabs = array();
  $new  = array_merge($tabs, $new);
  return $new;
 }

 //Add enable/disable option at extension tab
 public function add_extension($new)
 {
  $fields = array('flexi_extension' => array(
   array(
    'name'              => 'enable_ffmpeg',
    'label'             => __('Video FFMPEG encoding', 'flexi'),
    'description'       => __('This will generate thumbnail for video files like mp4,3gp,mov. Your server must have ffmpeg installed.', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=general&section=flexi_media_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
    'type'              => 'checkbox',
    'sanitize_callback' => 'intval',

   ),
  ),
  );
  $new = array_merge_recursive($new, $fields);

  return $new;
 }

 //Add section fields
 public function add_fields($new)
 {
  $enable_addon = flexi_get_option('enable_ffmpeg', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $fields = array('flexi_media_settings' => array(
    array(
     'name'              => 'ffmpeg_path',
     'label'             => __('FFMPEG folder path', 'flexi'),
     'description'       => __("This should be the folder where ffmpeg installed on your server. Eg. /usr/local/bin", "flexi"),
     'type'              => 'text',
     'size'              => 'medium',
     'sanitize_callback' => 'sanitize_text_field',
    ),

   ),
   );
   $new = array_merge($new, $fields);
  }
  return $new;
 }

 public function set_value()
 {
//Set default location of elements
  flexi_get_option('ffmpeg_path', 'flexi_media_settings', '/usr/local/bin');
 }

}

//FFMPEG settings
$conflict = new Flexi_Addon_FFMPEG();
