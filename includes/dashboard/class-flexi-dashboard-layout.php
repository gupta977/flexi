<?php
class Flexi_Admin_Dashboard_Layout
{
  public function __construct()
  {
    add_action('flexi_plugin_update', array($this, 'overwrite_layouts'));
    //  add_action('init', array($this, 'overwrite_layouts'));
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
    $src_dir = $upload_dir['basedir'] . '/flexi/layout/';  //upload dir.
    $target_dir = FLEXI_PLUGIN_DIR . 'public/partials/layout/';
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

  //Upload .zip file
  public function flexi_upload_file($file = array(), $path = '')
  {
    if (!empty($file)) {

      $upload_dir = $path;
      $uploaded   = move_uploaded_file($file['tmp_name'], $upload_dir . $file['name']);
      if ($uploaded) {
        echo "<p>Uploaded successfully</p>";
      } else {
        echo "<p>Some error in upload</p> ";
        print_r($file['error']);
      }
    }
  }


  public function flexi_dashboard_content()
  {
    ob_start();
    $this->overwrite_layouts();
    $safe_layout = array("basic", "masonry", "portfolio", "regular", "table", "wide");
    $layout_page = admin_url('admin.php?page=flexi');
    $layout_page = add_query_arg('tab', 'layout', $layout_page);

    //Import layout 
    if (isset($_POST['import'])) {


      if (!empty($_FILES)) {
        $file = $_FILES['flexi_layout'];   // file array


        $uploded_file = basename($file["name"]);
        $FileType = strtolower(pathinfo($uploded_file, PATHINFO_EXTENSION));

        //Check if file contains flexi_
        if (strpos($uploded_file, 'flexi_') !== false) {

          if ($FileType == "zip") {
            //upload zip file
            $upload_dir = wp_upload_dir();
            $base_path = $upload_dir['basedir'] . '/flexi/';  //upload dir.
            $path = $upload_dir['basedir'] . '/flexi/layout/';  //upload dir.
            if (!is_dir($base_path)) {
              mkdir($base_path);
            }
            if (!is_dir($path)) {
              mkdir($path);
            }
            $attachment_id = $this->flexi_upload_file($file, $path);

            //unzipping file
            WP_Filesystem();
            $unzipfile = unzip_file($path . '/' . $uploded_file, $path);
            if (is_wp_error($unzipfile)) {
              echo '<p>There was an error unzipping the file.</p>';
            } else {
              echo "<p>Successfully unzipped the file to wp-upload folder !</p>";
              //Delete .zip file uploaded
              unlink($path . '/' . $uploded_file);
              //copy files from upload folder to gallery
              $this->overwrite_layouts();
            }
          } else {
            echo '<p>it\'s not a valid zip file</p></div>';
          }
        } else {
          echo '<p>This is not a valid Flexi Gallery layout zip file</p>';
        }
      }
    }


    //Delete layout
    if (isset($_GET['delete'])) {
      $del_layout = $_GET['delete'];
      if (!in_array($del_layout, $safe_layout)) {

        //Delete gallery layout
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/gallery/' . $del_layout;
        $this->deleteAll($del_path, true);
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi/layout/gallery/' . $del_layout;
        $this->deleteAll($src_dir, true);

        //Delete detail layout
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/detail/' . $del_layout;
        $this->deleteAll($del_path, true);
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi/layout/detail/' . $del_layout;
        $this->deleteAll($src_dir, true);

        //Delete detail layout
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/detail/' . $del_layout;
        $this->deleteAll($del_path, true);
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi/layout/detail/' . $del_layout;
        $this->deleteAll($src_dir, true);

        //category detail layout
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/category/' . $del_layout;
        $this->deleteAll($del_path, true);
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi/layout/category/' . $del_layout;
        $this->deleteAll($src_dir, true);

        //Delete popup layout
        $del_path = FLEXI_BASE_DIR  .  'public/partials/layout/popup/' . $del_layout;
        $this->deleteAll($del_path, true);
        $upload_dir = wp_upload_dir();
        $src_dir = $upload_dir['basedir'] . '/flexi/layout/popup/' . $del_layout;
        $this->deleteAll($src_dir, true);
      }
    }

?>

    <div style="text-align:right;"> <a href="https://flexi.odude.com/layout/" class="button-secondary">More FREE/PAID Gallery</a> </div>

    <h3>Gallery Layouts</h3>
    <div class="about-text card">

      <b>Import Flexi Gallery Layout .zip File</b>
      <form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="<?php echo $layout_page; ?>">
        <input id="flexi_layout" name="flexi_layout" type="file" size="25" required />
        <input type="submit" value="Import" name="import" class="button button-primary">
      </form>

    </div>

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
            $url = $this->get_layout_info($style_path, 'url');
            $screenshot = FLEXI_BASE_DIR  .  'public/partials/layout/' . $folder . '/' . $file . '/screenshot.png';
            if (file_exists($screenshot)) {
              $screenshot = FLEXI_ROOT_URL .  'public/partials/layout/' . $folder . '/' . $file . '/screenshot.png';
            } else {

              $screenshot = FLEXI_ROOT_URL .  'admin/img/screenshot.png';
            }
        ?>
            <div class="theme active" tabindex="0" aria-describedby="dukan-lite-action dukan-lite-name" data-slug="dukan-lite">
              <a href="<?php echo $url; ?>" target="_blank">
                <div class="theme-screenshot">
                  <img src="<?php echo $screenshot; ?>" alt="">
                </div>

                <span class="more-details" id="dukan-lite-action">Source Code</span>
              </a>
              <div class="theme-id-container">

                <h2 class="theme-name" id="dukan-lite-name">

                  <span><?php echo $file; ?>:</span> <?php echo $version; ?>
                </h2>
                <?php

                if (!in_array($file, $safe_layout)) {
                ?>
                  <div class="theme-actions">
                    <?php
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
