<?php
class Flexi_admin_links
{
 public function __construct()
 {
  $prefix          = is_network_admin() ? 'network_admin_' : '';
  $plugin_basename = FLEXI_FOLDER . '/flexi.php';
  add_filter("{$prefix}plugin_action_links_" . $plugin_basename, array($this, 'plugin_links'));
  add_filter('plugin_row_meta', array($this, 'plugin_links_extra'), 10, 2);
 }

 //Add links to plugin list
 public function plugin_links($links)
 {

  $mylinks = array(
   '<a href="' . admin_url('admin.php?page=flexi_settings') . '">' . __("Settings", "flexi") . '</a>',
   '<a href="' . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . '">' . __('Start', 'flexi') . '</a>',
  );
  return array_merge($links, $mylinks);
 }

//Links at plugin list right side
 public function plugin_links_extra($links, $file)
 {
  if (FLEXI_FOLDER . '/flexi.php' !== $file) {
   return $links;
  }

  //    $more_links[] = '<a target="_blank" href="https://wordpress.org/support/plugin/wp-upg/reviews/?rate=5#new-post" title="' . __('Rate the plugin', 'wp-reset') . '">' . __('Rate the plugin', 'wp-upg') . ' ★★★★★</a>';
  $more_links[] = '<a href="https://odude.com/docs/flexi-gallery/" target="_blank">' . __('Docs & FAQs', 'flexi') . '</a>';
  //$more_links[] = '<a href="' . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . '">' . __('Post Files', 'flexi') . '</a>';
  $links = $more_links + $links;
  return $links;
 }

}
$links = new Flexi_admin_links();
