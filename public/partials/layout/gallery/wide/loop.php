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

  <div class="fl-columns fl-is-gapless fl-card fl-mb-1 fl-mx-1 <?php echo $style_base_color; ?> <?php echo $style_text_color; ?>">

    <div class="fl-column fl-is-one-quarter">
      <div class="fl-image  <?php echo $data['popup']; ?>  flexi_effect" id="<?php echo $hover_effect; ?>">
        <?php echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">'; ?>
        <img src="<?php echo esc_url(flexi_image_src('thumbnail', $post)); ?>" alt="<?php echo $data['title']; ?>" />
        <div class="flexi_figcaption"><?php echo $data['title']; ?></div>
        </a>
      </div>

    </div>

    <div class="fl-column">
      <div class="fl-card-content fl-p-1">
        <div class="fl-title fl-is-6 fl-is-spaced <?php echo $style_title; ?>" style="<?php flexi_evalue_toggle('title', $evalue); ?>"><?php echo $data['title']; ?></div>
        <?php
        if (flexi_evalue_toggle('excerpt', $evalue) == '') {
          echo "<span>" . flexi_excerpt(20) . "</span>";
        }

        if (flexi_evalue_toggle('custom', $evalue) == '') {
          echo '<span>' . flexi_custom_field_loop($post, 'gallery', 5) . '</span>';
        }

        if (flexi_evalue_toggle('category', $evalue) == '') {
          echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . ' </div></span>';
        }

        if (flexi_evalue_toggle('tag', $evalue) == '') {
          echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div></span>';
        }

        ?>
        <?php echo  flexi_show_addon_gallery($evalue, get_the_ID(), 'all'); ?>
        <span class="flexi_set_bottom" style="<?php echo flexi_evalue_toggle('icon', $evalue); ?>"><?php echo flexi_show_icon_grid(); ?></span>

      </div>
    </div>

  </div>
  <!-- Loop End -->
</div>

<div class="godude-desc flexi_desc_<?php echo get_the_ID(); ?>">
  <p><?php echo flexi_excerpt(); ?></p>
</div>