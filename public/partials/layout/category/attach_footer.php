<?php
//Attach footer of gallery based based on layout selection
$footer_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/footer.php';
if (file_exists($footer_file)) {
  require $footer_file;
}
if (is_active_sidebar('flexi-gallery-sidebar') &&  is_flexi_page('category_page', 'flexi_categories_settings')) {

  echo "</div><div class='pure-u-1-1 pure-u-md-1-5'><div class='flexi_gallery_sidebar'>";
  dynamic_sidebar('flexi-gallery-sidebar');
  echo "</div></div></div>";
}
?>
<style>
  :root {
    --flexi_category_padding: <?php echo $padding; ?>;
  }
</style>