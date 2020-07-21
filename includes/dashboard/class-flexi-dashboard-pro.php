<?php
class Flexi_Admin_Dashboard_Pro
{
 public function __construct()
 {
  add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
  add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
 }

 public function add_tabs($tabs)
 {

  $extra_tabs = array("pro" => __('Flexi-Pro', 'flexi'));

  // combine the two arrays
  $new = array_merge($tabs, $extra_tabs);
  //flexi_log($new);
  return $new;
 }

 public function add_content()
 {

  if (isset($_GET['tab']) && 'pro' == $_GET['tab']) {
   echo $this->flexi_dashboard_content();
  }
 }

 public function flexi_dashboard_content()
 {
  ob_start();

  ?>

<div style="text-align:right;"> <a href="https://odude.com/product-category/flexi/" class="button-secondary">Purchase/Renew Flexi-PRO</a> </div>

<div class="update-nag">

<form method="post">
<b>Enter license key: </b>
<input type="text" name="flexi_license" class="regular-text" value="<?php echo get_option('FLEXI_PRO_LICENSE', ''); ?>">
<input type="submit" value="Activate FLEXI-PRO" class="button-primary">
</form>
</div>


<?php
if (isset($_POST['flexi_license'])) {
   if (function_exists('flexi_process_license')) {

    //First deactivate old license and renew new one
    if (is_flexi_pro()) {
     $old_license = get_option('FLEXI_PRO_LICENSE', ''); //'FLEXI_PRO_LICENSE'
     if ('' != $old_license) {
      flexi_get_license($old_license, 'deactivate');
     }
    }

    $res = flexi_process_license($_POST['flexi_license']);
    if ('404' == $res->data->status) {
     echo '<div class="update-nag">' . $res->message . '</div>';
    } else {
     echo '<div class="update-nag">License activated</div>';
    }
   } else {
    echo '<div class="update-nag"><code>flexi-pro plugin is not installed or activated.</code></div>';
   }
  }

  ?>

<div class="card">
<h3 class="title">Flexi-PRO Status</h3>
<b>Flexi Version: </b> <?php echo FLEXI_VERSION; ?><br>
<b>Flexi-PRO status:</b> <?php if (is_flexi_pro()) {echo "Activated";} else {echo "Not activated";}?><br>
<?php
if (is_flexi_pro()) {
   echo "<b>Flexi-PRO version </b>:" . FLEXI_PRO_VERSION;

   $expire = get_option('FLEXI_PRO_EXPIRE', '');
   if ('' != $expire) {
    $expdAt = date($expire);
    $today  = date("Y-m-d H:i:s");
    if ($today >= $expdAt) {
     echo "<br><b>Expired:</b> " . $expdAt . '<br><code> Please renew to regain access for premium features.</code>';
     update_option('FLEXI_PRO', 'FAIL');
    } else {
     echo "<br><b>Expires:</b> " . $expdAt;
    }
   }

  }
  ?>
<br>
<?php
echo get_option('FLEXI_PRO_RESPONSE', '');
  ?>
  </div>

<div class="card">
<h3 class="title">Features of Flexi-PRO</h3>
<ul>
<li>1- Google reCaptcha (Security code during form submission) <a href="#TB_inline?width=600&height=200&inlineId=reCaptcha" title="Form with Google reCaptcha Option" class="thickbox">Sample code</a></li>
<li>2- Bulk image upload (drag and drop multiple file) <a href="#TB_inline?width=600&height=200&inlineId=drag" title="Drag & Drop multiple files" class="thickbox">Sample code</a></li>
<li>3- Let users to modify own submitted post (Edit Button)  <a href="#TB_inline?width=600&height=200&inlineId=modify" title="Edit page content" class="thickbox">Sample code</a></li>
<li>4- Extra 7 custom fields</li>
<li>5- Add more own mime-type files</li>
<li>6- Limit number of post to upload based on user role.</li>
<li>7- Allow visitors to upload huge file size from 100MB to 9999MB</li>
<li>8- High quality animated thumbnail for video files.</li>
</ul>
</div>

<div id="reCaptcha" style="display:none;">
     <p>
   [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
	 [flexi-form-tag type="post_title" title="Title" value=""]<br>
		[flexi-form-tag type="file" title="Select file"]<br>
    <code>[flexi-form-tag type="captcha" title="Security"]</code><br>
    [flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
		[/flexi-form]<br>
     </p>
</div>

<div id="drag" style="display:none;">
     <p>
   [flexi-form class="pure-form pure-form-stacked" title="Submit to Flexi" name="my_form" ajax="true"]<br>
	 [flexi-form-tag type="post_title" title="Title" value=""]<br>
    <code>[flexi-form-tag type="file_multiple" title="Drag &amp; Drop multiple files" class="flexi_drag_file" multiple="true"]</code><br>
    [flexi-form-tag type="submit" name="submit" value="Submit Now"]<br>
		[/flexi-form]<br>
     </p>
</div>

<div id="modify" style="display:none;">
     <p>
     <b>Add edit="true" as parameter</b><br><br>
[flexi-form class="xxx_class" title="Update Flexi" name="my_form" ajax="true" edit="true"]<br>
[flexi-form-tag type="post_title" title="Title" edit="true" ]<br>
[flexi-form-tag type="category" title="Select category" edit="true"]<br>
[flexi-form-tag type="tag" title="Insert tag" edit="true"]<br>
[flexi-form-tag type="article" title="Description" placeholder="Content" edit="true"]<br>
[flexi-form-tag type="submit" name="submit" value="Update Now"]<br>
[/flexi-form]<br>
     </p>
</div>
<?php
$content = ob_get_clean();
  return $content;
 }

}
$add_tabs = new Flexi_Admin_Dashboard_Pro();
