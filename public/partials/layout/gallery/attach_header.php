<?php
//Displays Toolbar
$toolbar = new Flexi_Gallery_Toolbar();
if (false == $clear) {
 ?>
 <div class="pure-g">
    <div class="pure-u-1-3" style="text-align:left;">
    <div class="flexi_label"><?php echo $toolbar->label(); ?></div>
       </div>
    <div class="pure-u-1-3" style="text-align:center;">
    <?php do_action('flexi_gallery_top_center')?>
    </div>
    <div class="pure-u-1-3" style="text-align:right;">
    <?php do_action('flexi_gallery_top_right')?>
    </div>
</div>


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
