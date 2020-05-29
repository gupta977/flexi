<?php
//User dashboard

class Flexi_User_Dashboard
{
 public function __construct()
 {
  add_shortcode('flexi-user-dashboard', array($this, 'flexi_user_dashboard'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  add_filter("flexi_submit_toolbar", array($this, 'flexi_add_icon_submit_toolbar'), 10, 2);
  add_action('wp', array($this, 'enqueue_styles'));

  add_filter("flexi_member_toolbar", array($this, 'logout_button'), 10, 1);
  add_filter("flexi_member_toolbar", array($this, 'gallery_button'), 10, 1);
 }

 public function flexi_user_dashboard()
 {
  ob_start();
  if (is_singular()) {
   if (is_user_logged_in()) {

    $current_user = wp_get_current_user();
    ?>



<div class="flexi_text_group" style="text-align:right;">
  <?php echo $this->flexi_member_toolbar(); ?>
</div>

<div class="pure-g">
  <div class="pure-u-1-2">
  <?php echo flexi_author($current_user->user_login); ?>
   </div>
   <div class="pure-u-1-2" style="text-align:right;">
   <form method="get" class="pure-form">
    <input type="text" name="search" placeholder="<?php echo __('Search post', 'flexi'); ?>" class="pure-input-rounded">
    <button type="submit" class="pure-button">Search</button>
  </form>
</div>
</div>


<ul data-tabs>
  <li><a data-tabby-default href="#my_post"><?php echo __('My Posts', 'flexi'); ?></a></li>
</ul>

<div id="my_post">
  <?php do_action('flexi_user_dashboard');?>
</div>

<script>
  var tabs = new Tabby('[data-tabs]');
</script>

<?php

   } else {
    echo flexi_login_link();
   }
  }
  return ob_get_clean();
 }

 //Add My-Dashboard button after form submit
 public function flexi_add_icon_submit_toolbar($icon, $id = '')
 {

  $extra_icon = array();

  $link         = flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings');
  $enable_addon = flexi_get_option('enable_dashboard_button', 'flexi_icon_settings', 1);

  if ("#" != $link && "1" == $enable_addon) {
   $extra_icon = array(
    array("fa fa-tachometer", __('My Dashboard', 'flexi'), $link, $id, 'flexi_css_button'),

   );
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

 //Add button to enable user dashboard
 public function add_fields($new)
 {
  $fields = array('flexi_icon_settings' => array(

   array(
    'name'              => 'enable_dashboard_button',
    'label'             => __('"My Dashboard" button', 'flexi'),
    'description'       => __('Display button after form submission', 'flexi'),
    'type'              => 'checkbox',
    'sanitize_callback' => 'intval',
   ),

   array(
    'name'              => 'enable_mygallery_button',
    'label'             => __('"My Gallery" button', 'flexi'),
    'description'       => __('Display button at "My Dashboard"', 'flexi'),
    'type'              => 'checkbox',
    'sanitize_callback' => 'intval',
   ),

  ),
  );
  $new = array_merge_recursive($new, $fields);

  return $new;
 }

 //Styles only related to user dashboard
 public function enqueue_styles()
 {
  global $post;

  $my_gallery_id   = flexi_get_option('my_gallery', 'flexi_image_layout_settings', 0);
  $current_page_id = get_queried_object_id();

  if ($current_page_id == $my_gallery_id) {
   wp_register_style('flexi_tab_css', FLEXI_PLUGIN_URL . '/public/css/tabby-ui.css', null, FLEXI_VERSION);
   wp_enqueue_style('flexi_tab_css');
   wp_enqueue_script('flexi_tab_script', FLEXI_PLUGIN_URL . '/public/js/tabby.js', '', FLEXI_VERSION, false);
   wp_enqueue_script('flexi_tab_script');
  }
 }

 //button toolbar for user dashboard
 public function flexi_member_toolbar()
 {
  global $post;
  $icon = array();

  $list = '';

  if (has_filter('flexi_member_toolbar')) {
   $icon = apply_filters('flexi_member_toolbar', $icon);
  }

  if (count($icon) > 0) {
   $list .= '<div class="flexi_member_toolbar_group" role="toolbar" id="flexi_member_toolbar_' . get_the_ID() . '">';
  }

  for ($r = 0; $r < count($icon); $r++) {

   if ("" != $icon[$r][0]) {
    $list .= '<a href="' . $icon[$r][2] . '" class="' . $icon[$r][3] . '"><span class="' . $icon[$r][3] . '-icon"><i class="' . $icon[$r][0] . '  aria-hidden="true""></i></span><span class="' . $icon[$r][3] . '-text">' . $icon[$r][1] . '</span></a> ';
   }

  }
  if (count($icon) > 0) {
   $list .= '</div>';
  }
  return $list;
 }

 public function gallery_button($icon)
 {
  $enable_addon = flexi_get_option('enable_mygallery_button', 'flexi_icon_settings', 1);

  if ("1" == $enable_addon) {

   $extra_icon   = array();
   $link         = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
   $current_user = wp_get_current_user();

   $link = add_query_arg("flexi_user", $current_user->user_login, $link);

   $extra_icon = array(
    array('fa fa-file-image-o', __('My Gallery', 'flexi'), $link, 'flexi_css_button'),

   );

   // combine the two arrays
   if (is_array($extra_icon) && is_array($icon)) {
    $icon = array_merge($extra_icon, $icon);
   }
  }
  return $icon;
 }

 public function logout_button($icon)
 {
  $extra_icon = array();
  $link       = wp_logout_url(home_url());

  $extra_icon = array(
   array("fa fa-power-off", __('Logout', 'flexi'), $link, 'flexi_css_button'),

  );

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

}
$user_dashboard = new Flexi_User_Dashboard();