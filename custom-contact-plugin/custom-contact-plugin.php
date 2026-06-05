<?php
if (!defined('ABSPATH')) exit;
/*
Plugin Name: Custom Contact Form
Description: Lightweight contact form plugin with inbox management, email notifications, CSV export and spam protection.
Version: 1.0.0
Author: Gbenga Sanmi
License: GPL v2
Text Domain: custom-contact-form
*/

require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

//  ADMIN FILES 
require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/messages-page.php';
require_once plugin_dir_path(__FILE__) . 'admin/view-message.php';
require_once plugin_dir_path(__FILE__) . 'admin/actions.php';
require_once plugin_dir_path(__FILE__) . 'admin/contact-form.php';
require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
require_once plugin_dir_path(__FILE__) . 'admin/export-messages.php';



add_action('admin_enqueue_scripts', function () {

  wp_enqueue_style('ccp-admin-style', plugin_dir_url(__FILE__) . 'assets/css/admin.css', [],'1.0');

  wp_enqueue_script('ccp-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin.js', [],'1.1', true);

});


    // frontend css
    function ccp_frontend_assets() {

    wp_enqueue_style( 'ccp-frontend-style', plugin_dir_url(__FILE__) . 'assets/css/frontend.css', [],'1.0');}



    add_action( 'wp_enqueue_scripts',  'ccp_frontend_assets');

    register_activation_hook(__FILE__, 'ccp_create_messages_table');