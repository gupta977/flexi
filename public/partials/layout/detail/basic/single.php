<div id="flexi_content_<?php echo get_the_ID(); ?>">
  <div class="pure-g">
  <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_1', '1', $post, 'complex');?>
      </div>
    </div>

    <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
      <?php do_action('flexi_location_2', '2', $post, 'complex');?>
      </div>
    </div>

    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: left;'>
      <?php do_action('flexi_location_3', '3', $post, 'complex');?>
      </div>
    </div>
    <div class="pure-u-1-2">
      <div class="flexi_margin-box" style='text-align: right;'>
      <?php do_action('flexi_location_4', '4', $post, 'complex');?>
      </div>
    </div>


    <div class="pure-u-1">
      <div class="flexi_margin-box">
      <?php do_action('flexi_location_5', '5', $post, 'complex');?>
      </div>
    </div>

  </div>
</div>