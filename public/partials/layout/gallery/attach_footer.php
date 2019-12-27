<?php
//Attach footer of gallery based based on layout selection
require FLEXI_PLUGIN_DIR  . 'public/partials/layout/gallery/masonry/footer.php';

//If AJAX loading is enabled
$navigation=flexi_get_option('navigation', 'flexi_image_layout_settings', 'scroll');
if($navigation=='scroll' || $navigation=='button')
{
// AJAX lazy loading
    echo "<div style='clear:both;'></div>";
    echo "<div id='flexi_load_more' style='text-align:center'><a id='load_more_link' class='flexi_load_more pure-button pure-button-primary' style='margin:5px; font-size: 80%;' href='admin-ajax.php?action=flexi_load_more'>Load More</a></div>";
    echo "<div id='gallery_layout' style='display:none'>" . $layout . "</div>";
    echo "<div id='popup' style='display:none'>" .  $popup . "</div>";
    echo "<div id='paged' style='display:none'>" .  $query->max_num_pages . "</div>";
    echo "<div id='reset' style='display:none'>false</div>";
?>

<script>
//Load first record on page load
jQuery(document).ready(function() {
    jQuery('#load_more_link').click();
})
</script>
<?php
}
else
{
    //Load basic page loading with other plugin support
    if (function_exists('wp_pagenavi')) 
    {
        echo "" . wp_pagenavi(array('query' => $query));
    }

}
?>