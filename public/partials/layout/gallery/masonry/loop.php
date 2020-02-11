<?php
$data = flexi_image_data('flexi-thumb', $post, $popup);
?>

<div class="flexi_gallery_child flexi_padding" id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
      <div class="masonry-item">
            <div class="flexi_effect flexi_media_holder" id="<?php echo $hover_effect; ?>">


                  <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
                        <img  class="flexi-fit_cover flexi_image_frame" src="<?php echo esc_url(flexi_image_src('flexi-medium', $post)); ?>">
                        <?php echo ' <flexi_figcaption><b>' . $data['title'] . '</b><br>' . flexi_excerpt() . '</flexi_figcaption>'; ?>

                        <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                              <div class="flexi_title"><?php echo $data['title']; ?></div>
                              <div class="flexi_p"><?php echo flexi_excerpt(); ?></div>
                        </div>
                  </a>
            </div>
      </div>
</div>


