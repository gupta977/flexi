<?php
class flexi_delete_post
{
//Process ajax form submitted by [flexi-form] shortcode
 public function __construct()
 {
  add_action("wp_ajax_flexi_ajax_delete", array($this, "flexi_ajax_delete"));
  add_action("wp_ajax_nopriv_flexi_ajax_delete", array($this, "flexi_my_must_login"));
  //Delete image attached when post is deleted
  add_action('before_delete_post', array($this, 'flexi_before_delete_post'));

 }
 public function flexi_ajax_delete()
 {
  if (!wp_verify_nonce($_REQUEST['nonce'], "flexi_ajax_delete")) {
   exit("No naughty business please");
  }
  $post_id = $_REQUEST["post_id"];

  $post_author_id = get_post_field('post_author', $post_id);

  if (get_current_user_id() == $post_author_id) {
   $this->flexi_delete_post_media($post_id);
   $data = wp_delete_post($post_id, true);
  } else {
   $data = false;
  }

  if (false === $data) {
   $result['type']       = "error";
   $result['data_count'] = "Fail";
  } else {
   $result['type']       = "success";
   $result['data_count'] = "Pass";
  }

  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
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

 public function flexi_delete_post_media($post_id)
 {

  if (!isset($post_id)) {
   return;
  }
  // Will die in case you run a function like this: delete_post_media($post_id); if you will remove this line - ALL ATTACHMENTS WHO HAS A PARENT WILL BE DELETED PERMANENTLY!
  elseif (0 == $post_id) {
   return;
  }
  // Will die in case you have 0 set. there's no page id called 0 :)
  elseif (is_array($post_id)) {
   return;
  }
  // Will die in case you place there an array of pages.

  else {

   $attachments = get_posts(array(
    'post_type'      => 'attachment',
    'posts_per_page' => -1,
    'post_status'    => 'any',
    'post_parent'    => $post_id,
   ));

   foreach ($attachments as $attachment) {
    if (false === wp_delete_attachment($attachment->ID)) {
     //flexi_log('Unable to delete image-' . $post_id);
    }
   }
  }
 }
 //Adds delete/trash icon in flexi icon container.
 public function flexi_add_icon_grid_delete($icon)
 {
  global $post;
  $delete_flexi_icon = flexi_get_option('delete_flexi_icon', 'flexi_icon_settings', 1);
  $nonce             = wp_create_nonce("flexi_ajax_delete");
  //$link  = admin_url('admin-ajax.php?action=flexi_ajax_delete&post_id=' . $post->ID . '&nonce=' . $nonce);

  $extra_icon = array();

  if (get_the_author_meta('ID') == get_current_user_id()) {
   // if (isset($options['show_trash_icon'])) {
   if ("1" == $delete_flexi_icon) {
    $extra_icon = array(
     array("dashicons-trash", __('Delete', 'flexi'), '#', 'flexi_ajax_delete', $post->ID),

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

 //Permanently delete media when post is deleted by administrator
 public function flexi_before_delete_post($post_id)
 {
  // We check if the global post type isn't ours and just return
  global $post_type;
  if ('flexi' != $post_type) {
   return;
  }
  $this->flexi_delete_post_media($post_id);

 }

}
