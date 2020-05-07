<?php
class Flexi_Gallery_Toolbar
{
 //TOOLBAR PLACEHOLDER ABOVE GALLERY
 public function __construct()
 {

 }
 public function label()
 {
  //Display label at Main gallery page
  if (is_flexi_page('primary_page', 'flexi_image_layout_settings')) {

   //Show TAG Label
   $tag_slug = get_query_var('flexi_tag', "");
   $tag      = get_term_by('slug', $tag_slug, 'flexi_tag');

   if ("" != $tag_slug && true == $tag) {
    return '<div class="flexi_list_tags"><a class="flexi_tag flexi_tag-default">' . $tag->name . '</a></div>';
   }

   //Show Album Label
   //Get redirected sub album
   $term_slug = get_query_var('flexi_category');
   $term      = get_term_by('slug', $term_slug, 'flexi_category');

   if ("" != $term_slug && true == $term) {
    //return $term->name;
    return flexi_album_single($term_slug, 'flexi_user-list');
   }

   //Show User Name
   //Author
   $username = get_query_var('flexi_user');
   $user     = get_user_by('login', $username);
   if ("" != $username && $user) {

    //return $user->first_name . ' ' . $user->last_name;
    return flexi_author($username);
   }

  }

 }
}
