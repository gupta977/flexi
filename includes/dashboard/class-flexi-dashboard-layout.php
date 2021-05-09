<?php
class Flexi_Admin_Dashboard_Layout
{
  public function __construct()
  {
    //add_action('flexi_plugin_update', array($this, 'overwrite_layouts'));
    add_action('init', array($this, 'overwrite_layouts'));
    add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
    add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
  }

  public function add_tabs($tabs)
  {

    $extra_tabs = array("layout" => __('Layout', 'flexi'));

    // combine the two arrays
    $new = array_merge($tabs, $extra_tabs);
    //flexi_log($new);
    return $new;
  }

  public function add_content()
  {

    if (isset($_GET['tab']) && 'layout' == $_GET['tab']) {
      echo $this->flexi_dashboard_content();
    }
  }

  public function overwrite_layouts()
  {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    global $wp_filesystem;
    //flexi_log("ok");
    //Copy to gallery layout
    // Connecting to the filesystem.
    if (!WP_Filesystem()) {
      // Unable to connect to the filesystem, FTP credentials may be required or something.
      // You can request these with request_filesystem_credentials()
      exit;
    }

    // Don't forget that the target directory needs to exist.
    // If it doesn't already, you'll need to create it.

    //$wp_filesystem->mkdir($target_dir);
    $upload_dir = wp_upload_dir();
    $src_dir = $upload_dir['basedir'] . '/flexi_gallery/';  //upload dir.
    $target_dir = FLEXI_PLUGIN_DIR . 'public/partials/layout/gallery/';
    // Now copy all the files in the source directory to the target directory.
    copy_dir($src_dir, $target_dir, $skip_list = array());
  }
  // function to delete all files and subfolders from folder
  public function deleteAll($dir, $remove = false)
  {
    $structure = glob(rtrim($dir, "/") . '/*');
    if (is_array($structure)) {
      foreach ($structure as $file) {
        if (is_dir($file)) {
          $this->deleteAll($file, true);
        } else if (is_file($file)) {
          unlink($file);
        }
      }
    }
    if ($remove)
      if (is_dir($dir)) {
        rmdir($dir);
      }
  }

  public function flexi_dashboard_content()
  {
    $safe_layout = array("basic", "masonry", "portfolio", "regular", "table", "wide");
    if (isset($_GET['delete'])) {
      $del_layout = $_GET['delete'];
      if (!in_array($del_layout, $safe_layout)) {
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/gallery/' . $del_layout;
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi_gallery/' . $del_layout;

        $this->deleteAll($del_path, true);
        $this->deleteAll($src_dir, true);
      }
    }
    ob_start();
?>
    <h3>Gallery Layouts</h3>
    <div class="theme-browser rendered">
      <div class="themes wp-clearfix">
        <?php
        $output = "";
        $folder = "gallery";
        $dir      = FLEXI_BASE_DIR . 'public/partials/layout/' . $folder . '/';
        $files    = array_map("htmlspecialchars", scandir($dir));
        foreach ($files as $file) {
          if (!strpos($file, '.') && "." != $file && ".." != $file) {
            $style_path = FLEXI_BASE_DIR  .  'public/partials/layout/' . $folder . '/' . $file . '/style.css';
            $version = $this->get_layout_info($style_path, 'version');
            $screenshot = FLEXI_BASE_DIR  .  'public/partials/layout/' . $folder . '/' . $file . '/screenshot.png';
            if (file_exists($screenshot)) {
              $screenshot = FLEXI_ROOT_URL .  'public/partials/layout/' . $folder . '/' . $file . '/screenshot.png';
            } else {

              $screenshot = FLEXI_ROOT_URL .  'admin/img/screenshot.png';
            }
        ?>
            <div class="theme active" tabindex="0" aria-describedby="dukan-lite-action dukan-lite-name" data-slug="dukan-lite">

              <div class="theme-screenshot">
                <img src="<?php echo $screenshot; ?>" alt="">
              </div>

              <span class="more-details" id="dukan-lite-action">Theme Details</span>
              <div class="theme-id-container">

                <h2 class="theme-name" id="dukan-lite-name">

                  <span><?php echo $file; ?>:</span> <?php echo $version; ?>
                </h2>
                <?php

                if (!in_array($file, $safe_layout)) {
                ?>
                  <div class="theme-actions">
                    <?php
                    $layout_page = admin_url('admin.php?page=flexi');
                    $layout_page = add_query_arg('tab', 'layout', $layout_page);
                    $layout_page = add_query_arg('delete', trim($file), $layout_page);
                    ?>
                    <a class="button button-primary customize load-customize hide-if-no-customize" href="<?php echo $layout_page; ?>">Delete</a>
                  </div>
                <?php } ?>
              </div>
            </div>

        <?php
          }
        }
        ?>
      </div>
    </div>





<?php
    $content = ob_get_clean();
    return $content;
  }
  public function get_layout_info($css, $key)
  {
    $search = $key;
    // Read from file
    $lines = file($css);

    $linea = '';
    foreach ($lines as $line) {
      // Check if the line contains the string we're looking for, and print if it does
      if (strpos($line, $search) !== false) {
        $liner = explode('=', $line);
        if (isset($liner[1]))
          $linea .= $liner[1];
        else
          $linea .= '';
      }
    }

    return $linea;
  }
}
$add_tabs = new Flexi_Admin_Dashboard_Layout();
