<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Flexi
 * @subpackage Flexi/includes
 * @author     ODude <navneet@odude.com>
 */
class Flexi
{

 /**
  * The loader that's responsible for maintaining and registering all hooks that power
  * the plugin.
  *
  * @since    1.0.0
  * @access   protected
  * @var      Flexi_Loader    $loader    Maintains and registers all hooks for the plugin.
  */
 protected $loader;

 /**
  * The unique identifier of this plugin.
  *
  * @since    1.0.0
  * @access   protected
  * @var      string    $plugin_name    The string used to uniquely identify this plugin.
  */
 protected $plugin_name;

 /**
  * The current version of the plugin.
  *
  * @since    1.0.0
  * @access   protected
  * @var      string    $version    The current version of the plugin.
  */
 protected $version;

 /**
  * Define the core functionality of the plugin.
  *
  * Set the plugin name and the plugin version that can be used throughout the plugin.
  * Load the dependencies, define the locale, and set the hooks for the admin area and
  * the public-facing side of the site.
  *
  *
  */
 public function __construct()
 {
  if (defined('FLEXI_VERSION')) {
   $this->version = FLEXI_VERSION;
  } else {
   $this->version = '1.0.25';
  }
  $this->plugin_name = 'flexi';

  $this->load_dependencies();
  $this->set_locale();
  $this->define_admin_hooks();
  $this->define_public_hooks();

  // Path to the plugin directory
  if (!defined('FLEXI_PLUGIN_DIR')) {
   define('FLEXI_PLUGIN_DIR', plugin_dir_path(dirname(__FILE__)));

  }
 }

