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

    if ($flexi_post && 0 != $id) {

      if (isset($_REQUEST["id"])) {

        if (isset($_REQUEST["id"]) && isset($_REQUEST["manage"])) {
          //Update primary image form
?>
          <style>
            #flexi_form {
              display: none;
            }
          </style>


          <div id="flexi_form_internal">

            <?php
            if ($_REQUEST["manage"] == "media") {
            ?>

              <img id="flexi_medium_image" src="<?php echo flexi_image_src('medium', $flexi_post); ?>"><br>
              <form id="flexi-request-form-update-primary" class="flexi_ajax_update_image pure-form" method="post" enctype="multipart/form-data" action="http://localhost/wp5/wp-admin/admin-ajax.php">
                <fieldset>
                  <legend>Select new image to replace</legend>
                  <input type="file" name="user-submitted-image[]" accept="image/*" value="" id="file" class="" required="">
                  <?php
                  wp_nonce_field('flexi-nonce', 'flexi-nonce', false);
                  echo '<input type="hidden" name="flexi_id" value="' . $id . '">';
                  echo '<input type="hidden" name="upload_type" value="flexi">';
                  echo '<input type="hidden" name="type" value="primary">';
                  echo '<input type="hidden" name="action" value="flexi_ajax_update_image">';
                  ?>
                  <input type="submit" name="submit" value="Replace image" id="submit" class="">
                </fieldset>
              </form>

            <?php
              $link = flexi_get_button_url($id, false, 'edit_flexi_page', 'flexi_form_settings');
              $link = add_query_arg("manage", "standalone", $link);
              echo "<a class='pure-button' href='" . $link . "'>Add Sub-Gallery</a>";
            } else {

              //Update sub-gallery
            ?>


              <div class="pure-g">
                <div class="pure-u-1">
                  <div class="flexi_margin-box">
                    <div id="flexi_thumb_image"> <?php flexi_standalone_gallery($id, 'thumbnail', 75, 75, true); ?></div>
                  </div>
                </div>
              </div>
              <form id="flexi-request-form-update-primary" class="flexi_ajax_update_image pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="http://localhost/wp5/wp-admin/admin-ajax.php">


                <div class="flexi_drag_file"><input type="file" accept="image/*" name="user-submitted-image[]" value="" id="file" class="flexi_drag_file_hide" required="" multiple="">
                  <p>Select File</p>
                </div>

                <?php
                wp_nonce_field('flexi-nonce', 'flexi-nonce', false);
                echo '<input type="hidden" name="flexi_id" value="' . $id . '">';
                echo '<input type="hidden" name="upload_type" value="flexi">';
                echo '<input type="hidden" name="type" value="standalone">';
                echo '<input type="hidden" name="action" value="flexi_ajax_update_image">';
                ?>
                <input type="submit" name="submit" value="Add image" id="submit" class="">
              </form>

            <?php
            }
            ?>
          </div>
          <!-- Image loader -->
          <div id='flexi_loader_internal' style='display: none;'>
            <img src="<?php echo FLEXI_PLUGIN_URL . '/public/images/loading.gif'; ?>">
          </div>
          <div class="flexi_response_internal"></div>
          <br>
          <a class="pure-button" href="<?php echo flexi_get_button_url($id, false, 'edit_flexi_page', 'flexi_form_settings'); ?>"><?php echo __("Go back", "flexi"); ?></a>

        <?php
        } else {
          $popup = flexi_get_option('lightbox_switch', 'flexi_detail_settings', 1);
          if ('1' == $popup) {
            $popup = flexi_get_option('popup_style', 'flexi_detail_settings', 'on');
          }
          $data = flexi_image_data('thumbnail', $flexi_post->ID, $popup);
          echo '<div class="' . $data['popup'] . ' flexi_effect">';
          echo '<a class="" ' . $data['extra'] . ' href="' . $data['url'] . '" data-caption="' . $data['title'] . '" data-src="' . $data['src'] . '" border="0">';
          echo '<div class="flexi-image-wrapper-thumb"><img src="' . esc_url(flexi_image_src('thumbnail', $flexi_post)) . '"></div></a></div>';

          if (isset($params['edit'])) {
            if ($params["edit"] == "true") {
              //Update primary image link below image at edit page
              $link = flexi_get_button_url($id, false, 'edit_flexi_page', 'flexi_form_settings');
              $link = add_query_arg("manage", "media", $link);
              echo "<a href='" . $link . "'>Manage media</a>";
            }
          }

        ?>

          <script>
            jQuery('[data-fancybox-trigger').fancybox({
              selector: '.flexi_show_popup_on a:visible',
              thumbs: {
                autoStart: true
              },
              protect: true,

            });
          </script>
        <?php }
      } else {

        ?>
        <div class="pure-g">
          <div class="pure-u-1-1" style='text-align: center;'>


            <div class="flexi_margin-box" style="text-align: center;">
              <div class="flexi-image-wrapper_large"><img id="flexi_large_image" src="<?php echo flexi_image_src('large', $flexi_post); ?>"></div>
            </div>


          </div>
          <div class="pure-u-1">
            <div class="flexi_margin-box">
              <div id="flexi_thumb_image"> <?php flexi_standalone_gallery($id, 'thumbnail', 75, 75); ?></div>
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
