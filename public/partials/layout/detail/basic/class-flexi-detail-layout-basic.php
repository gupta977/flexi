<?php
class Flexi_Detail_Layout_Basic
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  for ($x = 1; $x <= 15; $x++) {
   add_action('flexi_position_' . $x, array($this, 'flexi_position'), 10, 2);
  }

 }

 //add_filter flexi_settings_tabs
 public function add_tabs($new)
 {
  $tabs = array();
  $new  = array_merge($tabs, $new);
  return $new;
 }

 //Add Section title
 public function add_section($new)
 {

  $sections = array(
   array(
    'id'          => 'flexi_detail_layout_basic',
    'title'       => __('Basic - Layout', 'flexi'),
    'description' => __('xxxxxxxxxxxxxxx', 'flexi'),
    'tab'         => 'detail',
   ),
  );
  $new = array_merge($new, $sections);

  return $new;
 }

 //Add section fields
 public function add_fields($new)
 {

  $fields = array('flexi_detail_layout_basic' => array(
   array(
    'name'        => 'basic_chart.png',
    'label'       => __('Detail Layout Chart', 'flexi'),
    'description' => __('Each number denotes the available position of elements', 'flexi'),
    'type'        => 'image',
    'size'        => '100%',
    'class'       => 'xxxx',
   ),

  ));

  for ($x = 1; $x <= 15; $x++) {
   $fields_add = array('flexi_detail_layout_basic' => array(
    array(
     'name'              => 'flexi_location' . $x,
     'label'             => __('Location ' . $x, 'flexi'),
     'description'       => __('Select the element want to show/hide', 'flexi'),
     'type'              => 'select',
     'options'           => array(
      ''              => __('-- None --', 'flexi'),
      'status'        => __('Status', 'flexi'),
      'media'         => __('Media', 'flexi'),
      'standalone'    => __('Standalone Gallery', 'flexi'),
      'desp'          => __('Description', 'flexi'),
      'category'      => __('Category', 'flexi'),
      'tags'          => __('Tags', 'flexi'),
      'icon_grid'     => __('Icon Grid', 'flexi'),
      'custom_fields' => __('Custom Fields', 'flexi'),
      'date_posted'   => __('Date posted', 'flexi'),
      'author_info'   => __('Author Info', 'flexi'),
     ),
     'sanitize_callback' => 'sanitize_key',
    ),
   ),
   );
   $fields = array_merge_recursive($fields, $fields_add);
  }

  $new = array_merge($new, $fields);

  return $new;
 }

 public function flexi_position($param, $post)
 {
  $value = flexi_get_option('flexi_location' . $param, 'flexi_detail_layout_basic', 'none');
  if ('media' == $value) {
   echo "<div class='flexi_image_wrap_large'>" . flexi_large_media($post) . "</div>";
  } else if ('status' == $value) {

   if (get_post_status() == 'draft' || get_post_status() == "pending") {
    ?>
        <small>
          <div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div>
        </small>
    <?php
}

  } else if ('desp' == $value) {
   ?>
<div class="flex-desp"> <?php echo wpautop(stripslashes($post->post_content)); ?></div>
      <?php
} else if ('standalone' == $value) {
   ?>
  <div id="flexi_thumb_image" style='text-align: center;'> <?php flexi_standalone_gallery(get_the_ID(), 'thumbnail', 75, 75);?></div>
       <?php
} else if ('category' == $value) {
   echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . ' </div></span>';
  } else if ('tags' == $value) {
   echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div></span>';
  } else if ('icon_grid' == $value) {
   echo flexi_show_icon_grid();
  } else if ('custom_fields' == $value) {
   echo flexi_custom_field_loop($post, 'detail');
  } else {
   echo "<div>" . $value . "</div>";
  }
 }

}

//List layout positions
$layout = new Flexi_Detail_Layout_Basic();
