<div id="flexi_content_<?php echo get_the_ID(); ?>" class="flexi_basic_layout">
  <div class="fl-columns fl-is-multiline">
    <div class="fl-column fl-is-full">
      <div style='text-align: center;'>
        <?php do_action('flexi_location_1', '1', $post, 'basic'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-full">
      <div style='text-align: center;'>
        <?php do_action('flexi_location_2', '2', $post, 'basic'); ?>
      </div>
    </div>
    <div class="fl-column fl-is-half">
      <div style='text-align: left;'>
        <?php do_action('flexi_location_3', '3', $post, 'basic'); ?>
      </div>

    </div>
    <div class="fl-column fl-is-half">
      <div style='text-align: right;'>
        <?php do_action('flexi_location_4', '4', $post, 'basic'); ?>
      </div>
    </div>
    <div class="fl-column bd-notification fl-is-full">
      <div>
        <?php do_action('flexi_location_5', '5', $post, 'basic'); ?>
      </div>
    </div>
  </div>
</div>