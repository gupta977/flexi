<?php
//Displays Toolbar
$toolbar = new Flexi_Gallery_Toolbar();
if (false == $clear) {
 ?>
<div class="flexi_label"><?php echo $toolbar->label(); ?></div>

<?php
}
//Display tags
if ($show_tag) {
 echo flexi_generate_tags($tags_array, 'flexi_tag--inverse', 'filter_tag') . "<div style='clear:both;'></div>";
}
//var_dump($evalue);
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

if ('scroll' == $navigation || 'button' == $navigation) {

 ?>

 <?php
}
