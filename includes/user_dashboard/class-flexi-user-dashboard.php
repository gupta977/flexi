<?php
//User dashboard

class Flexi_User_Dashboard
{
 public function __construct()
 {
  add_shortcode('flexi-user-dashboard', array($this, 'flexi_user_dashboard'));
  add_filter("flexi_submit_toolbar", array($this, 'flexi_add_icon_submit_toolbar'), 10, 2);
  add_action('wp', array($this, 'enqueue_styles'));
 }

 public function flexi_user_dashboard()
 {
  ob_start();
  if (is_singular()) {
   if (is_user_logged_in()) {

    $current_user = wp_get_current_user();

    //var_dump($current_user);
    ?>

<div style="text-align:center;"><?php echo flexi_author($current_user->user_login); ?>

<form method="get" class="pure-form">
   <input type="text" name="search" placeholder="<?php echo __('Search post', 'flexi'); ?>" class="pure-input-rounded">
   <button type="submit" class="pure-button">Search</button>
 </form>
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

  $link = flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings');

  if ("#" != $link) {
   $extra_icon = array(
    array("dashicons-menu", __('My Dashboard', 'flexi'), $link, $id, 'pure-button'),

   );
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

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

}
$user_dashboard = new Flexi_User_Dashboard();
