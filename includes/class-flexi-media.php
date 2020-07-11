<?php
class Flexi_Media_Settings
{
 public function __construct()
 {
  add_action('after_setup_theme', array($this, 'custom_image'));
  //
 }

 /**
  * Set media settings
  *
  * @since  1.0.0
  */
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
}
