<?php
class Flexi_Addon_Mime_Type
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_extension'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));

 }

 //add_filter flexi_settings_tabs
 public function add_tabs($new)
 {
  $tabs = array();
  $new  = array_merge($tabs, $new);
  return $new;
 }

 //Add Section title
 public function add_section($new)
 {
  $enable_addon = flexi_get_option('enable_mime_type', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $sections = array(
    array(
     'id'          => 'flexi_mime_type',
     'title'       => __('Manage Mime Type', 'flexi'),
     'description' => __('Add new file type to upload.', 'flexi'),
     'tab'         => 'form',
    ),
   );
   $new = array_merge($new, $sections);
  }
  return $new;
 }

 //Add enable/disable option at extension tab
 public function add_extension($new)
 {
  $fields = array('flexi_extension' => array(
   array(
    'name'              => 'enable_mime_type',
    'label'             => __('Enable Mime Type', 'flexi'),
    'description'       => __('Add new file type while uploading. Disable it from extensions if mime type addition/removal is handled by other plugins.', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_mime_type') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
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

  $enable_addon = flexi_get_option('enable_mime_type', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $fields = array('flexi_mime_type' => array(

    array(
     'name'        => 'flexi_new_mime_type',
     'label'       => __('Add new file type', 'flexi'),
     'description' => 'In addition to the ones that WordPress allows by default.',
     'type'        => 'multicheck',
     'options'     => array(
      'csv' => __('Comma Separated Values File (.csv)', 'flexi'),
      'mp3' => __('MP3 Audio File (.mp3)', 'flexi'),
      'avi' => __('Audio Video Interleave File (.avi)', 'flexi'),
      'mid' => __('MIDI File (.mid)', 'flexi'),
      'wav' => __('WAVE Audio File (.wav)', 'flexi'),
      'wma' => __('Windows Media Audio File (.wma)', 'flexi'),
     ),
    ),

   ),
   );

   //print_r($fields);
   $new = array_merge($new, $fields);
  }
  return $new;
 }

}

//Ultimate Member: Setting at Flexi & Tab at profile page
$mime = new Flexi_Addon_Mime_Type();
