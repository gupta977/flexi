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
  //global $post;
  $post        = get_post($id);
  $layout      = "custom";
  $header_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/popup/' . $layout . '/content.php';
  $the_query   = new WP_Query(array('post_type' => 'flexi', 'p' => $id));

  // The Loop
  if ($the_query->have_posts()) {

   while ($the_query->have_posts()) {
    $the_query->the_post();
    if (file_exists($header_file)) {
     require $header_file;
    }
   }

  } else {
   echo '<div id="flexi_no_record" class="flexi_alert-box flexi_notice">' . __('No records', 'flexi') . '</div>';
  }
/* Restore original Post Data */
  wp_reset_postdata();
/*
if (is_object($post)) {
//var_dump($post);

//Attach layout

}
 */
 }
 die();

}
