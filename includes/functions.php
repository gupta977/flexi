<?php
//Functions used during submission of image only
require_once plugin_dir_path(__FILE__) . 'functions_post_image.php';
//Functions used during submission of URL only
require_once plugin_dir_path(__FILE__) . 'functions_post_url.php';

//Gets link of post author with it's avatar icon.
function flexi_author($author = '', $redirect = true)
{
 if ('' == $author) {
  $author = get_user_by('id', get_the_author_meta('ID'));
 } else {
  $author = get_user_by('slug', $author);
 }

 if (flexi_get_option('primary_page', 'flexi_image_layout_settings', 0) != '0') {
  if (flexi_get_option('enable_ultimate_member', 'flexi_extension', 0) == '1' && function_exists('um_user_profile_url') && $redirect) {
   $linku = um_user_profile_url($author->ID);
   $linku = esc_url(add_query_arg('profiletab', 'flexi', $linku));
  } else if (flexi_get_option('enable_buddypress', 'flexi_extension', 0) == '1' && function_exists('bp_core_get_user_domain') && $redirect) {
   $linku = bp_core_get_user_domain($author->ID) . "flexi";
  } else {
   $linku = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
   $linku = add_query_arg("flexi_user", $author->user_nicename, $linku);
  }
 } else {
  $linku = "";
 }
 return '<ul class="flexi_user-list"><li>
 <div class="user-avatar">
 <a href="' . $linku . '"><img src="' . get_avatar_url($author->user_email, $size = '50') . '" width="50" alt="' . $author->display_name . '" /></a>
 </div>
 <p class="user-name"><a href="' . $linku . '">' . $author->first_name . ' ' . $author->last_name . '</a><span>@' . $author->user_login . '</span></p>
 </li></ul>';
/*
return ' <a href="' . $linku . '" title=' . $author->display_name . '><h2 class="ui header">
<img src="' . get_avatar_url($author->user_email, $size = '50') . '" class="ui circular image">
' . $author->first_name . ' ' . $author->last_name . '</h2></a>';*/
}

//Custom field get id
function flexi_custom_field_value($post_id, $field_name)
{
 $value = get_post_meta($post_id, $field_name, '');
 if (is_array($value)) {
  if (isset($value[0]) && '' != $value[0]) {
   return $value[0];
  }
 } else {
  return '';
 }
}
//Get attachment detail
function flexi_get_attachment($attachment_id)
{
 $attachment = get_post($attachment_id);
 return array(
  'alt'         => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
  'caption'     => $attachment->post_excerpt,
  'description' => $attachment->post_content,
  'href'        => get_permalink($attachment->ID),
  'src'         => $attachment->guid,
  'title'       => $attachment->post_title,
 );
}

/**
 * Sample template tag function for outputting a cmb2 file_list
 *
 * @param  string  $post_id
 * @param  string  $img_size           Size of image to show
 */
function flexi_standalone_gallery($post_id, $img_size = 'thumbnail', $width = 150, $height = 150)
{
 echo '<style>
.flexi-image-wrapper-icon {
    width: ' . $width . 'px;
    height: ' . $height . 'px;
    border: 1px solid #eee;
  }
  .flexi-image-wrapper-icon img {
    object-fit: cover;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
  }
  </style>
';
 // Get the list of files
 $files = get_post_meta($post_id, 'flexi_standalone_gallery', 1);
 echo '';
 // Loop through them and output an image
 if (!empty($files)) {
  foreach ((array) $files as $attachment_id => $attachment_url) {

   $image_alt = flexi_get_attachment($attachment_id);

   echo '<div class="flexi_responsive_fixed"><div class="flexi_gallery_grid"><div class="flexi-image-wrapper-icon"><a data-fancybox="flexi_standalone_gallery" href="' . wp_get_attachment_image_src($attachment_id, 'flexi_large')[0] . '" data-caption="' . $image_alt['title'] . '" border="0">';
   echo '<img src="' . wp_get_attachment_image_src($attachment_id, $img_size)[0] . '" large-src="' . wp_get_attachment_image_src($attachment_id, 'flexi_large')[0] . '">';
   echo '</a></div></div></div>';

  }
 }
 echo '';
}

