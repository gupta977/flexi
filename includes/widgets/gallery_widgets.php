<?php
// Adds widget: Flexi Showcase
class Flexishowcase_Widget extends WP_Widget
{

 public function __construct()
 {
  parent::__construct(
   'flexishowcase_widget',
   esc_html__('Flexi Showcase', 'flexi'),
   array('description' => esc_html__('Display specified set of gallery', 'flexi')) // Args
  );
 }

 private $widget_fields = array(
  array(
   'label'   => 'Sort as',
   'id'      => 'orderby',
   'default' => 'date',
   'type'    => 'select',
   'options' => array(
    'date',
    'modified',
    'rand',
   ),
  ),
  array(
   'label'   => 'Filter as',
   'id'      => 'filter',
   'default' => 'none',
   'type'    => 'select',
   'options' => array(
    'none',
    'image',
    'url',
    'video',
    'audio',
    'other',
   ),
  ),
  array(
   'label'   => 'From category',
   'id'      => 'cat',
   'default' => '0',
   'type'    => 'select',
   'options' => array(
    '',
    '1',
    '2',
    '3',
   ),
  ),
  array(
   'label'   => 'Layout',
   'id'      => 'layout',
   'default' => 'basic',
   'type'    => 'select',
   'options' => array(
    'basic',
    'masonry',
    'portfolio',
    'regular',
    'wide',
   ),
  ),
  array(
   'label'   => 'Number of Column',
   'id'      => 'column',
   'default' => '1',
   'type'    => 'number',
  ),
  array(
   'label'   => 'Total number of Post',
   'id'      => 'perpage',
   'default' => '1',
   'type'    => 'number',
  ),
  array(
   'label' => 'Tag slug name separated by commas',
   'id'    => 'tags',
   'type'  => 'text',
  ),
  array(
   'label'   => 'Padding',
   'id'      => 'padding',
   'default' => '1',
   'type'    => 'number',
  ),
  array(
   'label'   => 'Thumbnail Width',
   'id'      => 'width',
   'default' => '100',
   'type'    => 'number',
  ),
  array(
   'label'   => 'Thumbnail Height',
   'id'      => 'height',
   'default' => '100',
   'type'    => 'number',
  ),
  array(
   'label'   => 'Image Hover Effect',
   'id'      => 'hover_effect',
   'type'    => 'select',
   'options' => array(
    'flexi_effect_1',
    'flexi_effect_2',
    'flexi_effect_3',
    '',
   ),
  ),
  array(
   'label'   => 'Image Hover Caption',
   'id'      => 'hover_caption',
   'default' => 'flexi_caption_none',
   'type'    => 'select',
   'options' => array(
    'flexi_caption_none',
    'flexi_caption_1',
    'flexi_caption_2',
    'flexi_caption_3',
    'flexi_caption_4',
    'flexi_caption_5',
   ),
  ),
  array(
   'label' => 'Enable Popup',
   'id'    => 'popup',
   'type'  => 'checkbox',
  ),
  array(
   'label' => 'Display tags above gallery',
   'id'    => 'show_tag',
   'type'  => 'checkbox',
  ),
  array(
   'label' => 'Display title',
   'id'    => 'evalue_title',
   'type'  => 'checkbox',
  ),
  array(
   'label' => 'Display excerpt',
   'id'    => 'evalue_excerpt',
   'type'  => 'checkbox',
  ),
  array(
   'label' => 'Display custom fields',
   'id'    => 'evalue_custom',
   'type'  => 'checkbox',
  ),
  array(
   'label'   => 'Display icon grid',
   'id'      => 'evalue_icon',
   'default' => 'off',
   'type'    => 'checkbox',
  ),
  array(
   'label' => 'Display category list',
   'id'    => 'evalue_category',
   'type'  => 'checkbox',
  ),
  array(
   'label' => 'Display tag list',
   'id'    => 'evalue_tag',
   'type'  => 'checkbox',
  ),
 );

