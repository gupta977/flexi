<?php
$detail_layout = get_post_meta($post->ID, 'flexi_layout', 'basic');
if ('default' == $detail_layout || '' == $detail_layout) {
 $detail_layout = flexi_get_option('detail_layout', 'flexi_detail_settings', 'basic');
}

if (empty($detail_layout)) {
 $detail_layout = "basic";
}

$file = FLEXI_PLUGIN_DIR . 'public/partials/layout/detail/' . $detail_layout . '/single.php';
if (file_exists($file)) {
 require $file;
} else {
 echo "Detail Layout Not found: " . $detail_layout;
}
