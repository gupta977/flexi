<?php
add_action('widgets_init', function () {
    register_widget('flexi_tag_Widget');
});

class flexi_tag_Widget extends WP_Widget
{

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname'   => 'widget_tags',
            'description' => 'Lists Flexi Tags',
        );

        parent::__construct('flexi_tag_widget', 'Flexi Tag List', $widget_ops);
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

        // echo flexi_droplist_tag('flexi_tag', '', array(), 'tag_list');

        $taxonomies = array('flexi_tag');
        $query_args = array('orderby' => 'name', 'order' => 'ASC', 'hide_empty' => true);
        $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));

        $selected_slug = get_query_var('flexi_tag', "");


        $myterms = get_terms($taxonomies, $query_args);
        $output = "<select onChange='window.location.href=this.value'>";
        $output .= "<option value='default'>- " . __('None', 'flexi') . " -</option>";
        foreach ($myterms as $term) {
            $term_taxonomy = $term->taxonomy;
            $term_slug = $term->slug;
            $term_name = $term->name;
            $link = add_query_arg($term_taxonomy, $term_slug, $link);
            if ($selected_slug == $term_slug) {
                $output .= "<option value='" . $link . "' selected>" . $term_name . "</option>";
            } else {
                $output .= "<option value='" . $link . "'>" . $term_name . "</option>";
            }
        }
        $output .= "</select>";

        echo $output;

        // echo __('Hello, World!', 'text_domain');
        echo $args['after_widget'];
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
