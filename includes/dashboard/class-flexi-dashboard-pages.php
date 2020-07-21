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

  $extra_tabs = array("pages" => __('Flexi Pages', 'flexi'));

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
<b><i>Below pages are automatically generated and it must be available. Create it again if not exist or deleted. </i></b><br><br>

<?php
echo "<a href='" . flexi_get_button_url('', false, 'primary_page', 'flexi_image_layout_settings') . "' target='_blank'>Primary Gallery Page:</a><br>"
  ?>
Page should contain <code>[flexi-primary]</code> shortcode. Primary gallery page cannot be WordPress's front or homepage.<br><br>




<?php
echo "<a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' target='_blank'>Submission form Page:</a><br>"
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
<br><br>


<?php
echo "<a href='" . flexi_get_button_url('', false, 'my_gallery', 'flexi_image_layout_settings') . "' target='_blank'>Member Dashboard Page:</a><br>"
  ?>
Page should contain <code>[flexi-user-dashboard]</code> shortcode. Add this page into <a href="<?php echo admin_url('nav-menus.php'); ?>">member menu</a>. <br><br>

<?php
echo "<a href='" . flexi_get_button_url('', false, 'edit_flexi_page', 'flexi_form_settings') . "' target='_blank'>Edit Page:</a><br>"
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

<?php
$content = ob_get_clean();
  return $content;
 }

}
$add_tabs = new Flexi_Admin_Dashboard_Pages();
