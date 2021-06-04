<?php
$data = flexi_image_data('thumbnail', get_the_ID(), $popup);
if ($column == "1") {
  $column_set = "12";
} else if ($column == "2") {
  $column_set = "6";
} else if ($column == "3") {
  $column_set = "4";
} else {
  $column_set = "3";
}

$style_base_color = flexi_get_option('flexi_style_base_color', 'flexi_app_style_settings', '');
$style_text_color = flexi_get_option('flexi_style_text_color', 'flexi_app_style_settings', '');
$style_title = flexi_get_option('flexi_style_heading', 'flexi_app_style_settings', 'fl-is-4 fl-mb-1');
?>

<div class="fl-column fl-is-<?php echo $column_set; ?> flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
  <!-- Loop start -->
  <div class="fl-card <?php echo $style_base_color; ?>">
    <div class="fl-card-image">
      <div class="fl-image flexi-gallery-portfolio_sub">
        <div class="flexi-gallery-portfolio_img <?php echo $data['popup']; ?> flexi_effect" id="<?php echo $hover_effect; ?>">
          <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0"'; ?>>
            <img src="<?php echo esc_url(flexi_image_src('medium', $post)); ?>" alt="<?php echo $data['title']; ?>" />
            <div class="flexi_figcaption"><?php echo $data['title']; ?></div>
          </a>
        </div>
      </div>
    </div>
    <div class="fl-card-content">
      <div class="fl-title <?php echo $style_title; ?>" style="<?php echo flexi_evalue_toggle('title', $evalue); ?>"><?php echo $data['title']; ?></div>

      <?php
      //Display excerpt
      if (flexi_evalue_toggle('excerpt', $evalue) != 'display:none') {
      ?>
        <div class="fl-content fl-mb-1 fl-is-size-6 <?php echo $style_text_color; ?>">
          <?php echo flexi_excerpt(20); ?>
        </div>
      <?php
      }
      ?>


      <?php
      //Display profile icon or avatar
      if (flexi_evalue_toggle('profile_icon', $evalue) != 'display:none') {
        echo flexi_author();
      }
      ?>

      <?php
      //Custom php_field functions
      //0=Label, 1-Function, 2-parameter2 3-parameter3, 4-parameter4
      $php_func = flexi_php_field_value($php_field, 1);
      $param_1 = flexi_php_field_value($php_field, 2);
      $param_2 = flexi_php_field_value($php_field, 3);
      $param_3 = flexi_php_field_value($php_field, 4);

      for ($x = 0; $x < count($php_func); $x++) {

        if (!isset($param_1[$x]))
          $param_1[$x] = "";

        if (!isset($param_2[$x]))
          $param_2[$x] = "";

        if (!isset($param_3[$x]))
          $param_3[$x] = "";

        echo '<div>' . flexi_php_field_execute($php_func[$x], $param_1[$x], $param_2[$x], $param_3[$x]) . '</div>';
      }


      if (flexi_evalue_toggle('category', $evalue) != 'display:none')
        echo flexi_custom_field_loop($post, 'gallery', 5);

      if (flexi_evalue_toggle('category', $evalue) != 'display:none')
        echo '<div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . '</div>';

      if (flexi_evalue_toggle('tag', $evalue) != 'display:none')
        echo '<div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div>';

      if (flexi_evalue_toggle('author', $evalue) != 'display:none') {

        echo '<span class="fl-icon-text">
        <span class="fl-icon">
        <i class="fas fa-user-alt"></i>
        </span>
        <span>' . flexi_author('', true, false) . '</span>
      </span>';
      }

      if (flexi_evalue_toggle('date', $evalue) != 'display:none') {
        echo '<span class="fl-icon-text">
                <span class="fl-icon">
                  <i class="far fa-calendar-alt"></i>
                </span>
                <span>' . get_the_date() . '</span>
              </span>';
      }


      if (flexi_evalue_toggle('icon', $evalue) != 'display:none')
        echo flexi_show_icon_grid();
      ?>

    </div>
    <?php echo  flexi_show_addon_gallery($evalue, get_the_ID(), 'portfolio'); ?>

  </div>

  <!-- Loop End -->
</div>
<div class="godude-desc flexi_desc_<?php echo get_the_ID(); ?>">
  <p><?php echo flexi_excerpt(); ?></p>
</div>