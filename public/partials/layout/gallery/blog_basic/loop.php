<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding"
    id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
<!-- Loop start -->


<div class="flexi-blog_basic">
  <div class="flexi-blog_basic_sub">
<div class="flexi-blog_basic_img <?php echo $data['popup']; ?> flexi_effect" id="<?php echo $hover_effect; ?>">
    <a <?php echo $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" border="0"'; ?>>
      <img
        src="<?php echo esc_url(flexi_image_src('thumbnail', $post)); ?>"
        alt="<?php echo $data['title']; ?>"
      />
      <?php echo ' <div class="flexi_figcaption" id="flexi_cap_' . get_the_ID() . '"></div>'; ?>
    </a>
</div>
    <div class="flexi-blog_basic_info">
      <h2><?php echo $data['title']; ?></h2>
      <p>
      <?php echo flexi_excerpt(20); ?>
      </p>
      <a href="<?php echo get_permalink(); ?>" class="read-more"><?php echo __('Read more', 'flexi'); ?> &rarr;</a>
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