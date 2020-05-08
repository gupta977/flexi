<?php
/**
 * Initialize the plugin tracker
 *
 * @return void
 */
function appsero_init_tracker_flexi()
{

 if (!class_exists('Appsero\Client')) {
  require_once plugin_dir_path(dirname(__FILE__)) . 'includes/appsero/Client.php';
 }

 $client = new Appsero\Client('91d4d102-f303-41b2-b9a1-ac2a27bf3533', 'Flexi Gallery', __FILE__);

 // Active insights
 $client->insights()->init();

}

appsero_init_tracker_flexi();
