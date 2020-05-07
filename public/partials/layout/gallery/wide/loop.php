<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding"
    id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
<!-- Loop start -->


<div class="flexi-gallery-wide flexi_frame_2">
  <div class="flexi-gallery-wide_sub">
    <div class="flexi-gallery-wide_img <?php echo $data['popup']; ?>  flexi_effect" id="<?php echo $hover_effect; ?>">
    <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
    <img
        src="<?php echo esc_url(flexi_image_src('medium', $post)); ?>"
        alt="<?php echo $data['title']; ?>"
      />
</a>
</div>
    <div class="flexi-gallery-wide_info">
    <h2 style="<?php flexi_evalue_toggle('title', $evalue);?>"><?php echo $data['title']; ?></h2>
      <span style="<?php flexi_evalue_toggle('custom', $evalue);?>"><?php echo flexi_custom_field_loop($post, 'gallery', 2); ?></span>
      <p style="<?php flexi_evalue_toggle('excerpt', $evalue);?>"><?php echo flexi_excerpt(20); ?></p>

      <span class="flexi_set_bottom" style="<?php flexi_evalue_toggle('icon', $evalue);?>"><?php echo flexi_show_icon_grid(); ?></span>

    </div>
  </div>
</div>


<!-- Loop End -->
</div>
<script>
jQuery(document).ready(function() {
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
    jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
});
</script>