//Custom Fields
function flexi_custom_field_loop($post, $page = 'detail', $count = 10, $css = true)
{
 $group = '';

 if ($css) {
  $group .= '<ul class="flexi_list">';
 }

 $c = 1;
 for ($x = 1; $x <= 10; $x++) {
  $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
  $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
  $value   = get_post_meta($post->ID, 'flexi_field_' . $x, '');

  if (!$value) {
   $value[0] = '';
  }
  if (is_array($display)) {
   if (in_array($page, $display)) {
    if ('' != $value[0]) {
     if ($css) {
      $group .= '<li><label>' . $label . '<span class="dashicons dashicons-arrow-right"></span></label><span>' . $value[0] . '</span></li>';
     } else {
      $group .= $label . ': ' . $value[0];
     }

     if ($count == $c) {
      break;
     }
     $c++;
    }

   }
  }
 }
 if ($css) {
  $group .= "</ul>";
 }

 return $group;
}

//Page Number
//flexi-pagination is same as woocommerce-pagination css
function flexi_page_navi($query, $class = "flexi-pagination")
{
 $big   = 999999999; // need an unlikely integer
 $pages = paginate_links(array(
  'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
  'format'  => '?paged=%#%',
  'current' => max(1, get_query_var('paged')),
  'total'   => $query->max_num_pages,
  'type'    => 'array', //default it will return anchor
 ));

 $pager = '';
 if ($pages) {
  $pager .= '<nav class="' . $class . '"><ul class="page-numbers">';
  foreach ($pages as $page) {
   $pager .= "<li>$page</li>";
  }
  $pager .= '</ul></nav>';
 }
 return $pager;
}

//Check if user have editing rights
function flexi_check_rights($post_id = 0)
{
 $edit_post = true;
 if (is_user_logged_in()) {

  $post_author_id = get_post_field('post_author', $post_id);
  if (get_current_user_id() == $post_author_id) {
   $edit_post = true;
  } else {
   $edit_post = false;
  }
 } else {
  $edit_post = false;
 }

 //Check if page is edit page to prevent from spam
 if (!is_flexi_page('edit_flexi_page', 'flexi_form_settings')) {
  $edit_post = false;
 }

 return $edit_post;
}
//Return album name with and without link
function flexi_get_album($post_id, $type)
{
 //$type values can be term_id,slug,name,url
 $categories = get_the_terms($post_id, 'flexi_category');
 foreach ((array) $categories as $category) {
  if ('url' == $type) {
   return flexi_get_category_page_link($category, 'flexi_category');
  } else {
   if (isset($category->$type)) {
    return $category->$type;
   } else {
    return '';
   }

  }
 }
}

//returns album/category url. 'flexi_category' is $taxonomy. $term is a album slug name.
function flexi_get_category_page_link($term, $taxonomy)
{

 $link = '/';

 if (flexi_get_option('primary_page', 'flexi_image_layout_settings', 0) > 0) {
  $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
  $link = add_query_arg($taxonomy, $term->slug, $link);

 }

 return $link;
}

//Get details of post based on post_id
function flexi_get_detail($post_id, $field)
{
 $post = get_post($post_id);
 if ($post) {
  return $post->$field;
 } else {
  return '';
 }
}

//display taxonomy terms without links: separated with commas
function flexi_get_taxonomy_raw($post_id, $taxonomy_name)
{
 $terms = wp_get_post_terms($post_id, $taxonomy_name);
 $count = count($terms);
 $data  = '';
 if ($count > 0) {
  foreach ($terms as $term) {
   $data .= $term->slug . ",";
  }
 }
 return rtrim($data, ',') . ',';
}

//Generate gallery_tags link
function flexi_generate_tags($tags_array, $upg_tag_class = 'flexi_tag', $filter_class = 'filter_tag')
{
 $taglink = '';
 if (count($tags_array) > 1) {
  $taglink .= '<div class="flexi_tags" style="margin: 5px">';

  $taglink .= '<a href="javascript:void(0)" id="show_all" class="' . $filter_class . ' ' . $upg_tag_class . ' flexi_tag_active">' . __('Show All', 'wp-upg') . '</a> ';
  if (count($tags_array) > 1) {
   foreach ($tags_array as $tags => $value) {
    $taglink .= '<a href="javascript:void(0)" id="' . $tags . '" class="' . $filter_class . ' ' . $upg_tag_class . ' ">' . $value . '</a> ';
   }
  }

  $taglink .= '</div>';
 }

 return $taglink;
}

