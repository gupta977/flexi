<style>
.flexi_basic_width_category_<?php echo $width; ?> .flexi-image-wrapper {
  width: <?php echo $width; ?>px;
  height: <?php echo $height; ?>px;
}

.flexi_basic_width_category_<?php echo $width; ?> .flexi-list-sub {
    width: <?php echo $width; ?>px;
  height: <?php echo $height; ?>px;
}

@media only screen and (max-width: 768px) {
  .flexi_basic_width_category_<?php echo $width; ?> .flexi-list-sub {
    width: 100%;
  }
}

.flexi_basic_width_category_<?php echo $width; ?> .flexi-list-sub > a {
    height: <?php echo $height; ?>px;
}

    </style>
<div id="flexi_gallery" class="flexi_basic_width_category_<?php echo $width; ?>">
<div id="flexi_main_loop">
