<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="pure-u-1 pure-u-md-1-<?php echo $column; ?> flexi_gallery_child flexi_padding"
    id="flexi_<?php echo get_the_ID(); ?>" style="position: relative;" data-tags="<?php echo $tags; ?>">
<!-- Loop start -->


<div class="flexi-blog_basic">
  <div class="flexi-blog_basic_sub">
    <a href="#">
      <img
        src="<?php echo esc_url(flexi_image_src('thumbnail', $post)); ?>"
        alt="<?php echo $data['title']; ?>"
      />
    </a>
    <div>
      <h2><a href="#"><?php echo $data['title']; ?></a></h2>
      <p>
      <?php echo flexi_excerpt(20); ?>
      </p>
      <a href="#" class="read-more">Read more &rarr;</a>
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