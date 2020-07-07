<?php
class Flexi_Post_Info
{
 public function __construct()
 {

 }

 //Return media path URL or Root
 public function media_path($post_id, $url = true)
 {
  $flexi_post = get_post($post_id);
  return flexi_file_src($flexi_post, $url);
 }

 //Returns based on available post_meta
 public function post_meta($post_id, $post_meta, $default)
 {
  if (isset(get_post_meta($post_id, $post_meta, $default)[0])) {
   return get_post_meta($post_id, $post_meta, $default)[0];
  } else {
   return '';
  }

 }

}
