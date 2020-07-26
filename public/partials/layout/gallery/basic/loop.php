<?php
$data = flexi_image_data('thumbnail', $post, $popup);

echo '<div class="flexi_responsive flexi_gallery_child" id="flexi_' . get_the_ID() . '"  data-tags="' . $tags . '">';
echo '<div class="flexi_gallery_grid">';
?>

<div class="flexi-list-small">

        <?php
echo '<div class="flexi-image-wrapper flexi-list-sub ' . $data['popup'] . ' flexi_effect" id="' . $hover_effect . '">';
echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
echo '<img src="' . esc_url(flexi_image_src('medium', $post)) . '">';
?>
                  <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                        <div class="flexi_title"><?php echo $data['title']; ?></div>
                        <div class="flexi_p"><?php echo flexi_excerpt(); ?></div>
                  </div>
<?php
echo '</a>';
echo '</div>';
?>

        <div class="flexi_details" style="<?php echo flexi_evalue_toggle('title', $evalue); ?>">
            <h3><?php echo $data['title']; ?></h3>
        </div>

</div>
</div>
</div>