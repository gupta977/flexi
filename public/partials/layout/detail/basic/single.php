<?php
/*
<a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
<?php echo __('Edit Post', 'flexi'); ?>
</a>
 */
?>

<div id="flexi_content_<?php echo get_the_ID(); ?>">

  <div class="pure-g">
    <div class="pure-u-1-1">
      <div class="flexi_margin-box" style='text-align: center;'>
        <?php if (get_post_status() == 'draft' || get_post_status() == "pending") {?><small>
          <div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div>
        </small><?php }?>
        <?php
echo "<div class='flexi-image-wrapper_large'>" . flexi_large_media($post) . "</div>";
?>
        <?php echo flexi_show_icon_grid(); ?>

      </div>
    </div>
    <div class="pure-u-1">
      <div class="flexi_margin-box">
       <div id="flexi_thumb_image" style='text-align: center;'> <?php flexi_standalone_gallery(get_the_ID(), 'thumbnail', 75, 75);?></div>
      </div>
    </div>
    <div class="pure-u-1">
      <div class="flexi_margin-box">

        <div class="flex-desp"> <?php echo wpautop(stripslashes($post->post_content)); ?></div>

      </div>
    </div>
  </div>
  <div class="pure-g">
    <div class="pure-u-1 pure-u-md-1-2">
      <div class="flexi_margin-box">
        <?php flexi_list_tags($post, 'flexi_tag flexi_tag-default');?>
      </div>
    </div>
    <div class="pure-u-1 pure-u-md-1-2">
      <div class="flexi_margin-box">
        <?php
echo flexi_custom_field_loop($post, 'detail');
?>
      </div>

    </div>

  </div>
  <?php
//echo flexi_file_src($post) . "----<hr>";
//echo flexi_file_src($post, false) . "----";
// This would output '/client/?s=word&foo=bar&baz=tiny'
$arr_params = array('download' => $post->ID);
$src        = esc_url(add_query_arg($arr_params), get_permalink($post->ID));
?>

  <?php flexi_list_album($post, 'flexi-icon-list-frame');?>

</div>

<?php
if (isset($_GET['download'])) {
 //$file = $_GET['download'];

 //$file = "http://localhost/wp5/wp-content/uploads/2020/01/20200111_174431-scaled.jpg";

// if (file_exists($file)) {
 //flexi_log("i found...");
 //header('Content-Type: image/jpeg');
 //header("Content-Disposition: attachment; filename=\"$file\"");
 //readfile($file);
 //} else {
 // flexi_log("no url");
 // }
}
?>