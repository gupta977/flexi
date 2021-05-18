<?php
//Displays Toolbar
$toolbar = new Flexi_Gallery_Toolbar();
if (false == $clear) {
?>
<?php echo $toolbar->label(); ?>

<?php
}
//Display tags
if ($show_tag) {
   $style_tag = flexi_app_style('flexi_style_tag', 'fl-tag');

   echo flexi_generate_tags($tags_array, $style_tag, 'filter_tag') . "<div style='clear:both;'></div>";
}
//var_dump($evalue);
if (false == $clear && is_active_sidebar('flexi-gallery-sidebar') &&  is_flexi_page('primary_page', 'flexi_image_layout_settings')) {

   echo '<div class="fl-columns"><div class="fl-column fl-is-three-quarters">';
}


?>

<?php
//Attach header gallery based based on layout selection
$header_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/header.php';
if (file_exists($header_file)) {
   require $header_file;
}

//Turn off pagination at guten block editor
if (defined('REST_REQUEST') && REST_REQUEST) {
   $navigation = "off";
}
?>