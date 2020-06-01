<?php
// Adds widget: Flexi Gallery
class Flexigallery_Widget extends WP_Widget
{

 public function __construct()
 {
  parent::__construct(
   'flexigallery_widget',
   esc_html__('Flexi Gallery', 'flexi'),
   array('description' => esc_html__('This will generate the gallery based on selection', 'flexi')) // Args
  );
 }

 private $widget_fields = array(
  array(
   'label'   => 'Select gallery location',
   'id'      => 'sidebar',
   'default' => 'sidebar',
   'type'    => 'select',
   'options' => array(
    'sidebar',
    'content',
   ),
  ),
 );

 public function widget($args, $instance)
 {
  echo $args['before_widget'];

  if (!empty($instance['title'])) {
   echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
  }

  // Output generated fields
  echo '<p>' . $instance['sidebar'] . '</p>';

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

function register_flexigallery_widget()
{
 register_widget('Flexigallery_Widget');
}
add_action('widgets_init', 'register_flexigallery_widget');