//Flexi List TAGs
function flexi_list_tags($post, $class = "flexi_tag flexi_tag-default")
{
 //Returns All Term Items for "my_taxonomy"
 $term_list = wp_get_post_terms($post->ID, 'flexi_tag', array("fields" => "all"));
 //var_dump($term_list);

 if (count($term_list) > 0) {
  echo '<div class="flexi_list_tags">';
 }

 for ($x = 0; $x < count($term_list); $x++) {

  $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
  $link = add_query_arg("flexi_tag", $term_list[$x]->slug, $link);

  echo '<a href="' . $link . '" class="' . $class . '">' . $term_list[$x]->name . '</a>';
 }

 if (count($term_list) > 0) {
  echo '</div>';
 }

}
//Flexi List TAGs
function flexi_list_album($post, $class = "flexi-icon-list-frame")
{
 //Returns All Term Items for "my_taxonomy"
 $term_list = wp_get_post_terms($post->ID, 'flexi_category', array("fields" => "all"));
 //var_dump($term_list);

 if (count($term_list) > 0) {
  echo '<ul class="' . $class . '">';
 }

 for ($x = 0; $x < count($term_list); $x++) {
  if ('-1' != $term_list[$x]->name) {
   $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
   $link = add_query_arg("flexi_category", $term_list[$x]->slug, $link);

   echo '

<li>

    <div class="user-avatar">
        <a href="' . $link . '">
            <img src="' . flexi_album_image($term_list[$x]->slug) . '" width="75" alt="' . $term_list[$x]->name . '" />
        </a>
    </div>

    <p class="user-name">
        <a href="' . $link . '">' . $term_list[$x]->name . '</a>
        <span>' . $term_list[$x]->description . '</span>
    </p>
    </li>
';

   //echo '<a href="' . $link . '" class="' . $class . '">' . $term_list[$x]->name . '</a>';
   /*
  echo ' <div class="item">
  <img class="' . $class . '" src="' . flexi_album_image($term_list[$x]->slug) . '">
  <div class="content">
  <a href="' . $link . '" class="header"> ' . $term_list[$x]->name . '</a>
  ' . $term_list[$x]->description . '
  </div>
  </div>';
   */
  }
 }

 if (count($term_list) > 0) {
  echo '</ul>';
 }

}

//Get single album with title
function flexi_album_single($term_slug, $class = 'flexi_user-list')
{
 $term = get_term_by('slug', $term_slug, 'flexi_category');
 if ($term) {
  $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
  $link = add_query_arg("flexi_category", $term->slug, $link);

  /*
  return '<a href="' . $link . '" class="' . $class . '">
  <img src="' . flexi_album_image($term_slug) . '">
  ' . $term->name . '<div class="detail">' . __('Album', 'flexi') . '</div>
  </a>';
   */
  return '<ul class="' . $class . '"><li>
      <div class="user-avatar">
      <a href="' . $link . '"><img src="' . flexi_album_image($term_slug) . '" width="50" alt="' . $term->name . '" /></a>
      </div>
      <p class="user-name"><a href="' . $link . '">' . $term->name . '</a><span>' . __('Album', 'flexi') . '</span></p>
      </li></ul>';

 } else {
  return "";
 }
}

//Get album image
function flexi_album_image($term_slug)
{
 $cate_thumb_pic = plugins_url('../public/images/noimg_thumb.jpg', __FILE__);

 $term = get_term_by('slug', $term_slug, 'flexi_category');
 if ("" != $term_slug && true == $term) {

  $cate_thumb_pic = get_term_meta($term->term_id, 'flexi_image_category', true);
  if (!$cate_thumb_pic) {
   $cate_thumb_pic = plugins_url('../public/images/noimg_thumb.jpg', __FILE__);
  }

 }
 return $cate_thumb_pic;
}

//Layout List select box
//parameters 'selected layout',"input field name","form | media | grid",'show eye icon true | false'
function flexi_layout_list($args = '')
{
 $defaults = array(
  'folder'      => 'detail',
  'name'        => 'layout_name',
  'id'          => '',
  'class'       => '',
  'value_field' => 'ID',
 );

 $parsed_args = wp_parse_args($args, $defaults);

 $output = '';
 // Back-compat with old system where both id and name were based on $name argument
 if (empty($parsed_args['id'])) {
  $parsed_args['id'] = $parsed_args['name'];
 }

 $output   = "<select name='" . esc_attr($parsed_args['name']) . "' id='" . esc_attr($parsed_args['id']) . "'>\n";
 $value    = $args['selected'];
 $dir      = FLEXI_BASE_DIR . 'public/partials/layout/' . $parsed_args['folder'] . '/';
 $filelist = "";
 $files    = array_map("htmlspecialchars", scandir($dir));
 //echo $dir;
 foreach ($files as $file) {
  if (!strpos($file, '.') && "." != $file && ".." != $file) {
   $output .= sprintf('<option value="%s" %s >%s layout</option>' . PHP_EOL, $file, selected($value, $file, false), $file);
  }
 }

 $output .= "</select>\n";

 return $output;
}

