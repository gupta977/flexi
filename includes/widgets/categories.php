<?php
add_action('widgets_init', function () {
  register_widget('flexi_category_Widget');
});

class flexi_category_Widget extends WP_Widget
{

  /**
   * Sets up the widgets name etc
   */
  public function __construct()
  {
    $widget_ops = array(
      'classname'   => 'widget_categories',
      'description' => 'Lists Flexi Categories',
    );

    parent::__construct('flexi_category_widget', 'Flexi Category List', $widget_ops);
  }

  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget($args, $instance)
  {
    // outputs the content of the widget
    echo $args['before_widget'];
    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
    }

    //List categories
    $query_args = array(
      'taxonomy'       => 'flexi_category',
      'parent'         => !empty($instance['parent']) ? (int) $instance['parent'] : 0,
      'term_id'        => !empty($instance['parent']) ? (int) $instance['parent'] : 0,
      'hide_empty'     => !empty($instance['hide_empty']) ? 1 : 0,
      'orderby'        => 'title',
      'order'          => 'asc',
      'show_count'     => !empty($instance['show_count']) ? 1 : 0,
      'pad_counts'     => isset($listings_settings['include_results_from']) && in_array('child_categories', $listings_settings['include_results_from']) ? true : false,
      'imm_child_only' => !empty($instance['imm_child_only']) ? 1 : 0,
      'active_term_id' => 0,
      'ancestors'      => array(),
    );

    if ($query_args['imm_child_only']) {

      $term_slug = get_query_var('flexi_category');

      if ('' != $term_slug) {
        $term                         = get_term_by('slug', $term_slug, 'flexi_category');
        $query_args['active_term_id'] = $term->term_id;

        $query_args['ancestors']   = get_ancestors($query_args['active_term_id'], 'flexi_category');
        $query_args['ancestors'][] = $query_args['active_term_id'];
        $query_args['ancestors']   = array_unique($query_args['ancestors']);
      }
    }
    $categories = $this->list_categories($query_args);

    if (!empty($categories)) {
      echo $categories;
    }

    //echo __( 'Hello, World!', 'text_domain' );
    echo $args['after_widget'];
  }

  // HTML code that contain categories list.
  public function list_categories($settings)
  {
    $term_slug = get_query_var('flexi_category');

    if ($settings['imm_child_only']) {

      if ($settings['term_id'] > $settings['parent'] && !in_array($settings['term_id'], $settings['ancestors'])) {
        return;
      }
    }

    $args = array(
      'orderby'      => $settings['orderby'],
      'order'        => $settings['order'],
      'hide_empty'   => $settings['hide_empty'],
      'parent'       => $settings['term_id'],
      'hierarchical' => false,
    );

    $terms = get_terms('flexi_category', $args);

    $html = '';

    if (count($terms) > 0) {

      $html .= '<ul class="widget_categories">';

      foreach ($terms as $term) {
        $settings['term_id'] = $term->term_id;

        $flexi_hide_cate = get_term_meta($term->term_id, 'flexi_hide_cate', true);
        if ("on" != $flexi_hide_cate) {

          $count = 0;
          if (!empty($settings['hide_empty']) || !empty($settings['show_count'])) {
            $count = $term->count;

            if (!empty($settings['hide_empty']) && 0 == $count) {
              continue;
            }
          }

          if ($term_slug == $term->slug) {
            $html .= '<li class="cat-item cat-item-' . $term->term_id . ' current-cat">';
          } else {
            $html .= '<li class="cat-item cat-item-' . $term->term_id . '">';
          }

          $html .= '<a href="' . flexi_get_category_page_link($term, 'flexi_category') . '">';
          $html .= $term->name;
          if (!empty($settings['show_count'])) {
            $html .= ' (' .  flexi_total_cat_post_count($term->term_id, $count) . ')';
          }
          $html .= '</a>';
          $html .= $this->list_categories($settings);
          $html .= '</li>';
        }
      }

      $html .= '</ul>';
    }

    return $html;
  }

  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form($instance)
  {
    // outputs the options form on admin
    $title = !empty($instance['title']) ? $instance['title'] : __('New title', 'flexi');
?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
      <br>
      <br>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Select Parent'); ?></label>
      <?php
      wp_dropdown_categories(array(
        'show_option_none'  => '-- ' . __('Select Parent', 'flexi') . ' --',
        'option_none_value' => 0,
        'taxonomy'          => 'flexi_category',
        'name'              => $this->get_field_name('parent'),
        'class'             => 'widefat',
        'orderby'           => 'name',
        'selected'          => !empty($instance['parent']) ? (int) $instance['parent'] : 0,
        'hierarchical'      => true,
        'depth'             => 20,
        'show_count'        => false,
        'hide_empty'        => false,
      ));

      $check_imm_child_only = !empty($instance['imm_child_only']) ? 1 : 0;
      $check_hide_empty     = !empty($instance['hide_empty']) ? 1 : 0;
      $check_show_count     = !empty($instance['show_count']) ? 1 : 0;
      ?>
      <br><br>
      <input <?php checked($check_imm_child_only); ?> id="<?php echo $this->get_field_id('imm_child_only'); ?>" name="<?php echo $this->get_field_name('imm_child_only'); ?>" type="checkbox" />
      <label for="<?php echo $this->get_field_id('imm_child_only'); ?>"><?php _e('Show only the immediate children of the selected category.', 'flexi'); ?></label>
      <br>
    </p>
    <p>
      <input <?php checked($check_hide_empty); ?> id="<?php echo $this->get_field_id('hide_empty'); ?>" name="<?php echo $this->get_field_name('hide_empty'); ?>" type="checkbox" />
      <label for="<?php echo $this->get_field_id('hide_empty'); ?>"><?php _e('Hide Empty Categories', 'flexi'); ?></label>
    </p>

    <p>
      <input <?php checked($check_show_count); ?> id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="checkbox" />
      <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show Listing Counts', 'flexi'); ?></label>
    </p>
<?php
  }

  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  public function update($new_instance, $old_instance)
  {
    // processes widget options to be saved
    /*  foreach( $new_instance as $key => $value )
  {
  $updated_instance[$key] = sanitize_text_field($value);
  }

  return $updated_instance; */

    $instance = $old_instance;

    $instance['title']          = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
    $instance['parent']         = isset($new_instance['parent']) ? (int) $new_instance['parent'] : 0;
    $instance['imm_child_only'] = isset($new_instance['imm_child_only']) ? 1 : 0;
    $instance['hide_empty']     = isset($new_instance['hide_empty']) ? 1 : 0;
    $instance['show_count']     = isset($new_instance['show_count']) ? 1 : 0;

    return $instance;
  }
}
