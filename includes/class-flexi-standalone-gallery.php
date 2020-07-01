<?php
class Flexi_Standalone_Gallery
{
 public function __construct()
 {
  add_shortcode('flexi-standalone', array($this, 'flexi_standalone'));
 }

 public function flexi_standalone($params)
 {
  $put = "";
  ob_start();

  if (isset($params['id'])) {
   $id = $params['id'];
  } else {
   if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];
   } else {
    $id = 0;
   }
  }
  $flexi_post = get_post($id);

  if ($flexi_post) {

   if (isset($_REQUEST["id"])) {
    $popup = flexi_get_option('lightbox_switch', 'flexi_detail_settings', 1);
    if ('1' == $popup) {
     $popup = flexi_get_option('popup_style', 'flexi_detail_settings', 'on');
    }
    $data = flexi_image_data('thumbnail', $flexi_post, $popup);
    echo '<div class="' . $data['popup'] . ' flexi_effect">';
    echo '<a class="" ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
    echo '<div class="flexi-image-wrapper-thumb"><img src="' . esc_url(flexi_image_src('thumbnail', $flexi_post)) . '"></div></a></div>';
    ?>

<script>

jQuery('[data-fancybox-trigger').fancybox({
        selector : '.flexi_show_popup_on a:visible',
        thumbs   : {
    autoStart : true
  },
  protect: true,

    });
   </script>
<?php
} else {

    ?>
       <div class="pure-g">
         <div class="pure-u-1-1" style='text-align: center;'>


         <div class="flexi_margin-box" style="text-align: center;">
                <div class="flexi-image-wrapper_large"><img id="flexi_large_image" src="<?php echo flexi_image_src('large', $post); ?>"></div>
      </div>


         </div>
         <div class="pure-u-1">
             <div class="flexi_margin-box">
                 <div id="flexi_thumb_image"> <?php flexi_standalone_gallery($id, 'thumbnail', 75, 75);?></div>
             </div>
         </div>
     </div>
<?php
}

  } else {
   echo '<div id="flexi_no_record" class="flexi_alert-box flexi_error">' . __('Wrong ID', 'flexi') . '</div>';
  }

  $put = ob_get_clean();
  return $put;
 }

}
$standalone = new Flexi_Standalone_Gallery();