//Displays login link
function flexi_login_link()
{
 $login = flexi_get_option('my_login', 'flexi_general_settings', '0');

 if ('0' != $login) {
  $linku = get_permalink($login);
  echo "<a href='" . $linku . "' class='button'>" . __("Login Please !", "flexi") . "</a>";
 } else {
  echo __("Login Please !", "flexi");
 }
}

//Get post button link
function flexi_get_button_url($param = '', $ajax = true, $type = 'submission_form', $setting_tab = 'flexi_form_settings')
{
 if ($ajax) {
  $url = '#admin-ajax.php?action=flexi_send_again&post_id=' . $param;
 } else {
  $default_post = flexi_get_option($type, $setting_tab, '0');

  if ('0' != $default_post && '-1' != $default_post) {
   if ('' == $param) {
    $url = esc_url(get_page_link($default_post));
   } else {
    $url = esc_url(add_query_arg('id', $param, get_page_link($default_post)));
   }

  } else {
   $url = "#";
  }

 }
 return $url;

}

//Default reference replaced by settings and attributes
function flexi_default_args($params)
{
 $value = array(
  'class'         => 'pure-form pure-form-stacked',
  'title'         => 'Submit',
  'preview'       => 'default',
  'name'          => '',
  'id'            => get_the_ID(),
  'taxonomy'      => 'flexi_category',
  'tag_taxonomy'  => 'flexi_tag',
  'upload_type'   => 'flexi',
  'ajax'          => 'true',
  'media_private' => 'false',
  'edit'          => 'false',
  'type'          => 'image',
 );
 if (isset($_POST['user-submitted-title'])) {
  $value['user-submitted-title'] = sanitize_text_field($_POST['user-submitted-title']);
 } else {
  $value['user-submitted-title'] = '';
 }

 if (isset($_POST['user-submitted-url'])) {
  $value['user-submitted-url'] = sanitize_text_field($_POST['user-submitted-url']);
 } else {
  $value['user-submitted-url'] = '';
 }

 if (isset($_POST['user-submitted-content'])) {
  $content          = flexi_sanitize_content($_POST['user-submitted-content']);
  $content          = str_replace("[", "[[", $content);
  $content          = str_replace("]", "]]", $content);
  $value['content'] = $content;
 } else {
  $value['content'] = "";
 }

 if (isset($_POST['cat'])) {
  $value['category'] = intval($_POST['cat']);
 } else {
  $value['category'] = flexi_get_option('global_album', 'flexi_categories_settings', '');
 }

 if (isset($_POST['tags'])) {
  $value['tags'] = $_POST['tags'];
 } else {
  $value['tags'] = '';
 }

 if (isset($_POST['edit'])) {
  $value['edit'] = $_POST['edit'];
 }

 if (isset($_POST['type'])) {
  $value['type'] = $_POST['type'];
 }

 if (isset($_POST['flexi_id'])) {
  $value['flexi_id'] = $_POST['flexi_id'];
 } else {
  $value['flexi_id'] = '0';
 }

 return shortcode_atts($value, $params);
}

