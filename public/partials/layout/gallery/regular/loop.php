<?php
$data = flexi_image_data('thumbnail', $post, $popup);
echo '<div id="flexi_main_loop">';
echo '<div class="flexi_responsive flexi_gallery_child" id="flexi_' . get_the_ID() . '"  data-tags="' . $tags . '">';
echo '<div class="flexi_gallery_grid flexi_padding flexi_effect ' . $data['popup'] . '" id="' . $hover_effect . '">';
echo '<div class="flexi-image-wrapper" style="border: 1px solid #eee">';
echo '<a class="" href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0">';
echo '<img src="' . esc_url(flexi_image_src('medium', $post)) . '">';
?>
<?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>

                  <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                        <div class="flexi_title"><?php echo $data['title']; ?></div>
                        <div class="flexi_p"><?php echo flexi_excerpt(); ?></div>
                  </div>
<?php
echo '</a>';
echo '</div>';
echo "</div>";
echo "</div>";
echo "</div>";
?>
<script>
jQuery(document).ready(function() {
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_custom_field_loop($post, 'popup', 1, false) ?>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_show_icon_grid(); ?>');
});

</script>