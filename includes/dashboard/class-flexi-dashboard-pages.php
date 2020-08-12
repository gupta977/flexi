<?php
class Flexi_Admin_Dashboard_Pages
{
 public function __construct()
 {
  add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
  add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
 }

 public function add_tabs($tabs)
 {

  $extra_tabs = array("pages" => 'Flexi ' . __('Health', 'flexi'));

  // combine the two arrays
  $new = array_merge($tabs, $extra_tabs);
  //flexi_log($new);
  return $new;
 }

 public function add_content()
 {

  if (isset($_GET['tab']) && 'pages' == $_GET['tab']) {
   echo $this->flexi_dashboard_content();
  }
 }

 public function flexi_dashboard_content()
 {
  ob_start();
  ?>

<h3>Generate Pages</h3>
<b><i>Below pages are automatically generated and it must be available. <br>Create it again if not exist or deleted. <br>Click on the link to check if it is properly assigned.</i></b><br><br>
<div class="update-nag">
<?php
$primary_page_link = flexi_get_button_url('', false, 'primary_page', 'flexi_image_layout_settings');
  if ('#' != $primary_page_link) {
   echo "<a href='" . $primary_page_link . "' target='_blank'>Primary Gallery Page:</a><br>";
  } else {
   echo '<div style="color:red; font-weight:bold;">Primary Gallery Page : Not assigned</div><br>';
  }
  echo '<a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=gallery&section=flexi_image_layout_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a> ';
  ?>
Page should contain <code>[flexi-primary]</code> shortcode. Primary gallery page cannot be WordPress's front or homepage.<br><br>

</div>

<div class="update-nag">
<?php
$submission_form_link = flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings');
  if ('#' != $submission_form_link) {
   echo "<a href='" . $submission_form_link . "' target='_blank'>Submission form Page:</a><br>";
  } else {
   echo '<div style="color:red; font-weight:bold;">Submission form Page : Not assigned</div><br>';
  }

  echo '<a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_form_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a> ';
  ?>
Page should contain <code>[flexi-form]</code> shortcode enclosed with <code>[flexi-form-tag]</code>. Link this page at <a href="<?php echo admin_url('nav-menus.php'); ?>">frontend menu</a>.
<div id="sample_post_form" style="display:none;">
     <p>
    [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
		[flexi-form-tag type="post_title" title="Title" value="" placeholder="Main Title" required="true"]<br>
		[flexi-form-tag type="category" title="Select category"]<br>
		[flexi-form-tag type="tag" title="Insert tag"]<br>
		[flexi-form-tag type="article" title="Description"  placeholder="Content"]<br>
		[flexi-form-tag type="file" title="Select file" required="true"]<br>
		[flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
    [/flexi-form]
     </p>
</div>

<a href="#TB_inline?width=600&height=200&inlineId=sample_post_form" title="Sample Code for Post Form" class="thickbox">[View dummy content!]</a>
</div>
<br>

<div class="update-nag">
<?php
$my_gallery_link = flexi_get_button_url('', false, 'my_gallery', 'flexi_user_dashboard_settings');
  if ('#' != $my_gallery_link) {
   echo "<a href='" . $my_gallery_link . "' target='_blank'>Member Dashboard Page:</a><br>";
  } else {
   echo '<div style="color:red; font-weight:bold;">Member Dashboard Page : Not assigned</div><br>';
  }
  echo '<a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=general&section=flexi_user_dashboard_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a> ';
  ?>
Page should contain <code>[flexi-user-dashboard]</code> shortcode. You can add this page into <a href="<?php echo admin_url('nav-menus.php'); ?>">member menu</a>. <br><br>
</div>

<div class="update-nag">
<?php
$edit_flexi_link = flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings');
  if ('#' != $edit_flexi_link) {
   echo "<a href='" . $edit_flexi_link . "' target='_blank'>Edit Page:</a><br>";
  } else {
   echo '<div style="color:red; font-weight:bold;">Edit Page : Not assigned</div><br>';
  }
  echo '<a style="text-decoration: none;" href="' . admin_url('admin.php?page=flexi_settings&tab=form&section=flexi_form_settings') . '"><span class="dashicons dashicons-admin-tools"></span></a> ';
  ?>
Page should contain <code>[flexi-form edit="true"]</code> shortcode enclosed with <code>[flexi-form-tag edit="true"]</code>
<div id="sample_edit_form" style="display:none;">
     <p>
  [flexi-standalone]
  [flexi-form class="pure-form pure-form-stacked" title="Update Flexi" name="my_form" ajax="true" edit="true"]
  [flexi-form-tag type="post_title" title="Title" placeholder="Main Title" edit="true" required="true"]
  [flexi-form-tag type="category" title="Select category" edit="true"]
  [flexi-form-tag type="tag" title="Insert tag" edit="true"]
  [flexi-form-tag type="article" title="Description" placeholder="Content" edit="true"]
  [flexi-form-tag type="submit" name="submit" value="Update Now"]
  [/flexi-form]<br>
     </p>
</div>

<a href="#TB_inline?width=600&height=200&inlineId=sample_edit_form" title="Sample Code for Edit Form" class="thickbox">[View dummy content!]</a>
</div>
<?php
$content = ob_get_clean();
  return $content;
 }

}
$add_tabs = new Flexi_Admin_Dashboard_Pages();
