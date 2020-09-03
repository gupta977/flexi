<?php
//Attach header gallery based based on layout selection
$header_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/header.php';
if (file_exists($header_file)) {
 require $header_file;
}
?>