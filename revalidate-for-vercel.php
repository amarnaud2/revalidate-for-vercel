<?php
/*
Plugin Name: Revalidate for Vercel
Plugin URI: https://www.digital-advantage.com/en/products/wordpress-revalidate-for-vercel/
Description: Trigger Next.js ISR revalidation on post update or publish.
Version: 1.5
Author: Arnaud Martin
Author URI: https://www.digital-advantage.com
License: GPL2
Text Domain: revalidate-for-vercel
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Load the plugin text domain for translations.
 */
function revalidate_for_vercel_load_textdomain() {
    load_plugin_textdomain('revalidate-for-vercel', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('init', 'revalidate_for_vercel_load_textdomain');

// Core files
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'admin/logs.php';
require_once plugin_dir_path(__FILE__) . 'admin/about.php';
require_once plugin_dir_path(__FILE__) . 'admin/help.php';
