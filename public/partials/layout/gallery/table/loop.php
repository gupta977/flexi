<?php
$data = flexi_image_data('thumbnail', $post, $popup);
?>
<div class="flexi_gallery_child" id="flexi_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
    <li class="flexi-table-row" >

      <div class="flexi-col flexi-col-2" data-label="<?php echo __("Title","flexi"); ?>">
      <div class="flexi_title_bold"> <?php echo $data['title']; ?></div>
       <?php
if (flexi_evalue_toggle('category', $evalue) == '') {
      echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-category", "flexi_category") . ' </div></span>';
     }
     
     if (flexi_evalue_toggle('tag', $evalue) == '') {
      echo '<span><div class="flexi_text_group">' . flexi_list_tags($post, "", "flexi_text_small", "dashicons dashicons-tag", "flexi_tag") . ' </div></span>';
     }
       ?>
       </div>
     
      <?php
 $count = 10;
 $c = 1;
 if (flexi_evalue_toggle('custom', $evalue) == '') {
     for ($x = 1; $x <= 10; $x++) {
         $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
         $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
         $value   = get_post_meta($post->ID, 'flexi_field_' . $x, '');
         if (!$value) {
            $value[0] = '';
           }
         if (is_array($display)) {
             if (in_array('gallery', $display)) {
                 echo ' <div class="flexi-col flexi-col-4" data-label="'.$label.'">'.$value[0].'</div>';

                 if ($count == $c) {
                     break;
                 }
                 $c++;
             }
         }
     }
 }
?>
      <div class="flexi-col flexi-col-1">
        
        <?php
  echo '<div class="' . $data['popup'] . '">';
  echo '<a ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
  echo '<img src="' . esc_url(flexi_image_src('thumbnail', $post)) . '">';
  echo '</a>';
  echo '</div>';
  ?>
  
  
        </div>
    </li>
</div>
<div class="godude-desc flexi_desc_<?php echo get_the_ID(); ?>">
    <p><?php echo flexi_custom_field_loop($post, 'popup', 1, false) ?></p>
    <p><?php echo flexi_excerpt(); ?></p>
    <p><?php echo flexi_show_icon_grid(); ?></p>
</div>