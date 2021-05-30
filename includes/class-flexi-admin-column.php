<?php
class Flexi_Admin_Column
{

  public function __construct()
  {
    add_filter('manage_flexi_posts_columns', array($this, 'new_column'));
    add_action('manage_flexi_posts_custom_column', array($this, 'manage_flexi_columns'), 10, 2);
    add_filter('manage_edit-flexi_sortable_columns', array($this, 'sortable_columns'));
    add_action('pre_get_posts', array($this, 'posts_orderby'));
    //Show notification bubble at admin page for pending posts
    add_filter('add_menu_classes', array($this, 'notification_bubble'));
  }

  public function new_column($columns)
  {
    unset($columns['taxonomy-flexi_category']);
    unset($columns['taxonomy-flexi_tag']);

    $new_columns = array(
      //  'cb'                      => $columns['cb'],

      // 'title'                   => __('Title'),
      // 'author'                  => __('Author'),
      'taxonomy-flexi_category' => __('Categories'),
      'taxonomy-flexi_tag'      => __('Tags'),
      'flexi_layout'            => __('Detail Layout', 'flexi'),
      'image'                   => __('Image'),
      // 'date'                    => __('Date'),

    );

    return array_merge_recursive($columns, $new_columns);
  }

  public function manage_flexi_columns($column, $post_id)
  {
    switch ($column) {
      case 'flexi_layout':
        $layout = "default";

        $all_flexi_fields = get_post_custom($post_id);

        if (isset($all_flexi_fields["flexi_layout"][0])) {
          $lname = $ltitle = $all_flexi_fields["flexi_layout"][0];
          if ('default' == $lname || '' == $lname) {
            $lname  = flexi_get_option('detail_layout', 'flexi_detail_settings', 'basic');
            $ltitle = 'Default';
          }

          $layout = '<a href="' . admin_url('admin.php?page=flexi_settings&tab=detail&section=flexi_detail_layout_' . $lname) . '">' . $ltitle . '</a>';
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
    for ($x = 1; $x <= 20; $x++) {
      $columns['flexi_field_' . $x] = 'flexi_field_' . $x;
    }
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

    for ($x = 1; $x <= 20; $x++) {
      if ('flexi_field_' . $x === $query->get('orderby')) {
        $query->set('meta_key', 'flexi_field_' . $x);
      }
    }
  }

  //Show notification at admin page for remaining draft , pending post
  //TODO show notifical at all post
  public function notification_bubble($menu)
  {

    $types    = array("flexi"); //You can provide the name of your post type here .e.g, array("POST_SLUG_HERE","clients")
    $statuses = array("draft", "pending"); // Here you can provide the statuses that you want to count and show.
    foreach ($types as $type) {
      $count = 0;
      foreach ($statuses as $status) {
        $num_posts = wp_count_posts($type, 'readable');

        if (!empty($num_posts->$status)) {
          $count += $num_posts->$status;
        }

        // build string to match in $menu array
        $menu_str = 'flexi';
      }
      // loop through $menu items, find match, add indicator

      //flexi_log($menu);
      foreach ($menu as $menu_key => $menu_data) {
        //flexi_log($menu_str . '--' . $menu_data[2]);

        if ($menu_str != $menu_data[2]) {
          continue;
        }

        //flexi_log($menu);
        $menu[$menu_key][0] .= " <span class='update-plugins count-$count'><span class='plugin-count'>" . number_format_i18n($count) . '</span></span>';
      }
    }
    return $menu;
  }
}
