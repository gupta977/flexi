<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://odude.com/
 * @since      1.0.0
 *
 * @package    Flexi
 * @subpackage Flexi/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Flexi
 * @subpackage Flexi/includes
 * @author     ODude <navneet@odude.com>
 */
class Flexi_Deactivator
{

 /**
  * Short Description. (use period)
  *
  * Long Description.
  *
  * @since    1.0.0
  */
 public static function deactivate()
 {
  do_action("flexi_deactivated");
  flush_rewrite_rules();
 }
}
