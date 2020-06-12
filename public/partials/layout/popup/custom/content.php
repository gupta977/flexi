<div id="flexi_content_<?php echo get_the_ID(); ?>" style="width:<?php echo $l_width; ?>px;height=<?php echo $l_height; ?>px" class="flexi_popup_custom">
  <div class="pure-g">
  <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_1', '1', $post, 'custom');?>
      </div>
    </div>

    <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_2', '2', $post, 'custom');?>
      </div>
    </div>

    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: left;'>
      <?php do_action('flexi_location_3', '3', $post, 'custom');?>
      </div>
    </div>
    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: right;'>
      <?php do_action('flexi_location_4', '4', $post, 'custom');?>
      </div>
    </div>
    <div class="pure-u-1">
      <div class="flexi_margin-box">
      <?php do_action('flexi_location_5', '5', $post, 'custom');?>
      </div>
    </div>

  </div>
</div>