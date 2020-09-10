<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
    <li class="flexi-table-row">
      <div class="flexi-col flexi-col-1" data-label="Job Id">42235</div>
      <div class="flexi-col flexi-col-2" data-label="Customer Name"> <?php echo $data['title']; ?></div>
      <div class="flexi-col flexi-col-3" data-label="Amount">$350</div>
      <div class="flexi-col flexi-col-4" data-label="Payment Status">Pending</div>
    </li>