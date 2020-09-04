<?php
//Attach footer of gallery based based on layout selection
$footer_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/footer.php';
if (file_exists($footer_file)) {
 require $footer_file;
}
?>
<style>
:root {
  --flexi_category_padding: <?php echo $padding; ?>;
}
  </style>