//Update/edit the post with reference of post ID
function flexi_update_post($post_id, $title, $files, $content, $category, $tags = '')
{

 $updatePost['error'][] = array('id' => false, 'error' => false);
 $updatePost['error'][] = "";

 if (empty($title)) {
  $updatePost['error'][] = 'required-title';
 }

 $updatePost['error'][] = apply_filters('flexi_verify_submit', "");
 $file_count            = 0;

 if (flexi_get_option('publish', 'flexi_form_settings', 1) == 1) {
  $new_post = array(
   'ID'           => $post_id,
   'post_title'   => $title,
   'post_content' => $content,
   'post_status'  => 'publish',
  );
 } else {
  $new_post = array(
   'ID'           => $post_id,
   'post_title'   => $title,
   'post_content' => $content,
   'post_status'  => 'draft',
  );
 }

 // Update the post into the database
 $pid = wp_update_post($new_post);
 if (is_wp_error($pid)) {
  return false;
 } else {
  //Update post meta fields
  for ($x = 1; $x <= 10; $x++) {
   if (isset($_POST["flexi_field_" . $x])) {
    update_post_meta($post_id, "flexi_field_" . $x, sanitize_text_field($_POST["flexi_field_" . $x]));
   } else {
    update_post_meta($post_id, "flexi_field_" . $x, '');
   }
  }

  //Set category
  if ('' != $category) {
   wp_set_object_terms($post_id, array($category), 'flexi_category');
  }

  //Set TAGS
  //if($tags!='')
  wp_set_object_terms($post_id, explode(",", $tags), 'flexi_tag');
  //flexi_log($tags . "---");

  foreach ($updatePost['error'] as $e) {
   if (!empty($e)) {
    unset($updatePost['id']);

   }
  }

  return $updatePost;
 }
}

//Sanitize the $content.
function flexi_sanitize_content($content)
{
 $allowed_tags = wp_kses_allowed_html('post');
 return wp_kses(stripslashes($content), $allowed_tags);
}

//Required Flexi-PRO
function flexi_pro_required()
{
 return "<div class='flexi_alert-box flexi_warning'>" . __('Required Flexi-PRO or UPG-PRO', 'flexi') . "</div>";
}

//Return array of hidden category
function flexi_hidden_album()
{
 //if ( get_post_meta( term_id, 'flexi_show_cate', 1 ) )
 $skip       = array();
 $categories = get_categories(array('taxonomy' => 'flexi_category', 'hide_empty' => 0));

 foreach ($categories as $category) {
  $flexi_hide_cate = get_term_meta($category->term_id, 'flexi_hide_cate', true);
  if ("on" == $flexi_hide_cate) {
   array_push($skip, $category->term_id);

  }
 }
 return $skip;

}

//Drop down list of albums
function flexi_droplist_album($taxonomy = 'flexi_category', $selected_album = "", $skip = array(), $parent = '')
{

 if (empty($skip)) {
  $skip = flexi_hidden_album();
 }

 if (0 == $parent) {
  $parent = '';
 }

 $dropdown_args = array(

  'selected'          => $selected_album,
  'name'              => 'cat',
  'id'                => '',
  'echo'              => 1,
  'orderby'           => 'name',
  'order'             => 'ASC',
  'show_count'        => 0,
  'hierarchical'      => 1,
  'taxonomy'          => $taxonomy,
  'value_field'       => 'term_id',
  'hide_empty'        => 0,
  'exclude'           => $skip,
  'child_of'          => $parent,
  'show_option_none'  => '-- ' . __('None', 'flexi') . ' --',
  'option_none_value' => -1,
 );

 wp_dropdown_categories($dropdown_args);

 //var_dump($dropdown_args);

}

//log_me('This is a message for debugging purposes. works if debug is enabled.');
function flexi_log($message)
{
 if (WP_DEBUG === true) {
  if (is_array($message) || is_object($message)) {
   error_log(print_r($message, true));
  } else {
   error_log($message);
  }
 }
}

//get URL of physical file
function flexi_file_src($post_id)
{
 return wp_get_attachment_image_src(get_post_meta($post_id, 'flexi_file_id', 1));

}

//
// All commonly used function are listed
//
//Return image url
function flexi_image_src($size = 'thumbnail', $post)
{
 $image_attributes = wp_get_attachment_image_src(get_post_meta($post->ID, 'flexi_image_id', 1), $size);
 $ftype            = flexi_get_type($post);

 if ($image_attributes) {
  return $image_attributes[0];
 } else {
  //If no image ID found, check if it has direct URL for thumbnail & large size for video URL
  //Use flexi_large_media() at detail page

  if ('large' == $size) {
   $thumb_url = get_post_meta($post->ID, 'flexi_url', '');
  } else {
   $thumb_url = get_post_meta($post->ID, 'flexi_image', '');
  }
  if (!empty($thumb_url)) {
   return $thumb_url[0];
  } else {

   return FLEXI_ROOT_URL . 'public/images/' . $ftype . '.png';
  }
 }
}

/**
 * Get mime type icon URL based on file extension.
 *
 * @param $file_ext The file extension to get the icon for.
 * @return string Icon URL.
 */
