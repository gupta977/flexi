<ul class="flexi-responsive-table">
<li class="flexi-table-header">
    
      <div class="flexi-col flexi-col-2"><?php echo __("Title","flexi"); ?></div>
   
     
      <?php
 $count = 10;
 $c = 1;
 if (flexi_evalue_toggle('custom', $evalue) == '') {
     for ($x = 1; $x <= 10; $x++) {
         $label   = flexi_get_option('flexi_field_' . $x . '_label', 'flexi_custom_fields', '');
         $display = flexi_get_option('flexi_field_' . $x . '_display', 'flexi_custom_fields', '');
         if (is_array($display)) {
             if (in_array('gallery', $display)) {
                 echo '<div class="flexi-col flexi-col-4">'. $label .'</div>';

                 if ($count == $c) {
                     break;
                 }
                 $c++;
             }
         }
     }
 }
?>
  <div class="flexi-col flexi-col-1"></div>
    </li>
	<div id="flexi_main_loop">