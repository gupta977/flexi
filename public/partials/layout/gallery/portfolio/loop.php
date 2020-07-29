<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding"
  id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
  <!-- Loop start -->

  <div class="flexi-gallery-portfolio">
    <div class="flexi-gallery-portfolio_sub">
      <div class="flexi-gallery-portfolio_img <?php echo $data['popup']; ?> flexi_effect"
        id="<?php echo $hover_effect; ?>">

        <a
          <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0"'; ?>>
          <img src="<?php echo esc_url(flexi_image_src('medium', $post)); ?>" alt="<?php echo $data['title']; ?>" />

        </a>
      </div>
      <div class="flexi-gallery-portfolio_info">
        <h2 style="<?php echo flexi_evalue_toggle('title', $evalue); ?>"><?php echo $data['title']; ?></h2>
        <span
          style="<?php echo flexi_evalue_toggle('custom', $evalue); ?>"><?php echo flexi_custom_field_loop($post, 'gallery', 2); ?></span>
        <p style="<?php echo flexi_evalue_toggle('excerpt', $evalue); ?>"><?php echo flexi_excerpt(20); ?></p>

        <?php
echo '<span style="' . flexi_evalue_toggle('category', $evalue) . '"><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . ' </div></span>';
echo '<span style="' . flexi_evalue_toggle('tag', $evalue) . '"><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div></span>';
?>
        <span style="<?php echo flexi_evalue_toggle('icon', $evalue); ?>"><?php echo flexi_show_icon_grid(); ?></span>
      </div>
    </div>
  </div>
  <!-- Loop End -->
</div>
<div class="godude-desc flexi_desc_<?php echo get_the_ID(); ?>">
  <p><?php echo flexi_excerpt(); ?></p>
</div>