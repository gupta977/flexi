<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Flexi
 * @subpackage Flexi/admin
 * @author     ODude <navneet@odude.com>
 */
class Flexi_Admin
{

 /**
  * The ID of this plugin.
  *
  * @since    1.0.0
  * @access   private
  * @var      string    $plugin_name    The ID of this plugin.
  */
 private $plugin_name;

 /**
  * The version of this plugin.
  *
  * @since    1.0.0
  * @access   private
  * @var      string    $version    The current version of this plugin.
  */
 private $version;

 /**
  * Initialize the class and set its properties.
  *
  * @since    1.0.0
  * @param      string    $plugin_name       The name of this plugin.
  * @param      string    $version    The version of this plugin.
  */
 public function __construct($plugin_name, $version)
 {

  $this->plugin_name = $plugin_name;
  $this->version     = $version;
  if (FLEXI_VERSION !== get_option('flexi_version')) {
   $defaults = flexi_get_default_settings();
  }
 }

 /**
  * Register the stylesheets for the admin area.
  *
  * @since    1.0.0
  */
 public function enqueue_styles()
 {

  /**
   * This function is provided for demonstration purposes only.
   *
   * An instance of this class should be passed to the run() function
   * defined in Flexi_Loader as all of the hooks are defined
   * in that particular class.
   *
   * The Flexi_Loader will then create the relationship
   * between the defined hooks and the functions defined in this
   * class.
   */

  wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/flexi-admin.css', array(), $this->version, 'all');
 }

 /**
  * Register the JavaScript for the admin area.
  *
  * @since    1.0.0
  */
 public function enqueue_scripts()
 {

  /**
   * This function is provided for demonstration purposes only.
   *
   * An instance of this class should be passed to the run() function
   * defined in Flexi_Loader as all of the hooks are defined
   * in that particular class.
   *
   * The Flexi_Loader will then create the relationship
   * between the defined hooks and the functions defined in this
   * class.
   */
  add_thickbox();
  wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flexi-admin.js', array('jquery'), $this->version, false);
 }

 /**
  * Add plugin's main menu and "Dashboard" menu.
  *
  * @since 1.6.5
  */
 public function admin_menu()
 {

  add_menu_page(
   __('flexi', 'flexi'),
   __('Flexi', 'flexi'),
   'manage_options',
   'flexi',
   array($this, 'display_dashboard_content'),
   'dashicons-playlist-video',
   5
  );

  add_submenu_page(
   'flexi',
   __('Dashboard', 'flexi'),
   __('Dashboard', 'flexi'),
   'manage_options',
   'flexi',
   array($this, 'display_dashboard_content')
  );

  add_submenu_page(
   'flexi',
   __('All Posts', 'flexi'),
   __('All Posts', 'flexi'),
   'manage_options',
   'edit.php?post_type=flexi'
  );

  add_submenu_page(
   'flexi',
   __('Flexi Categories', 'flexi'),
   __('Categories', 'flexi'),
   'manage_options',
   'edit-tags.php?taxonomy=flexi_category&amp;post_type=flexi'
  );
  add_submenu_page(
   'flexi',
   __('Flexi Tags', 'flexi'),
   __('Tags', 'flexi'),
   'manage_options',
   'edit-tags.php?taxonomy=flexi_tag&amp;post_type=flexi'
  );
 }

 /**
  * Display dashboard page content.
  *
  * @since 1.6.5
  */
 public function display_dashboard_content()
 {
  require FLEXI_PLUGIN_DIR . 'admin/partials/dashboard.php';
 }

}
