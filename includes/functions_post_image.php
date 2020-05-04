<?php
//Submits new post.
//$title = Title of post
//$files = files selected
//$content= Description
//category =Album name
//$preview = layout name for post detail page. Not required if lightbox is enabled.
function flexi_submit($title, $files, $content, $category, $preview, $tags = '')
{

 $post_type    = 'flexi';
 $taxonomy     = 'flexi_category';
 $tag_taxonomy = 'flexi_tag';

 $newPost            = array('id' => false, 'error' => false, 'notice' => false);
 $newPost['error'][] = "";
 $file_count         = 0;
 if (empty($title)) {
  $newPost['error'][] = 'required-title';
 }

 //if (empty($content))  $newPost['error'][] = 'required-description';

 $newPost['error'][] = apply_filters('flexi_verify_submit', "");

 if (isset($files['tmp_name'][0])) {
  $check_file_exist = $files['tmp_name'][0];
 } else {
  $check_file_exist = "";
 }

 /*
 //It will only check file type is image
 if (!empty($check_file_exist)) {
 $file_data  = flexi_check_images($files, $newPost);
 $file_count = $file_data['file_count'];
 //flexi_log($file_data);
 $newPost['error'] = array_unique(array_merge($file_data['error'], $newPost['error']));
 }
  */

 $file_count = flexi_upload_get_file_count($files);

 foreach ($newPost['error'] as $e) {

  if (!empty($e)) {
   //flexi_log("Error: " . $e);
   unset($newPost['id']);
   return $newPost;
  }
 }

 $postData = flexi_prepare_post($title, $content, $post_type);
 do_action('flexi_insert_before', $postData);
 //Include important files required during upload
 flexi_include_deps();
 $i = 0;
 if (0 == $file_count) {
  //Execute loop at least once
  $file_count = 1;
 }

 for ($x = 1; $x <= $file_count; $x++) {
  //flexi_log("Loop: " . $x);
  $newPost['id'] = wp_insert_post($postData);
  if ($newPost['id']) {
   //echo "Successfully added $x <hr>";
   $post_id = $newPost['id'];

   //Submit extra fields data
   for ($z = 1; $z <= 10; $z++) {
    if (isset($_POST['flexi_field_' . $z])) {
     add_post_meta($post_id, 'flexi_field_' . $z, $_POST['flexi_field_' . $z]);
    }

   }
   //Ended to submit extra fields

   if ('' != $category) {
    wp_set_object_terms($post_id, array($category), $taxonomy);
   }

   if (taxonomy_exists($tag_taxonomy)) {
    //Set TAGS
    if ('' != $tags) {
     wp_set_object_terms($post_id, explode(",", $tags), $tag_taxonomy);
    }

   }

   //Assign preview layout
   add_post_meta($post_id, 'flexi_layout', $preview);
   add_post_meta($post_id, 'flexi_type', 'plain');
   $attach_ids = array();
   //Execute only if files is available
   if ($files && !empty($check_file_exist)) {
    $key = apply_filters('flexi_file_key', 'user-submitted-image-{$i}');

    $_FILES[$key]             = array();
    $_FILES[$key]['name']     = $files['name'][$i];
    $_FILES[$key]['tmp_name'] = $files['tmp_name'][$i];
    $_FILES[$key]['type']     = $files['type'][$i];
    $_FILES[$key]['error']    = $files['error'][$i];
    $_FILES[$key]['size']     = $files['size'][$i];

    $file_data = flexi_check_file($_FILES[$key]);
    // $newPost['error'] = array_unique(array_merge($file_data['error'], $newPost['error']));
    //flexi_log($i . "--");
    //flexi_log($file_data);

    $attach_id = media_handle_upload($key, $post_id);

    //$my_image_alt = preg_replace( ‘%[^0-9a-z]+%i’, ‘ ‘, $title );
    //$my_image_alt = preg_replace( ‘%[\s]+%’, ‘ ‘, $my_image_alt );
    //update_post_meta( $attach_id, '_wp_attachment_image_alt', $my_image_alt );
    //wp_attachment_is('image', $post)
    //if (!is_wp_error($attach_id) && wp_attachment_is_image($attach_id)) {

    if (!is_wp_error($attach_id) & ('' == trim($file_data['error'][0]))) {
     // flexi_log('OK File, start post');
     $attach_ids[] = $attach_id;
     add_post_meta($post_id, 'flexi_image_id', $attach_id);
     add_post_meta($post_id, 'flexi_image', flexi_image_src('large', get_post($post_id)));
     add_post_meta($post_id, 'flexi_type', 'image');
    } else {
     if ($attach_id) {
      // flexi_log('found error, deleting image');
      wp_delete_attachment($attach_id);
     }
     //flexi_log('delete post');
     wp_delete_post($post_id, true);
     $newPost['error'][]  = $file_data['error'][0];
     $newPost['notice'][] = $_FILES[$key]['name'];
     //flexi_log($file_data);
     //unset($newPost['id']);
     //return $newPost;
    }

    $i++;
   }

  } else {
   $newPost['error'][] = 'post-fail';
  }
 }
 //flexi_log('all finished');
 //flexi_log($newPost);
 do_action('flexi_insert_after', $newPost);
 return $newPost;
}

