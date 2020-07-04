<?php

/**
 * Fired during plugin activation
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Flexi
 * @subpackage Flexi/includes
 * @author     ODude <navneet@odude.com>
 */
class Flexi_Activator
{

 /**
  * Short Description. (use period)
  *
  * Long Description.
  *
  * @since    1.0.0
  */
 public static function activate()
 {
  /**
   * Custom Post Types
   */
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-flexi-post_types.php';
  $plugin_post_types = new Flexi_Post_Types();
  $plugin_post_types->create_custom_post_type();

  // Insert the plugin settings and default values for the first time
  $defaults = flexi_get_default_settings();

  //Create Pages and assign to settings
  $pages = flexi_create_pages();

  // Insert the plugin version
  add_option('flexi_version', FLEXI_VERSION);

  add_option('flexi_activated', true);

  do_action("flexi_activated");

  flush_rewrite_rules();

 }
}