 /**
  * Load the required dependencies for this plugin.
  *
  * Include the following files that make up the plugin:
  *
  * - Flexi_Loader. Orchestrates the hooks of the plugin.
  * - Flexi_i18n. Defines internationalization functionality.
  * - Flexi_Admin. Defines all hooks for the admin area.
  * - Flexi_Public. Defines all hooks for the public side of the site.
  *
  * Create an instance of the loader which will be used to register the hooks
  * with WordPress.
  *
  * @since    1.0.0
  * @access   private
  */
 private function load_dependencies()
 {
  //oEmbed URL
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/oembed/class-flexi-oembed.php';

  //Block
  require_once plugin_dir_path(dirname(__FILE__)) . 'block/plugin.php';

  //Widgets
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/widgets/categories.php';

  //Admin Dashboard classes
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/dashboard/class-flexi-dashboard-intro.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/dashboard/class-flexi-dashboard-pages.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/dashboard/class-flexi-dashboard-pro.php';

  //User Dashboard
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/user_dashboard/class-flexi-user-dashboard.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/user_dashboard/class-flexi-user-gallery.php';

  //Addon
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/addon/class-flexi-custom-field.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/addon/class-flexi-ultimate-member.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/addon/class-flexi-buddypress.php';
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/addon/class-flexi-mime-type.php';

  //Toolbar
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/toolbar/class-flexi-gallery-toolbar.php';

  //Add Flexi_User
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-user.php';

  //Flexi Admin custom columns
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-admin-column.php';

  //Flexi flexi_category columns
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-category.php';

  //Flexi own media settings
  //require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-media.php';

  //[flexi-form] & [flexi-form-tag] shortcode
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-form.php';

  //Render HTML Form tags
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-html_form.php';

  //Include CMB2 Framework
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cmb2/init.php';

  //Include common functions
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/functions.php';

  //Load More on gallery scroll
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/flexi_load_more.php';

  //Load Ajax form submit
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/flexi_ajax_post.php';

  //Load Ajax Delete
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi_ajax_delete.php';

  //Load Ajax Download
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi_ajax_download.php';

  // [flexi-gallery] shortcode
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-gallery.php';

  // [flexi-standalone] shortcode
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-standalone-gallery.php';

  // Flexi Detail page
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-detail.php';

  /**
   * Custom Post Types (flexi & flexi_category)
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-post_types.php';

//Generate meta-boxes
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-metabox.php';

  /**
   * Flexi setting class file
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-settings.php';

  /**
   * The class responsible for orchestrating the actions and filters of the
   * core plugin.
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-loader.php';

  /**
   * The class responsible for defining internationalization functionality
   * of the plugin.
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-i18n.php';

  /**
   * The class responsible for defining all actions that occur in the admin area.
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-flexi-admin.php';

  /**
   * The class responsible for defining all actions that occur in the public-facing
   * side of the site.
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-flexi-public.php';

  $this->loader = new Flexi_Loader();
 }

 /**
  * Define the locale for this plugin for internationalization.
  *
  * Uses the Flexi_i18n class in order to set the domain and to register the hook
  * with WordPress.
  *
  * @since    1.0.0
  * @access   private
  */
 private function set_locale()
 {

  $plugin_i18n = new Flexi_i18n();

  $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
 }

 /**
  * Register all of the hooks related to the admin area functionality
  * of the plugin.
  *
  * @since    1.0.0
  * @access   private
  */
 private function define_admin_hooks()
 {
  //custom post type
  $plugin_post_types = new Flexi_Post_Types();
  $this->loader->add_action('init', $plugin_post_types, 'create_custom_post_type', 999);
  $this->loader->add_filter('parent_file', $plugin_post_types, 'tag_parent_file');
  $this->loader->add_filter('parent_file', $plugin_post_types, 'taxonomy_parent_file');

  $plugin_admin = new Flexi_Admin($this->get_plugin_name(), $this->get_version());
  $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
  $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

  $this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu');

  //Settings
  $settings = new FLEXI_Admin_Settings();
  $this->loader->add_action('admin_menu', $settings, 'admin_menu');
  $this->loader->add_action('admin_init', $settings, 'admin_init');

//Generate Meta-box
  $meta = new Flexi_Meta_boxes();
  $this->loader->add_action('cmb2_admin_init', $meta, 'register_meta_box');

  //Media Settings
  //$media = new Flexi_Media_Settings();

  //Admin column
  $column = new Flexi_Admin_Column();

 }

 /**
  * Register all of the hooks related to the public-facing functionality
  * of the plugin.
  *
  * @since    1.0.0
  * @access   private
  */
 private function define_public_hooks()
 {

  $plugin_public = new Flexi_Public($this->get_plugin_name(), $this->get_version());

  $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
  $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

  //Gallery shortcode [flexi_gallery]
  $gallery = new Flexi_Shortcode_Gallery();
  $this->loader->add_action('wp_head', $gallery, 'enqueue_styles_head');

  //Detail Page
  $detail = new Flexi_Public_Detail();
  $this->loader->add_action('the_content', $detail, 'the_content', 20);
  $this->loader->add_filter('flexi_add_icon_grid', $detail, 'add_icon');

  //Ajax Delete
  $delete = new flexi_delete_post();
  $this->loader->add_filter('flexi_add_icon_grid', $delete, 'flexi_add_icon_grid_delete');

  //Ajax Download
  $download = new flexi_download_post();
  $this->loader->add_filter('flexi_add_icon_grid', $download, 'flexi_add_icon_grid_download');

  //[flexi-form] & [flexi-form-tag]
  $form = new Flexi_Shortcode_Form();
  $this->loader->add_filter('flexi_add_icon_grid', $form, 'flexi_add_icon_grid_edit');

  //Flexi User
  $user = new Flexi_User();
  $this->loader->add_filter('flexi_add_icon_grid', $user, 'flexi_add_user_profile_icon');

//Ultimate Member: Setting at Flexi & Tab at profile page
  // $ultimate_member = new Flexi_Addon_Ultimate_Member();
  //$this->loader->add_filter('um_profile_tabs', $ultimate_member, 'add_profile_tab');

 }

 /**
  * Run the loader to execute all of the hooks with WordPress.
  *
  * @since    1.0.0
  */
 public function run()
 {
  $this->loader->run();
 }

 /**
  * The name of the plugin used to uniquely identify it within the context of
  * WordPress and to define internationalization functionality.
  *
  * @since     1.0.0
  * @return    string    The name of the plugin.
  */
 public function get_plugin_name()
 {
  return $this->plugin_name;
 }

 /**
  * The reference to the class that orchestrates the hooks with the plugin.
  *
  * @since     1.0.0
  * @return    Flexi_Loader    Orchestrates the hooks of the plugin.
  */
 public function get_loader()
 {
  return $this->loader;
 }

 /**
  * Retrieve the version number of the plugin.
  *
  * @since     1.0.0
  * @return    string    The version number of the plugin.
  */
 public function get_version()
 {
  return $this->version;
 }
}
