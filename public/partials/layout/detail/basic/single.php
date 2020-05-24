<div id="flexi_content_<?php echo get_the_ID(); ?>" class="flexi_complex_layout">
  <div class="pure-g">
  <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_1', '1', $post, 'basic');?>
      </div>
    </div>

    <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_2', '2', $post, 'basic');?>
      </div>
    </div>

    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: left;'>
      <?php do_action('flexi_location_3', '3', $post, 'basic');?>
      </div>
    </div>
    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: right;'>
      <?php do_action('flexi_location_4', '4', $post, 'basic');?>
      </div>
    </div>


    <div class="pure-u-1">
      <div class="flexi_margin-box">
      <?php do_action('flexi_location_5', '5', $post, 'basic');?>
      </div>
    </div>

  </div>
</div>