<?php
add_action("wp_ajax_flexi_ajax_post_view", "flexi_ajax_post_view");
add_action("wp_ajax_nopriv_flexi_ajax_post_view", "flexi_ajax_post_view");
function flexi_ajax_post_view()
{
 if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_popup")) {
  exit("No naughty business please");
 }

 if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $post = get_post($id);
  if (is_object($post)) {
   //var_dump($post);

   //Attach layout
   $layout      = "basic";
   $header_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/popup/' . $layout . '/content.php';
   if (file_exists($header_file)) {
    require $header_file;
   }

  }
 }
 die();

}
