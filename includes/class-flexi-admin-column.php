<?php
class Flexi_Admin_Column
{

 public function __construct()
 {
  add_filter('manage_flexi_posts_columns', array($this, 'new_column'));
  add_action('manage_flexi_posts_custom_column', array($this, 'manage_flexi_columns'), 10, 2);
  add_filter('manage_edit-flexi_sortable_columns', array($this, 'sortable_columns'));
  add_action('pre_get_posts', array($this, 'posts_orderby'));
 }

 public function new_column($columns)
 {

  $columns = array(
   'cb'                      => $columns['cb'],
   'image'                   => __('Image'),
   'title'                   => __('Title'),
   'author'                  => __('Author'),
   'taxonomy-flexi_category' => __('Categories'),
   'taxonomy-flexi_tag'      => __('Tags'),
   'flexi_layout'            => __('Detail Layout', 'flexi'),
   'date'                    => __('Date'),

  );

  return $columns;

 }

 public function manage_flexi_columns($column, $post_id)
 {
  switch ($column) {
   case 'flexi_layout':
    $layout = "basic";

    $all_flexi_fields = get_post_custom($post_id);

    if (isset($all_flexi_fields["flexi_layout"][0])) {
     $layout = $all_flexi_fields["flexi_layout"][0];
    }

    echo $layout;
    break;

   case 'image':
    echo '<img src="' . esc_url(flexi_image_src('thumbnail', get_post($post_id))) . '" width="75px">';
    break;

   default:
    break;
  }
 }

 public function sortable_columns($columns)
 {
  $columns['flexi_layout'] = 'flexi_layout';
  return $columns;
 }

 public function posts_orderby($query)
 {
  if (!is_admin() || !$query->is_main_query()) {
   return;
  }

  if ('flexi_layout' === $query->get('orderby')) {
   $query->set('orderby', 'meta_value');
   $query->set('meta_key', 'flexi_layout');
   //$query->set('meta_type', 'text');
  }
 }

}
