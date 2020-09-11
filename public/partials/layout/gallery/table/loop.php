<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
    <li class="flexi-table-row">
      <div class="flexi-col flexi-col-1">
        
      <?php
echo '<div class="' . $data['popup'] . '">';
echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
echo '<img src="' . esc_url(flexi_image_src('thumbnail', $post)) . '">';
echo '</a>';
echo '</div>';
?>


      </div>
      <div class="flexi-col flexi-col-2" data-label="<?php echo __("Title","flexi"); ?>">
       <?php echo $data['title']; ?>
       <?php
if (flexi_evalue_toggle('category', $evalue) == '') {
      echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . ' </div></span>';
     }
     
     if (flexi_evalue_toggle('tag', $evalue) == '') {
      echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div></span>';
     }
       ?>
       </div>
      <div class="flexi-col flexi-col-3" data-label="Amount">$350</div>
      <div class="flexi-col flexi-col-4" data-label="Payment Status">
        
<?php if (flexi_evalue_toggle('custom', $evalue) == '') {
 echo '<span>' . flexi_custom_field_loop($post, 'gallery', 2) . '</span>';
}
?>

      </div>
    </li>