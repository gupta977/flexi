<?php

if (is_active_sidebar('flexi-gallery-sidebar') &&  is_flexi_page('category_page', 'flexi_categories_settings')) {

    //echo "<div class='pure-g'><div class='pure-u-1-1 pure-u-md-4-5'>";
    echo '<div class="fl-columns"><div class="fl-column fl-is-three-quarters">';
}


//Attach header gallery based based on layout selection
$header_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/category/' . $layout . '/header.php';
if (file_exists($header_file)) {
    require $header_file;
}
