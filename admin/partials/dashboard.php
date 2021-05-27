<?php

if (isset($_GET['activated'])) {
	flexi_install_complete();
}

$flexi_activated = get_option('flexi_activated');
if ($flexi_activated) {

?>
	<div class="card">
		<h1><?php esc_html_e('Welcome to', 'flexi'); ?> <?php echo  __('Flexi', 'flexi'); ?></h1>
		<p>Go to setting page first to complete installation.</p>
		<a href="<?php echo admin_url('admin.php?page=flexi_settings'); ?>" class="button">Setting page</a>
	</div>

<?php

} else {


?>
	<div class="wrap about-wrap">
		<h1><?php echo __('Welcome to', 'flexi') . ' ' . __('Flexi', 'flexi') . ' ' . FLEXI_VERSION; ?></h1>
		<div class="about-text">
			<div class="card">
				<?php echo __('Let visitors to post images,video,audio,youtube from frontend with full controls.', 'flexi'); ?><br>
				<?php echo "<a href='" . flexi_get_button_url('', false, 'submission_form', 'flexi_form_settings') . "' target='_blank' class='button button-primary'>" . __('Post files', 'flexi') . "</a>" ?>
				<?php echo " <a href='" . flexi_get_button_url('', false, 'primary_page', 'flexi_image_layout_settings') . "' target='_blank' class='button button-primary'>" . __('View Gallery', 'flexi') . "</a>" ?>
				<a href="https://odude.com/docs/flexi-gallery/" target="_blank" class='button'><?php echo __('Documentation', 'flexi'); ?></a>
				<a href="https://odude.com/demo/flexi/" target="_blank" class='button'><?php echo __('Live Demo', 'flexi'); ?></a>

			</div>
		</div>
		<div class="flexi-badge-logo"></div>
		<nav class="nav-tab-wrapper">
			<?php
			//Get the active tab from the $_GET param
			$default_tab = 'intro';
			$get_tab     = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

			$tabs = array();
			$tabs = apply_filters('flexi_dashboard_tab', $tabs);

			foreach ($tabs as $key => &$val) {

				if ($key == $get_tab) {
					$active_tab = 'nav-tab-active';
				} else {
					$active_tab = '';
				}
				echo '<a href="?page=flexi&tab=' . $key . '" class="nav-tab ' . $active_tab . '">' . $val . '</a>';
			}

			?>
		</nav>

		<div class="tab-content">

			<?php do_action('flexi_dashboard_tab_content') ?>


		</div>
	</div>
<?php
}
?>