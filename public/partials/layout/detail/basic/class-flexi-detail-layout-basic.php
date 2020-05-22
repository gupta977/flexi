<?php
class Flexi_Detail_Layout_Basic
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));

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
      'none'          => __('-- None --', 'flexi'),
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

}

//List layout positions
$layout = new Flexi_Detail_Layout_Basic();
