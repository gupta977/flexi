<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Flexi
 * @subpackage Flexi/public
 * @author     ODude <navneet@odude.com>
 */
class Flexi_Public
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
  * @param      string    $plugin_name       The name of the plugin.
  * @param      string    $version    The version of this plugin.
  */
 public function __construct($plugin_name, $version)
 {

  $this->plugin_name = $plugin_name;
  $this->version     = $version;
 }

 /**
  * Register the stylesheets for the public-facing side of the site.
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

  $enable_conflict = flexi_get_option('conflict_disable_fancybox', 'flexi_conflict_settings', 0);
  if ("1" != $enable_conflict) {
   wp_enqueue_style($this->plugin_name . '_fancybox', plugin_dir_url(__FILE__) . 'css/jquery.fancybox.min.css', array(), $this->version, 'all');
  }
  wp_enqueue_style($this->plugin_name . '_godude', plugin_dir_url(__FILE__) . 'css/godude.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_purecss_base', plugin_dir_url(__FILE__) . 'css/purecss/base-min.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_purecss_grids', plugin_dir_url(__FILE__) . 'css/purecss/grids-min.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_purecss_responsive', plugin_dir_url(__FILE__) . 'css/purecss/grids-responsive-min.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_purecss_buttons', plugin_dir_url(__FILE__) . 'css/purecss/buttons-min.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name . '_purecss_forms', plugin_dir_url(__FILE__) . 'css/purecss/forms-min.css', array(), $this->version, 'all');
  wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/flexi-public.css', array(), $this->version, 'all');
 }

 /**
  * Register the JavaScript for the public-facing side of the site.
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
  global $wp_version;
  if(version_compare( $wp_version, '5.4', '>' ))
  {
    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flexi-public_new.js', array('jquery'), $this->version, false);
  }
  else
  {
  wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/flexi-public.js', array('jquery'), $this->version, false);
  }
  $enable_conflict_fancybox = flexi_get_option('conflict_disable_fancybox', 'flexi_conflict_settings', 0);
  if ("1" != $enable_conflict_fancybox) {
   wp_enqueue_script($this->plugin_name . '_fancybox', plugin_dir_url(__FILE__) . 'js/jquery.fancybox.min.js', array('jquery'), $this->version, false);
  }
  $enable_conflict_godude = flexi_get_option('conflict_disable_godude', 'flexi_conflict_settings', 0);
  if ("1" != $enable_conflict_godude) {
   wp_enqueue_script($this->plugin_name . '_godude', plugin_dir_url(__FILE__) . 'js/godude.js', array('jquery'), $this->version, false);
  }
  wp_enqueue_script($this->plugin_name . '_tags', plugin_dir_url(__FILE__) . 'js/jquery.tagsinput.js', '', $this->version, false);
  wp_enqueue_script($this->plugin_name . '_tags_filter', plugin_dir_url(__FILE__) . 'js/filter-tags.js', '', $this->version, false);

  //Add wordpress dashicons
  wp_enqueue_style('dashicons');

  //Default page navigation
  $navigation = flexi_get_option('navigation', 'flexi_image_layout_settings', 'button');

  global $wp_query;
  // Localize the script with new data
  $translation_array = array(
   'delete_string'   => __('Are you sure you want to delete?', 'flexi'),
   'download_string' => __('Download file?', 'flexi'),
   'ajaxurl'         => admin_url('admin-ajax.php'),
  );

  //flexi_log($navigation);
  //If scroll ajax is enabled
  if ('scroll' == $navigation) {
   // register our main script but do not enqueue it yet
   wp_register_script('flexi_load_more', plugin_dir_url(__FILE__) . 'js/flexi_load_more_scroll.js', array('jquery'), $this->version);
  } else {
   // register our main script but do not enqueue it yet
   wp_register_script('flexi_load_more', plugin_dir_url(__FILE__) . 'js/flexi_load_more_button.js', array('jquery'), $this->version);

  }

  wp_localize_script('flexi_load_more', 'myAjax', $translation_array);
  wp_enqueue_script('flexi_load_more');

  //Ajax form submission
  wp_register_script('flexi_ajax_post', plugin_dir_url(__FILE__) . 'js/flexi_ajax_post.js', array('jquery'), $this->version);
  wp_enqueue_script('flexi_ajax_post');

  //Ajax Delete
  wp_register_script('flexi_ajax_delete', plugin_dir_url(__FILE__) . 'js/flexi_ajax_delete.js', array('jquery'), $this->version);
  wp_enqueue_script('flexi_ajax_delete');

  //Ajax Download
  // wp_register_script('flexi_ajax_download', plugin_dir_url(__FILE__) . 'js/flexi_ajax_download.js', array('jquery'), $this->version);
  //  wp_enqueue_script('flexi_ajax_download');

 }
}
