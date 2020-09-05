<?php
// Manage categories backend & frontend
class Flexi_Category
{
 public function __construct()
 {
  $taxonomy = 'flexi_category';
  add_filter("manage_edit-" . $taxonomy . "_columns", array($this, 'new_column_category'));
  add_action('manage_' . $taxonomy . '_custom_column', array($this, 'manage_category_columns'), 10, 3);

  $taxonomy_tag = 'flexi_tag';
  add_filter("manage_edit-" . $taxonomy_tag . "_columns", array($this, 'new_column_tag'));
  add_action('manage_' . $taxonomy_tag . '_custom_column', array($this, 'manage_tag_columns'), 10, 3);
  add_action('template_redirect', array($this, 'category_rewrite_view_link'));
  add_shortcode('flexi-category', array($this, 'flexi_category'));
  
  //Display category dropdown at gallery page
//  add_action('flexi_gallery_top_right', array($this, 'flexi_gallery_top_right'));
 }


 //Display category dropdown at gallery page
 public function flexi_gallery_top_right()
 {
  $category_page_link = get_permalink(flexi_get_option('category_page', 'flexi_categories_settings', 0));
  //$link = add_query_arg("flexi_category", $term->slug, $category_page_link);

  $term_slug = get_query_var('flexi_category');
  $dropdown_args = array(
    'show_option_none'  => '-- ' . __('All category', 'flexi') . ' --',
    'option_none_value' => '',
    'selected'          => $term_slug,
    'echo'              => 0,
    'show_count'        => 1,
    'hierarchical'      => 1,
    'taxonomy'          => 'flexi_category',
    'name'               => 'flexi_cat',
    'value_field'       => 'slug',
    'hide_empty'        => 0,
 
   );
 
   $html = wp_dropdown_categories($dropdown_args);
 
   echo $html."<br><br>";
   ?>
<script>
var dropdown = document.getElementById("flexi_cat");

function onCatChange() {
    if (dropdown.options[dropdown.selectedIndex].value != 0) {
      location.href = "<?php echo $category_page_link; ?>/?flexi_category=" + dropdown.options[dropdown.selectedIndex].value;
    } else  {
        alert("home");
    }
}
dropdown.onchange = onCatChange;
</script>
<?php


 }


//List category/album at frontend
public function flexi_category($params)
{

//Parent category
if (isset($params['parent']) && $params['parent'] != '') {
  $term_slug = $params['parent'];
} else {
  $term_slug = "";
}

//check category in url
$term_slug_in_url = get_query_var('flexi_category');
if($term_slug_in_url!='')
$term_slug = get_query_var('flexi_category');
  
  $term = get_term_by('slug', $term_slug, 'flexi_category');

  if ($term_slug != "") {
    $album_name = $term->name;
    $term_id = $term->term_id;
} else {
    $album_name = "";
    $term_id = 0;
}

//Show album count
if (isset($params['count']) && $params['count'] == 'show') {
  $count = true;
} else {
  $count_category = flexi_get_option('category_count', 'flexi_categories_settings', 1);
  if ("1" == $count_category) {
  $count = true;
  }
  else
  {
      $count = false;
  }
}

//Hide hidden category
$skip = array();
$skip = flexi_hidden_album();

  $args = array(
    'orderby'      => 'name',
    'order' => 'ASC',
    'hide_empty'   => 0,
    'exclude'            => $skip,
    'parent' => $term_id,

);

$terms = get_terms('flexi_category', $args);

//Layout
if (isset($params['layout'])) {
  $layout = trim($params['layout']);
 } else {
  $layout = "basic";
 }

$count_category = 0;
$put   = "";
ob_start();

if (!empty($terms) && !is_wp_error($terms)) 
{

  $check_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/loop.php';
  if (file_exists($check_file)) 
  {
    if (isset($params['column']) && $params['column'] > 0) {
      $column = $params['column'];
     } else {
      $column = flexi_get_option('column', 'flexi_image_layout_settings', 3);
     }
   
     if (isset($params['width']) && $params['width'] > 0) {
      $width = $params['width'];
     } else {
      $width = flexi_get_option('t_width', 'flexi_media_settings', 150);
     }
   
     if (isset($params['height']) && $params['height'] > 0) {
      $height = $params['height'];
     } else {
      $height = flexi_get_option('t_height', 'flexi_media_settings', 150);
     }

     //padding
  if (isset($params['padding'])) {
    $padding = $params['padding'] . 'px';
   } else {
    $padding = flexi_get_option('image_space', 'flexi_gallery_appearance_settings', 0) . 'px';
   }
 
   
  
$category_page_link = flexi_get_button_url('', false, 'category_page', 'flexi_categories_settings');
if ('#' != $category_page_link) {
    wp_register_style('flexi_category_' . $layout . '_layout', FLEXI_PLUGIN_URL . '/public/partials/layout/category/' . $layout . '/style.css', null, FLEXI_VERSION);
    wp_enqueue_style('flexi_category_' . $layout . '_layout');
    require FLEXI_PLUGIN_DIR . 'public/partials/layout/category/attach_header.php';

    foreach ($terms as $term) {
        if ($count) {
            $count_result='('.$term->count.')';
        } else {
            $count_result='';
        }
        require FLEXI_PLUGIN_DIR . 'public/partials/layout/category/attach_loop.php';
        $count_category++;
    }

    require FLEXI_PLUGIN_DIR . 'public/partials/layout/category/attach_footer.php';
}
else
{
  echo '<div id="flexi_no_record" class="flexi_alert-box flexi_error">' . __('Flexi category page is not assigned in settings.', 'flexi') . '</div>';
}
    
  }

}

$put = ob_get_clean();
    wp_reset_query();
    wp_reset_postdata();

    if (flexi_execute_shortcode()) {
      return $put;
     } else {
 
      return '';
     }

}


