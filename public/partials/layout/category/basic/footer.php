</div>
</div>
<div style="clear: both; display: block; position: relative;"></div>
<?php
if (0 == $count_category) {
    echo '<div id="flexi_no_record" class="flexi_alert-box flexi_notice">' . __('No category', 'flexi') . '</div>';
} else {
    $link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
    $link = add_query_arg('flexi_category', $term_slug, $link);
    echo "<a href='" . $link . "' class='" . $style_button . " fl-is-fullwidth'>" . __("View all", "flexi") . "</a>";
}

?>