function flexi_get_icon_by_file_extension($file)
{
 $filetype = wp_check_filetype($file);
 $file_ext = $filetype['ext'];

 $mimes = get_allowed_mime_types();
 if (!empty($mimes)) {
  foreach ($mimes as $type => $mime) {
   if (false !== strpos($type, $file_ext)) {
    return wp_mime_type_icon($mime);
   }
  }
 }
}

//Return the type of flexi post is image,video,audio,url,other
function flexi_get_type($post)
{
 $flexi_type = get_post_meta($post->ID, 'flexi_type', '');
 if (isset($flexi_type[0])) {
  return $flexi_type[0];
 } else {
  return '';
 }
}

function flexi_large_media($post_id, $class = 'flexi_large_image')
{
 $post      = get_post($post_id);
 $media_url = esc_url(flexi_image_src('large', $post));
 if ($post) {
  $flexi_type = get_post_meta($post->ID, 'flexi_type', '');
  if (isset($flexi_type[0]) && 'url' == $flexi_type[0]) {
   $attr = array(
    'src' => $media_url,

   );

   //echo wp_video_shortcode( $attr );
   return wp_oembed_get($attr['src']);

   return "<img id='" . $class . "' src='" . $media_url . "' >";
  } else {
   return "<img id='" . $class . "' src='" . $media_url . "' >";
  }
 }

}

//Returns author ID of logged in user. If not returns the id of default user in UPG settings.
function flexi_get_author()
{
 if (is_user_logged_in()) {
  $author_id = get_current_user_id();
 } else {
  $the_user = get_user_by('login', flexi_get_option('default_user', 'flexi_form_settings', '0'));
  if (!empty($the_user)) {
   $author_id = $the_user->ID;
  } else {
   $author_id = 0;
  }
 }

 return $author_id;
}

//Check if current page equals to selected page
function is_flexi_page($field_name, $section_name)
{
 //$current_page_id = get_the_ID();
 $current_page_id = get_queried_object_id();
 $test_page_id    = flexi_get_option($field_name, $section_name, 0);

 if ($current_page_id == $test_page_id) {
  return true;
 }
 return false;
}

//Check If Flexi-PRO
function is_flexi_pro()
{
 include_once ABSPATH . 'wp-admin/includes/plugin.php';
 $a = get_option('FLEXI_PRO', 'FAIL');
 if (is_plugin_active('flexi-pro/flexi-pro.php' && 'FAIL' != $a) && defined('FLEXI_PRO_VERSION')) {
  return true;
 } else {
  return false;
 }
}

//Get link and added attributes of the image based on lightbox
function flexi_image_data($size = 'full', $post = '', $popup = "on")
{
 //flexi_log($popup);
 if ("on" == $popup || '1' == $popup) {
  $popup    = 1;
  $lightbox = true;
 } else {
  $popup    = 0;
  $lightbox = false;
 }

 $data          = array();
 $data['title'] = get_the_title();

 if ('' == $post) {
  global $post;
 }

 if ($lightbox) {
  $data['url']   = flexi_image_src('large', $post);
  $data['extra'] = 'data-fancybox-trigger';
  $data['popup'] = 'flexi_show_popup';
 } else {
  $data['url']   = get_permalink();
  $data['extra'] = '';
  $data['popup'] = 'flexi_media_holder';
 }
 return $data;
}
/**
 * Get default plugin settings.
 *
 * @since  1.0.0
 * @return array $defaults Array of plugin settings.
 */
function flexi_get_default_settings()
{

 //Lightbox Enabled
 //flexi_set_option('lightbox_switch', 'flexi_detail_settings', 1);
 return;
}

