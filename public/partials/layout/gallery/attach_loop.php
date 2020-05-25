<?php
$tags = flexi_get_taxonomy_raw($post->ID, 'flexi_tag');

//If classic page navigation selected
if ('page' == $navigation || 'off' == $navigation) {
 //Attach loop gallery based based on layout selection
 $loop_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/loop.php';
 if (file_exists($loop_file)) {
  require $loop_file;
 }

} else {
 //Above specified variable will not be passed to ajax loading
 //Specify at
 //1- flexi_load_more.php > $_REQUEST
 //2- flexi_load_more_button.js (2 places)
 //3- flexi_load_more_scroll.js (2 places)
 //4- class-flexi-gallery.php > $params
 //5- attach_footer.php > <div>
 //WP_QUERY & loop is executed at includes\flexi_load_more.php
}
