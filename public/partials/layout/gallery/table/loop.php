<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
    <li class="flexi-table-row">
      <div class="flexi-col flexi-col-1" data-label="ddd">
        
      <?php
echo '<div class="' . $data['popup'] . '">';
echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
echo '<img src="' . esc_url(flexi_image_src('thumbnail', $post)) . '">';
echo '</a>';
echo '</div>';
?>


      </div>
      <div class="flexi-col flexi-col-2" data-label="Customer Name"> <?php echo $data['title']; ?></div>
      <div class="flexi-col flexi-col-3" data-label="Amount">$350</div>
      <div class="flexi-col flexi-col-4" data-label="Payment Status">
        
<?php if (flexi_evalue_toggle('custom', $evalue) == '') {
 echo '<span>' . flexi_custom_field_loop($post, 'gallery', 2) . '</span>';
}
?>

      </div>
    </li>