/**
 * Get the value of a settings field
 *
 * @param string $field_name settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function flexi_get_option($field_name, $section = 'flexi_detail_settings', $default = '')
{
 //Example
 //flexi_get_option('field_name', 'setting_name', 'default_value');

 $options = (array) get_option($section);

 if (isset($options[$field_name])) {
  return $options[$field_name];
 } else {
  //Set the default value if not found
  flexi_set_option($field_name, $section, $default);

 }

 return $default;
}

//Set options in settings
function flexi_set_option($field_name, $section = 'flexi_general_settings', $default = '')
{
//Example
 //flexi_set_option('field_name', 'setting_name', 'default_value');
 $options              = (array) get_option($section);
 $options[$field_name] = $default;
 update_option($section, $options);

 return;
}

//Create required pages
function flexi_create_pages()
{
 global $wpdb;

 //Set defualt image sizes
 flexi_set_option('t_width', 'flexi_media_settings', 150);
 flexi_set_option('t_height', 'flexi_media_settings', 150);
 flexi_set_option('m_width', 'flexi_media_settings', 300);
 flexi_set_option('m_height', 'flexi_media_settings', 300);
 flexi_set_option('l_width', 'flexi_media_settings', 600);
 flexi_set_option('l_height', 'flexi_media_settings', 400);

 if (!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[flexi-gallery]%'")) {

  $aid = wp_insert_post(array('post_title' => 'Primary Gallery', 'post_content' => '<!-- wp:shortcode -->[flexi-primary]<!-- /wp:shortcode -->', 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('primary_page', 'flexi_image_layout_settings', $aid);

  $str_post_image = '
        <!-- wp:shortcode -->
		[flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]
		[flexi-form-tag type="post_title" title="Title" value="" placeholder="main title"]
		[flexi-form-tag type="category" title="Select category"]
		[flexi-form-tag type="tag" title="Insert tag"]
		[flexi-form-tag type="article" title="Description"  placeholder="Content"]
		[flexi-form-tag type="file" title="Select file"]
		[flexi-form-tag type="submit" name="submit" value="Submit Now"]
        [/flexi-form]
        <!-- /wp:shortcode -->
		';

  $bid = wp_insert_post(array('post_title' => 'Post Image', 'post_content' => $str_post_image, 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('submission_form', 'flexi_form_settings', $bid);

  $did = wp_insert_post(array('post_title' => 'User Dashboard', 'post_content' => '   <!-- wp:shortcode -->[flexi-user-dashboard]<!-- /wp:shortcode -->', 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('my_gallery', 'flexi_image_layout_settings', $did);

  $str_edit_image = '
  <!-- wp:shortcode -->
  [flexi-form class="pure-form pure-form-stacked" title="Update Flexi" name="my_form" ajax="true" edit="true"]
  [flexi-form-tag type="post_title" title="Title" placeholder="main title" edit="true" ]
  [flexi-form-tag type="category" title="Select category" edit="true"]
  [flexi-form-tag type="tag" title="Insert tag" edit="true"]
  [flexi-form-tag type="article" title="Description" placeholder="Content" edit="true"]
  [flexi-form-tag type="submit" name="submit" value="Update Now"]
  [/flexi-form]
  <!-- /wp:shortcode -->
		';

  $eid = wp_insert_post(array('post_title' => 'Edit Flexi Post', 'post_content' => $str_edit_image, 'post_type' => 'page', 'post_status' => 'publish'));
  flexi_set_option('edit_flexi_page', 'flexi_form_settings', $eid);

 }

}

// Flexi Excerpt Function ;)
function flexi_excerpt($limit = null, $separator = null)
{

 // Set standard words limit
 if (is_null($limit)) {
  $limit   = $gallery_layout   = flexi_get_option('excerpt_length', 'flexi_gallery_appearance_settings', '5');
  $excerpt = explode(' ', get_the_excerpt(), $limit);
 } else {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
 }

 // Set standard separator
 if (is_null($separator)) {
  $separator = ' ...';
 }

 // Excerpt Generator
 if (count($excerpt) >= $limit) {
  array_pop($excerpt);
  $excerpt = implode(" ", $excerpt) . $separator;
 } else {
  $excerpt = implode(" ", $excerpt);
 }
 $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
 return $excerpt;
}

//Icon container. Eg. Author icon, Delete icon, Edit icon
function flexi_show_icon_grid()
{
 global $post;
 $icon = array();

 $list = '';

 if (has_filter('flexi_add_icon_grid')) {
  $icon = apply_filters('flexi_add_icon_grid', $icon);
 }

 if (count($icon) > 0) {
  $list .= '<div class="flexi_icon_grid_group" id="flexi_' . get_the_ID() . '">';
 }

 for ($r = 0; $r < count($icon); $r++) {
  $nonce = wp_create_nonce($icon[$r][3]);

  if ("" != $icon[$r][0]) {
   $list .= '<a class="' . $icon[$r][3] . '" href="' . $icon[$r][2] . '" title="' . $icon[$r][1] . '" data-nonce="' . $nonce . '" data-post_id="' . $icon[$r][4] . '"><small>&nbsp;<span class="dashicons ' . $icon[$r][0] . '">&nbsp;</span>&nbsp;</small></a>';
  }

 }
 if (count($icon) > 0) {
  $list .= '</div>';
 }
 return $list;
}

//Icon container. Eg. Author icon, Delete icon, Edit icon
function flexi_post_toolbar_grid($id, $bool)
{
 global $post;
 $icon = array();

 $list = '';

 if (has_filter('flexi_submit_toolbar')) {
  $icon = apply_filters('flexi_submit_toolbar', $icon, $id, $bool);
 }

 if (count($icon) > 0) {
  $list .= '<div class="pure-button-group" role="toolbar" id="flexi_toolbar_' . get_the_ID() . '">';
 }

 for ($r = 0; $r < count($icon); $r++) {

  if ("" != $icon[$r][0]) {
   $list .= '<a href="' . $icon[$r][2] . '" class="' . $icon[$r][4] . '"><span class="dashicons ' . $icon[$r][0] . '"></span> ' . $icon[$r][1] . '</a>';
  }

 }
 if (count($icon) > 0) {
  $list .= '</div>';
 }
 return $list;
}

//Error Code
function flexi_error_code($err)
{
 $msg = "";
 if ('required-title' == $err) {
  $msg .= __("Title cannot be blank.", "flexi");

 } else if ('file-type' == $err) {
  $msg .= __("Invalid file type", "flexi");

 } else if ('exif_imagetype' == $err) {
  $msg .= __("Only image files are allowed.", "flexi");

 } else if ('invalid-captcha' == $err) {
  $msg .= __("Captcha security code is invalid.", "flexi");

 } else {
  $msg .= $err;
 }
 //$msg .= "</div>" . flexi_post_toolbar_grid('', true);
 //$msg .= "</div>";
 return $msg;
}
/**
 * Adding your own post state (label)
 * Example: Checking if this is a Product and if it's on Sale
 *          Show the users all WC products on sale
 *
 * @param array   $states Array of all registered states.
 * @param WP_Post $post   Post object that we can use.
 */
