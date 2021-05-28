<?php
class Flexi_Admin_Dashboard_Intro
{
	public function __construct()
	{
		add_filter('flexi_dashboard_tab', array($this, 'add_tabs'));
		add_action('flexi_dashboard_tab_content', array($this, 'add_content'));
	}

	public function add_tabs($tabs)
	{

		$extra_tabs = array("intro" => 'Flexi ' . __('Guide', 'flexi'));

		// combine the two arrays
		$new = array_merge($tabs, $extra_tabs);
		//flexi_log($new);
		return $new;
	}

	public function add_content()
	{
		if (!isset($_GET['tab'])) {
			echo $this->flexi_dashboard_content();
		}

		if (isset($_GET['tab']) && 'intro' == $_GET['tab']) {
			echo $this->flexi_dashboard_content();
		}
	}

	public function flexi_dashboard_content()
	{
		ob_start();
?>
		<div class="changelog section-getting-started">
			<div class="feature-section">
				<h2>Creating Your First Gallery</h2>

				<img src="https://ps.w.org/flexi/assets/screenshot-6.gif?rev=2282300" class="flexi-help-screenshot">
				<img src="https://ps.w.org/flexi/assets/screenshot-2.gif?rev=2282300" class="flexi-help-screenshot">

				<h4>1. Pages → Add New</h4>
				<p>To create your first gallery, simply create a page and use Guten Block editor by click on + icon</p>

				<h4>2. Insert Flexi Plugin Blocks</h4>
				<p>1st block for form submission & 2nd block to display gallery. You are free to create separate pages for form & gallery.</p>

				<h4>3. Link pages to Appearance → Menus</h4>
				<p>Add these pages to menu so that visitor can find it. Thats all!</p>

				<h4>#. Guten Block not available ?</h4>
				<p>At top of this page you will see FLEXI HEALTH tab, under that some pages are automatically generated. Add those pages to menu & view page as visitors. All is ready to go with the power of shortcode. These pages are totally based on Flexi settings and shortcodes.</p>
			</div>
		</div>
<?php
		$content = ob_get_clean();
		return $content;
	}
}
$add_tabs = new Flexi_Admin_Dashboard_Intro();