 public function new_column_category($columns)
 {

  $columns = array(
   'cb'        => '<input type="checkbox" />',
   'name'      => __('Name'),
   'shortcode' => __('Shortcode'),
   'slug'      => __('Slug'),
   'posts'     => __('Posts'),
  );

  return $columns;

 }
 public function manage_category_columns($out, $column_name, $cat_id)
 {
  $taxonomy = 'flexi_category';

  switch ($column_name) {
   case 'shortcode':
    $a = get_term_by('id', $cat_id, $taxonomy);
    echo '<code>[flexi-gallery album="' . $a->slug . '"]</code>';
    break;

   default:
    break;
  }
 }

 public function new_column_tag($columns)
 {

  $columns = array(
   'cb'        => '<input type="checkbox" />',
   'name'      => __('Name'),
   'shortcode' => __('Shortcode'),
   'slug'      => __('Slug'),
   'posts'     => __('Posts'),
  );

  return $columns;

 }
 public function manage_tag_columns($out, $column_name, $cat_id)
 {
  $taxonomy = 'flexi_tag';

  switch ($column_name) {
   case 'shortcode':
    $a = get_term_by('id', $cat_id, $taxonomy);
    echo '<code>[flexi-gallery tag="' . $a->slug . '"]</code>';
    break;

   default:
    break;
  }
 }

 //Redirect to category page with view is clicked at category & tag of admin dashboard
 public function category_rewrite_view_link()
 {

  $redirect_url = '';
  if (!is_feed()) {
   if (is_tax('flexi_category')) {

    $term         = get_queried_object();
    $redirect_url = flexi_get_category_page_link($term, 'flexi_category');

   }

   if (is_tax('flexi_tag')) {

    $term         = get_queried_object();
    $redirect_url = flexi_get_category_page_link($term, 'flexi_tag');

   }
  }

  // Redirect
  if (!empty($redirect_url)) {

   wp_redirect($redirect_url);
   exit();
  }

 }

}
//Execute
$category = new Flexi_Category();