 public function widget($args, $instance)
 {
  echo $args['before_widget'];

  if (!empty($instance['title'])) {
   echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
  }

  // Output generated fields
  /*
  echo '<p>' . $instance['orderby'] . '</p>';
  echo '<p>' . $instance['filter'] . '</p>';
  echo '<p>' . $instance['cat'] . '</p>';
  echo '<p>' . $instance['layout'] . '</p>';
  echo '<p>' . $instance['column'] . '</p>';
  echo '<p>' . $instance['perpage'] . '</p>';
  echo '<p>' . $instance['tags'] . '</p>';
  echo '<p>' . $instance['padding'] . '</p>';
  echo '<p>' . $instance['width'] . '</p>';
  echo '<p>' . $instance['height'] . '</p>';
  echo '<p>' . $instance['hover_effect'] . '</p>';
  echo '<p>' . $instance['hover_caption'] . '</p>';
  echo '<p>' . $instance['popup'] . '</p>';
  echo '<p>' . $instance['show_tag'] . '</p>';
  echo '<p>' . $instance['evalue_title'] . '</p>';
  echo '<p>' . $instance['evalue_excerpt'] . '</p>';
  echo '<p>' . $instance['evalue_custom'] . '</p>';
  echo '<p>' . $instance['evalue_icon'] . '</p>';
  echo '<p>' . $instance['evalue_category'] . '</p>';
  echo '<p>' . $instance['evalue_tag'] . '</p>';
   */
  // echo '<p>' . $instance['shortcode'] . '</p>';

  if (isset($instance['popup']) && '1' == $instance['popup']) {
   $popup = "on";
  } else {
   $popup = "off";
  }

  if (isset($instance['tag_show']) && '1' == $instance['tag_show']) {
   $tag_show = "on";
  } else {
   $tag_show = "off";
  }

  $evalue = "";

  if (isset($instance['evalue_title']) && '1' == $instance['evalue_title']) {
   $evalue .= "title:on,";
  }
  if (isset($instance['evalue_excerpt']) && '1' == $instance['evalue_excerpt']) {
   $evalue .= "excerpt:on,";
  }
  if (isset($instance['evalue_custom']) && '1' == $instance['evalue_custom']) {
   $evalue .= "custom:on,";
  }
  if (isset($instance['evalue_icon']) && '1' == $instance['evalue_icon']) {
   $evalue .= "icon:on,";
  }
  if (isset($instance['evalue_category']) && '1' == $instance['evalue_category']) {
   $evalue .= "category:on,";
  }
  if (isset($instance['evalue_tag']) && '1' == $instance['evalue_tag']) {
   $evalue .= "tag:on,";
  }

  if (isset($instance['filter']) && 'none' == $instance['filter']) {
   $filter = '';
  } else {
   $filter = 'filter="' . $instance['filter'] . '"';
  }

  $cat = get_term_by('id', $instance['cat'], 'flexi_category');
  if ($cat) {
   $cat = 'album="' . $cat->slug . '"';
  } else {
   $cat = "";
  }

  $shortcode = 'flexi-gallery
column="' . $instance['column'] . '"
perpage="' . $instance['perpage'] . '"
padding="' . $instance['padding'] . '"
layout="' . $instance['layout'] . '"
popup="' . $popup . '"
' . $cat . '
tag="' . $instance['tags'] . '"
orderby="' . $instance['orderby'] . '"
tag_show="' . $tag_show . '"
hover_effect="' . $instance['hover_effect'] . '"
hover_caption="' . $instance['hover_caption'] . '"
width="' . $instance['width'] . '"
height="' . $instance['height'] . '"
' . $filter . '
evalue="' . $evalue . '"
 ';

  if (did_action('elementor/loaded')) {
   if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
    $shortcode .= ' clear="true"';
   }
  }

  echo $shortcode . "<hr>";
  echo do_shortcode('[' . $shortcode . ']');

  //echo do_shortcode('[flexi-gallery clear="true"]');
  echo $args['after_widget'];
 }

 public function field_generator($instance)
 {
  $output = '';
  foreach ($this->widget_fields as $widget_field) {
   $default = '';
   if (isset($widget_field['default'])) {
    $default = $widget_field['default'];
   }
   $widget_value = !empty($instance[$widget_field['id']]) ? $instance[$widget_field['id']] : esc_html__($default, 'flexi');
   switch ($widget_field['type']) {
    case 'checkbox':
     $output .= '<p>';
     $output .= '<input class="checkbox" type="checkbox" ' . checked($widget_value, true, false) . ' id="' . esc_attr($this->get_field_id($widget_field['id'])) . '" name="' . esc_attr($this->get_field_name($widget_field['id'])) . '" value="1">';
     $output .= ' <label for="' . esc_attr($this->get_field_id($widget_field['id'])) . '">' . esc_attr($widget_field['label'], 'flexi') . '</label>';
     $output .= '</p>';
     break;
    case 'select':
     $output .= '<p>';
     $output .= '<label for="' . esc_attr($this->get_field_id($widget_field['id'])) . '">' . esc_attr($widget_field['label'], 'textdomain') . ':</label> ';
     $output .= '<select id="' . esc_attr($this->get_field_id($widget_field['id'])) . '" name="' . esc_attr($this->get_field_name($widget_field['id'])) . '">';
     foreach ($widget_field['options'] as $option) {
      if ($widget_value == $option) {
       $output .= '<option value="' . $option . '" selected>' . $option . '</option>';
      } else {
       $output .= '<option value="' . $option . '">' . $option . '</option>';
      }
     }
     $output .= '</select>';
     $output .= '</p>';
     break;
    default:
     $output .= '<p>';
     $output .= '<label for="' . esc_attr($this->get_field_id($widget_field['id'])) . '">' . esc_attr($widget_field['label'], 'flexi') . ':</label> ';
     $output .= '<input class="widefat" id="' . esc_attr($this->get_field_id($widget_field['id'])) . '" name="' . esc_attr($this->get_field_name($widget_field['id'])) . '" type="' . $widget_field['type'] . '" value="' . esc_attr($widget_value) . '">';
     $output .= '</p>';
   }
  }
  echo $output;
 }

 public function form($instance)
 {
  $title = !empty($instance['title']) ? $instance['title'] : esc_html__('', 'flexi');
  ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'flexi');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
$this->field_generator($instance);
 }

 public function update($new_instance, $old_instance)
 {
  $instance          = array();
  $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
  foreach ($this->widget_fields as $widget_field) {
   switch ($widget_field['type']) {
    default:
     $instance[$widget_field['id']] = (!empty($new_instance[$widget_field['id']])) ? strip_tags($new_instance[$widget_field['id']]) : '';
   }
  }
  return $instance;
 }
}

function register_flexishowcase_widget()
{
 register_widget('Flexishowcase_Widget');
}
add_action('widgets_init', 'register_flexishowcase_widget');
?>