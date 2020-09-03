<?php
//$data = flexi_image_data('thumbnail', $post, $popup);
$link = get_permalink(flexi_get_option('primary_page', 'flexi_image_layout_settings', 0));
$link = add_query_arg("flexi_category", $term->slug, $link);
echo '<div class="flexi_responsive flexi_gallery_child" id="flexi_' . get_the_ID() . '">';
echo '<div class="flexi_gallery_grid">';
?>

<div class="flexi-list-small">

        <?php
echo '<div class="flexi-image-wrapper flexi-list-sub flexi_effect" id="' . $hover_effect . '">';
echo '<a href="'.$link.'" data-caption="" data-src="" border="0">';
echo '<img src="'.flexi_album_image($term->slug).'">';
flexi_log($term);
?>
                  <div id="flexi_info" class="<?php echo $hover_caption; ?>">
                        <div class="flexi_title"><?php echo  $term->name; ?></div>
                        <div class="flexi_p"><?php echo  $count_result; ?></div>
                  </div>
<?php
echo '</a>';
echo '</div>';
?>

        <div class="flexi_details" style="<?php echo flexi_evalue_toggle('title', $evalue); ?>">
            <h3><?php echo $term->name; ?></h3>
        </div>

</div>
</div>
</div>