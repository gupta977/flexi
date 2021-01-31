<?php
$data = flexi_image_data('thumbnail', get_the_ID(), $popup);
?>
<div class="flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
      <div class="flexi_masonry-item">
            <div class="flexi_effect <?php echo $data['popup']; ?>" id="<?php echo $hover_effect; ?>">

                  <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-src="' . $data['src'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img class="flexi-fit_cover" src="<?php echo esc_url(flexi_image_src('medium', $post)); ?>">

                        <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                              <div class="flexi_title"><?php echo $data['title']; ?></div>
                              <div class="flexi_p"><?php echo flexi_excerpt(); ?></div>
                        </div>
                        <div class="flexi_figcaption"><?php echo $data['title']; ?></div>
                  </a>

            </div>
      </div>
</div>
<div style="display: none;" id="flexi_inline_<?php echo get_the_ID(); ?>">
      <h2><?php echo $data['title']; ?></h2>
</div>
<div class="godude-desc flexi_desc_<?php echo get_the_ID(); ?>">
      <p><?php echo flexi_custom_field_loop($post, 'popup', 1, false) ?></p>
      <p><?php echo flexi_excerpt(); ?></p>
      <p><?php echo flexi_show_icon_grid(); ?></p>
</div>