function flexi_page_post_state_label($states, $post)
{

 $primary_page = flexi_get_option('primary_page', 'flexi_image_layout_settings', 0);
 if (0 != $primary_page) {
  if ($primary_page == $post->ID) {
   $states['flexi-primary'] = __('Flexi Primary Gallery', 'flexi');
  }
 }

 $my_gallery = flexi_get_option('my_gallery', 'flexi_image_layout_settings', 0);
 if (0 != $my_gallery) {
  if ($my_gallery == $post->ID) {
   $states['flexi-user-dashboard'] = __('Flexi User Dashboard', 'flexi');
  }
 }

 $submission_form = flexi_get_option('submission_form', 'flexi_form_settings', 0);
 if (0 != $submission_form) {
  if ($submission_form == $post->ID) {
   $states['flexi-submission-form'] = __('Flexi Submission Form', 'flexi');
  }
 }

 $edit_flexi_page = flexi_get_option('edit_flexi_page', 'flexi_form_settings', 0);
 if (0 != $edit_flexi_page) {
  if ($edit_flexi_page == $post->ID) {
   $states['flexi-edit'] = __('Flexi Edit/Modify', 'flexi');
  }
 }

 return $states;
}
add_filter('display_post_states', 'flexi_page_post_state_label', 20, 2);

//Shortcode evalue set into array
function flexi_evalue_setarray($evalue)
{
 $main = array();

 $values = explode(',', $evalue);
 foreach ($values as $option) {
  $cap = explode(":", $option);
  if ('' != $cap[0]) {
   $main[$cap[0]] = trim($cap[1]);
  }
 }
 return $main;
}

//Determine to show div element
function flexi_evalue_toggle($key, $evalue)
{
 $extra_param = flexi_evalue_setarray($evalue);
 //var_dump($extra_param);
 if (isset($extra_param[$key]) && 'on' == $extra_param[$key]) {
  echo '';
 } else {
  echo 'display:none';
 }
}

//Get error code while submitting form
function flexi_get_error($result)
{
 $notice = "";
 if (isset($result['notice'][0])) {
  $reindex_array = array_values(array_filter($result['error']));
  $notice_array  = array_values(array_filter($result['notice']));
  for ($x = 0; $x < count($reindex_array); $x++) {
   // $err .= $reindex_array[$x] . "  ";
   $notice .= "<div class='flexi_alert-box flexi_error'>" . flexi_error_code($reindex_array[$x]) . " : " . $notice_array[$x] . "</div>";
  }
 }
 return $notice;
}
