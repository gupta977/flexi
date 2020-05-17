<?php
//Attach footer of gallery based based on layout selection

$footer_file = FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/' . $layout . '/footer.php';
if (file_exists($footer_file)) {
 require $footer_file;
}

//If AJAX loading is enabled

if ('scroll' == $navigation || 'button' == $navigation) {
// AJAX lazy loading
 echo "<div style='clear:both;'></div>";
 echo "<div id='flexi_load_more' style='text-align:center'><a id='load_more_link' class='flexi_load_more pure-button' style='margin:5px; font-size: 80%;' href='#'>Load More</a></div>";
 echo "<div id='reset' style='display:none'>false</div>";
 echo "<a id='load_more_reset' class='flexi_load_more' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=flexi_load_more' data-post_id='" . get_the_ID() . "' data-paged='" . $query->max_num_pages . "' data-reset='true'></a>";
 ?>
<div id='flexi_loader_gallery' style='display: none;text-align:center;'>
 <img src="<?php echo FLEXI_PLUGIN_URL . '/public/images/loading.gif'; ?>">

 </div>


<script>
//Load first record on page load
jQuery(document).ready(function() {
    jQuery('#load_more_link').click();

})
</script>
<?php
} else {
 //Load basic page loading with other plugin support

 echo flexi_page_navi($query);
}
echo "<div id='gallery_layout' style='display:none'>" . $layout . "</div>";
echo "<div id='popup' style='display:none'>" . $popup . "</div>";
echo "<div id='album' style='display:none'>" . $album . "</div>";
echo "<div id='max_paged' style='display:none'>" . $query->max_num_pages . "</div>";
echo "<div id='search' style='display:none'>" . $search . "</div>";
echo "<div id='postsperpage' style='display:none'>" . $postsperpage . "</div>";
echo "<div id='column' style='display:none'>" . $column . "</div>";
echo "<div id='orderby' style='display:none'>" . $orderby . "</div>";
echo "<div id='user' style='display:none'>" . $user . "</div>";
echo "<div id='keyword' style='display:none'>" . $keyword . "</div>";
echo "<div id='padding' style='display:none'>" . $padding . "</div>";
echo "<div id='hover_effect' style='display:none'>" . $hover_effect . "</div>";
echo "<div id='hover_caption' style='display:none'>" . $hover_caption . "</div>";
echo "<div id='evalue' style='display:none'>" . $evalue . "</div>";
echo "<div id='attach' style='display:none'>" . $attach . "</div>";
echo "<div id='attach_id' style='display:none'>" . $cur_page_id . "</div>";
echo "<div id='filter' style='display:none'>" . $filter . "</div>";
?>
<style>
:root {
  --flexi_user_width: <?php echo $width; ?>px;
  --flexi_user_height: <?php echo $height; ?>px;
  --flexi_user_column: <?php echo $column; ?>;
}
  </style>