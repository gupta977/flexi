<?php
 //Attach loop gallery based based on layout selection
 $loop_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/loop.php';
 if (file_exists($loop_file)) {
  require $loop_file;
 }
 ?>
