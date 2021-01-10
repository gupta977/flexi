<?php
//Displays Toolbar
$toolbar = new Flexi_Gallery_Toolbar();
if (false == $clear) {
?>
   <div class="pure-g">
      <div class="pure-u-1-3" style="text-align:left;">
         <?php do_action('flexi_gallery_top_center', $atts) ?>
      </div>
      <div class="pure-u-1-3" style="text-align:center;">
         <div class="flexi_label"><?php echo $toolbar->label(); ?></div>
      </div>
      <div class="pure-u-1-3" style="text-align:right;">
         <?php do_action('flexi_gallery_top_right', $atts) ?>
      </div>
   </div>
   <style>
      .flexi_gallery_sidebar {
         padding-left: 10px;
         padding-right: 10px;
         margin: 15px 0px;
         border-radius: 6px;
      }

      .flexi_gallery_sidebar .flexi_frame_4 {
         margin-bottom: 10px;
      }

      .flexi_gallery_sidebar .widget-title {
         font-family: "Poppins", sans-serif;
         font-size: 1.125rem;
         font-weight: 700;
         letter-spacing: 0.0625rem;
         padding: 0;
         position: relative;
         margin: 10px;
      }

      .flexi_gallery_sidebar .widget_categories {
         list-style: none;
      }
   </style>

<?php
}
//Display tags
if ($show_tag) {
   echo flexi_generate_tags($tags_array, 'flexi_tag--inverse', 'filter_tag') . "<div style='clear:both;'></div>";
}
//var_dump($evalue);
if (false == $clear && is_active_sidebar('flexi-gallery-sidebar') &&  is_flexi_page('primary_page', 'flexi_image_layout_settings')) {

   echo "<div class='pure-g'><div class='pure-u-3-5'>";
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