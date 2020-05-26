<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
      <div class="flexi_masonry-item">
            <div class="flexi_effect <?php echo $data['popup']; ?>" id="<?php echo $hover_effect; ?>">


                  <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-src="' . $data['src'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img  class="flexi-fit_cover" src="<?php echo esc_url(flexi_image_src('medium', $post)); ?>">
                        <?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>

                        <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                              <div class="flexi_title"><?php echo $data['title']; ?></div>
                              <div class="flexi_p"><?php echo flexi_excerpt(); ?></div>
                        </div>
                  </a>



            </div>
      </div>
</div>
<div style="display: none;" id="flexi_inline_<?php echo get_the_ID(); ?>">
	<h2><?php echo $data['title']; ?></h2>
	<p>You are awesome.</p>
</div>
<script>
jQuery(document).ready(function() {
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<b><?php echo $data['title']; ?></b>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_custom_field_loop($post, 'popup', 1, false) ?>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_excerpt(); ?>');
      jQuery('#flexi_cap_<?php echo get_the_ID(); ?>').append('<br><?php echo flexi_show_icon_grid(); ?>');
});

</script>