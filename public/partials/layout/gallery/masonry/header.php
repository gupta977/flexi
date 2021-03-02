<style>
        @media only screen and (min-width: 1024px) {
                .flexi_column_<?php echo $column . ' .flexi_masonry'; ?> {
                        columns: <?php echo $column; ?>;
                }
        }
</style>
<div id="flexi_gallery" class="fl-columns fl-is-multiline flexi_column_<?php echo $column; ?>">
        <div class="fl-column fl-is-full">
                <div class="flexi_masonry" id="flexi_main_loop">