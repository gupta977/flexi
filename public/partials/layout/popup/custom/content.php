<div id="flexi_content_<?php echo get_the_ID(); ?>" style="width:<?php echo $l_width; ?>px;height=<?php echo $l_height; ?>px;" class="flexi_popup_custom">
  <div class="fl-columns fl-is-multiline">
    <div class="fl-column fl-is-full">
      <div style='text-align: center;'>
        <?php do_action('flexi_location_1', '1', $post, 'custom'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-full">
      <div style='text-align: center;'>
        <?php do_action('flexi_location_2', '2', $post, 'custom'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-half">
      <div style='text-align: left;'>
        <?php do_action('flexi_location_3', '3', $post, 'custom'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-half">
      <div style='text-align: right;'>
        <?php do_action('flexi_location_4', '4', $post, 'custom'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-full">
      <div>
        <?php do_action('flexi_location_5', '5', $post, 'custom'); ?>
      </div>
    </div>
  </div>
</div>