<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
 exit;
}

/**
 * Block Initializer.
 */
if (function_exists('register_block_type')) {
 // Gutenberg is  active.
 require_once plugin_dir_path(__FILE__) . 'src/init.php';
 require_once plugin_dir_path(__FILE__) . 'src/gallery/run.php';
 require_once plugin_dir_path(__FILE__) . 'src/form/run.php';
}
