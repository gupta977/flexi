<?php
class flexi_download_post
{
//Process ajax form submitted by [flexi-form] shortcode
 public function __construct()
 {
  //add_action("wp_ajax_flexi_ajax_download", array($this, "flexi_ajax_download"));
  // add_action("wp_ajax_nopriv_flexi_ajax_download", array($this, "flexi_my_must_login"));

 }
 public function flexi_ajax_download()
 {
  if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_download")) {
   exit("No naughty business please");
  }
  $post_id = $_REQUEST["post_id"];

  $post_author_id = get_post_field('post_author', $post_id);

  if (get_current_user_id() == $post_author_id) {
   //check the user before proceed to download
   $data = true;
  } else {
   $data = false;
  }

  if (false === $data) {
   $result['type'] = "error";
  } else {
   $result['type'] = "success";
  }

  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

   //$file = "http://localhost/wp5/wp-content/uploads/2020/01/20200111_174431-scaled.jpg";
   $file = "E:\wamp64\www\wp5/wp-content/uploads/2020/05/SampleVideo_1280x720_1mb.mp4";
   if (file_exists($file)) {
    flexi_log("file found");
    // header('Content-Type: image/jpeg');
    //header("Content-Disposition: attachment; filename=\"$file\"");
    //readfile($file);
    //die();
   }

   $result = json_encode($result);
   echo $result;
  } else {
   header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

  die();
 }

//Used in ajax call, force users to login before any action.
 public function flexi_my_must_login()
 {
  echo __("Login Please !", "flexi");
  die();
 }

 //Adds download/trash icon in flexi icon container.
 public function flexi_add_icon_grid_download($icon)
 {
  global $post;
  $download_flexi_icon = flexi_get_option('download_flexi_icon', 'flexi_icon_settings', 1);
  $nonce               = wp_create_nonce("flexi_ajax_download");
  //$link  = admin_url('admin-ajax.php?action=flexi_ajax_download&post_id=' . $post->ID . '&nonce=' . $nonce);

  $extra_icon = array();

  if (flexi_get_type($post) != 'url') {
   // if (isset($options['show_trash_icon'])) {
   if ("1" == $download_flexi_icon) {
    $url        = flexi_file_src($post, $url = true);
    $extra_icon = array(
     array("fa fa-download", __('Download', 'flexi'), $url, $url, $post->ID, 'flexi_ajax_download flexi_css_button', 'download'),

    );
   }
   // }
  }

  // combine the two arrays
  if (is_array($extra_icon) && is_array($icon)) {
   $icon = array_merge($extra_icon, $icon);
  }

  return $icon;
 }

}
