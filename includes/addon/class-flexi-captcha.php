<?php
class Flexi_Addon_Captcha
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
  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $sections = array(
    array(
     'id'          => 'flexi_captcha_settings',
     'title'       => __('Google reCaptcha Settings', 'flexi'),
     'description' => __('Get API information from https://www.google.com/recaptcha. It will ask for security code during form submission if captcha field is added.', 'flexi'),
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
    'name'              => 'enable_captcha',
    'label'             => __('Enable Captcha', 'flexi'),
    'description'       => __('Security code during form submission. https://www.google.com/recaptcha', 'flexi') . ' <a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_captcha_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a>',
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
  $enable_addon = flexi_get_option('enable_captcha', 'flexi_extension', 0);
  if ("1" == $enable_addon) {
   $fields = array('flexi_captcha_settings' => array(

    array(
     'name'              => 'captcha_key',
     'label'             => __('Site key', 'flexi'),
     'description'       => __('Google Captcha Site Key.', 'flexi'),
     'type'              => 'text',
     'size'              => 'large',
     'sanitize_callback' => 'sanitize_key',
    ),
    array(
     'name'              => 'captcha_secret',
     'label'             => __('Secret Key', 'flexi'),
     'description'       => __('Google Captcha secret Key', 'flexi'),
     'type'              => 'text',
     'size'              => 'large',
     'sanitize_callback' => 'sanitize_key',
    ),
   ),
   );
   $new = array_merge($new, $fields);
  }
  return $new;
 }

}

//Ultimate Member: Setting at Flexi & Tab at profile page
$captcha = new Flexi_Addon_Captcha();
