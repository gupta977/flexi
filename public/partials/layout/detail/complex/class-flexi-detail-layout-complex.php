<?php
class Flexi_Detail_Layout_Complex
{
 public function __construct()
 {

  add_filter('flexi_settings_sections', array($this, 'add_section'));
  add_filter('flexi_settings_fields', array($this, 'add_fields'));
  for ($x = 1; $x <= 15; $x++) {
   add_action('flexi_location_' . $x, array($this, 'flexi_location'), 10, 3);
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
    'id'          => 'flexi_detail_layout_complex',
    'title'       => __('Complex - Layout', 'flexi'),
    'description' => __('<ul>
    <li>One element can have same location</li>
    <li>Detail page is accessed by clicking on icon <span class="dashicons dashicons-external">&nbsp;</span></li>
    <li>Page title is positioned based on theme</li>
    </ul>', 'flexi'),
    'tab'         => 'detail',
   ),
  );
  $new = array_merge($new, $sections);

  return $new;
 }

 //elements in use
 public function list_elements()
 {
  $labels = array(
   "Publish Status" => "status",
   "Large Media"    => "media",
   "Description"    => "desp",
   "Category"       => "category",
   "Tags"           => "tags",
   "Icon Grid"      => "icon_grid",
   "Custom Fields"  => "custom_fields",
  );

  return $labels;
 }

 //Add section fields
 public function add_fields($new)
 {

  $fields = array('flexi_detail_layout_complex' => array(
   array(
    'name'        => 'public/partials/layout/detail/complex/complex_chart.png',
    'label'       => __('Detail Layout Chart', 'flexi'),
    'description' => __('Each number denotes the available location of elements', 'flexi'),
    'type'        => 'image',
    'size'        => '100%',
    'class'       => '',
   ),

  ));

  $labels = $this->list_elements();

  foreach ($labels as $x => $x_value) {
   $fields_add = array('flexi_detail_layout_complex' => array(
    array(
     'name'              => 'flexi_' . $x_value,
     'label'             => __($x, 'flexi'),
     'description'       => __('Select the element want to show/hide', 'flexi'),
     'type'              => 'select',
     'options'           => array(
      ''           => __('-- Hide --', 'flexi'),
      'location1'  => __('Location 1', 'flexi'),
      'location2'  => __('Location 2', 'flexi'),
      'location3'  => __('Location 3', 'flexi'),
      'location4'  => __('Location 4', 'flexi'),
      'location5'  => __('Location 5', 'flexi'),
      'location6'  => __('Location 6', 'flexi'),
      'location7'  => __('Location 7', 'flexi'),
      'location8'  => __('Location 8', 'flexi'),
      'location9'  => __('Location 9', 'flexi'),
      'location10' => __('Location 10', 'flexi'),
      'location11' => __('Location 11', 'flexi'),
      'location12' => __('Location 12', 'flexi'),
      'location13' => __('Location 13', 'flexi'),
      'location14' => __('Location 14', 'flexi'),
      'location15' => __('Location 15', 'flexi'),

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

 //Keep all elements into array
 public function generate_array()
 {
  $labels   = $this->list_elements();
  $elements = array();
  foreach ($labels as $x => $x_value) {
   $location           = flexi_get_option('flexi_' . $x_value, 'flexi_detail_layout_complex', '');
   $elements[$x_value] = $location;
  }
  //flexi_log($elements);
  return $elements;

 }

 //Search into array
 public function array_ksearch($array, $str)
 {
  $result = array();
  for ($i = 0; $i < count($array); next($array), $i++) {
   if (strtolower(current($array)) == strtolower($str)) {
    array_push($result, key($array));
   }

  }
  return $result;
 }

 //Display elements based on array found
 public function display_element($value, $post, $layout)
 {
  ob_start();
  if ('complex' == $layout) {
   //flexi_log($value . '----' . $layout);
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
  return ob_get_clean();

 }

 public function flexi_location($param, $post, $layout)
 {

  //Set default location of elements
  flexi_get_option('flexi_media', 'flexi_detail_layout_complex', 'location6');
  flexi_get_option('flexi_status', 'flexi_detail_layout_complex', 'location1');
  flexi_get_option('flexi_desp', 'flexi_detail_layout_complex', 'location15');
  flexi_get_option('flexi_icon_grid', 'flexi_detail_layout_complex', 'location14');
  flexi_get_option('flexi_custom_fields', 'flexi_detail_layout_complex', 'location13');
  flexi_get_option('flexi_category', 'flexi_detail_layout_complex', 'location12');
  flexi_get_option('flexi_tags', 'flexi_detail_layout_complex', 'location12');

  if ('complex' == $layout) {
   $elements = $this->generate_array();
   $location = $this->array_ksearch($elements, 'location' . $param);

   //flexi_log($elements);

   foreach ($location as $v) {
    echo $this->display_element($v, $post, $layout);
    //echo $v;
   }
  }

 }

}

//List layout locations
$layout = new Flexi_Detail_Layout_Complex();
