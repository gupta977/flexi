<?php

$flexi_link_sub_cate = get_term_meta($term->term_id, 'flexi_link_sub_cate', true);
if ("on" == $flexi_link_sub_cate) {
    $link = add_query_arg("flexi_category", $term->slug, $category_page_link);
} else {
    $link = add_query_arg("flexi_category", $term->slug, $primary_page_link);
}
echo '<div class="flexi_responsive flexi_gallery_child" id="flexi_' . get_the_ID() . '">';
echo '<div class="flexi_gallery_grid">';
?>

<div class="flexi-list-small_category">

    <?php
    echo '<div class="flexi-image-wrapper flexi-list-sub_category">';
    echo '<a href="' . $link . '" data-caption="" data-src="" border="0">';
    echo '<img src="' . flexi_album_image($term->slug) . '">';

    echo '</a>';
    echo '</div>';
    ?>

    <div class="flexi_details_category">
        <h3><?php echo $term->name; ?> <?php echo  $count_result; ?></h3>
    </div>

</div>
</div>
</div>