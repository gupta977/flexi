<?php
/*
<a href='<?php echo flexi_get_button_url(get_the_ID(), false, 'edit_flexi_page', 'flexi_form_settings'); ?>'>
<?php echo __('Edit Post', 'flexi'); ?>
</a>
 */
?>
 <div class= "flexi_content" id="flexi_content_<?php echo get_the_ID(); ?>">


 <div class="ui padded grid">
  <div class="row">
    <div class="column">

	<?php if (get_post_status() == 'draft' || get_post_status() == "pending") {?><Small>
					<div class="flexi_badge"> <?php echo __("Under Review", "flexi"); ?></div>
				</small><?php }?>
				<?php
echo "<div class='flexi_frame_1' ><img src='" . flexi_image_src('flexi-large') . "' ></div>";
?>

	</div>
  </div>
  <div class="row">
    <div class="column" style="text-align:center;"><?php echo flexi_show_icon_grid(); ?></div>
  </div>
  <div class="row">
    <div class="column" style="text-align:center;"><?php flexi_standalone_gallery(get_the_ID(), 'flexi-thumb');?></div>
  </div>
</div>



<div class="ui basic segment"> <?php echo wpautop(stripslashes($post->post_content)); ?></div>



	  <hr>

	  <div class="ui stackable equal width grid">
  <div class="column"><?php echo flexi_custom_field_loop($post, 'detail'); ?></div>
  <div class="column">
	  <?php flexi_list_album($post, 'ui avatar image');?>
<hr>
<?php flexi_list_tags($post, 'ui tag label');?></div>

</div>

</div>