function flexi_upload_get_file_count($files)
{
 $temp = false;
 if (isset($files['tmp_name'])) {
  $temp = array_filter($files['tmp_name']);
 }

 $file_count = 0;
 if (!empty($temp)) {
  foreach ($temp as $key => $value) {
   if (is_uploaded_file($value)) {
    $file_count++;
   }
  }

 }
 return $file_count;

}

//Check the file before upload or processing
function flexi_check_file($files)
{
 //flexi_log($files);
 //flexi_log("------");

 $error              = array();
 $error[0]           = '';
 $notice             = array();
 $notice[0]          = '';
 $uploaded_file_type = $files['type'];
 $allowed_file_types = array('image/jpg', 'image/jpeg', 'application/pdf');
 if (in_array($uploaded_file_type, $allowed_file_types)) {
  $error[0]  = '';
  $notice[0] = '';
 } else {
  $error[0]  = 'file-type';
  $notice[0] = $files['name'] . ' invalid-file';
 }
 $file_data = array('error' => $error, 'notice' => $notice);
 //flexi_log("+++++++++++++");
 //flexi_log($file_data);
 return $file_data;

}

//During image upload process, it check the file is valid image type.
function flexi_check_images($files)
{
 $temp  = false;
 $errr  = false;
 $error = array();

 if (isset($files['tmp_name'])) {
  $temp = array_filter($files['tmp_name']);
 }

 if (isset($files['error'])) {
  $errr = array_filter($files['error']);
 }

 $file_count = 0;
 if (!empty($temp)) {
  foreach ($temp as $key => $value) {
   if (is_uploaded_file($value)) {
    $file_count++;
   }
  }

 }
 if (true) {

  $i = 0;
/*
$image = @getimagesize($temp[$i]);

if (false === $image) {
$error[] = 'file-type';
//error_log("Check file size");
//break;
} else {
if (function_exists('exif_imagetype')) {
if (isset($temp[$i]) && !exif_imagetype($temp[$i])) {
$error[] = 'exif_imagetype';
//break;
}
}

}*/

  //$file = wp_max_upload_size( $temp[$i] );
  // if ( $file['error'] != '0' )
  //{
  //if ($temp[$i] < wp_max_upload_size()) {
  // $error[] = 'max-filesize';
  // }

  //}

 } else {
  $files = false;
 }
 $file_data = array('error' => $error, 'file_count' => $file_count);

 //error_log("file count ".$file_count);

 return $file_data;
}

//Before posting, assigning required metadata to the post.
function flexi_prepare_post($title, $content, $post_type = 'flexi')
{
 $postData                 = array();
 $postData['post_title']   = $title;
 $postData['post_content'] = $content;
 $postData['post_author']  = flexi_get_author();
 $postData['post_type']    = 'flexi';

 //upg_log($content."---".$post_type);

 if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {
  $postData['post_status'] = 'publish';
 }

 return apply_filters('flexi_post_data', $postData);
}

//Including the files used during the time of file upload. It is required to get default wordpress file handling.
function flexi_include_deps()
{
 if (!function_exists('media_handle_upload')) {
  require_once ABSPATH . '/wp-admin/includes/media.php';
  require_once ABSPATH . '/wp-admin/includes/file.php';
  require_once ABSPATH . '/wp-admin/includes/image.php';
 }
}
