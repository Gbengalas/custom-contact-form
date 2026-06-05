<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {

    global $wpdb;

    $table = $wpdb->prefix . 'ccp_messages';

    $unread_count = $wpdb->get_var(
        "SELECT COUNT(*) FROM $table WHERE status = 'unread'"
    );

    $menu_title = 'Messages';

    if ($unread_count > 0) {
        $menu_title .= " <span class='awaiting-mod'>{$unread_count}</span>";
    }

    // MAIN INBOX
    add_menu_page(
        'Contact Messages',
        $menu_title,
        'manage_options',
        'ccp-messages',
        'ccp_render_messages_page',
        'dashicons-email',
        26
    );

    // VIEW MESSAGE (hidden)
    add_submenu_page(
        null,
        'View Message',
        'View Message',
        'manage_options',
        'ccp-view-message',
        'ccp_render_single_message'
    );

    // CONTACT FORM GUIDE
    add_submenu_page(
        'ccp-messages',
        'Contact Form',
        'Contact Form',
        'manage_options',
        'ccp-contact-form',
        'ccp_render_contact_form_guide'
    );

    add_submenu_page(
        'ccp-messages',
        'Settings',
        'Settings',
        'manage_options',
        'ccp-settings',
        'ccp_render_settings_page'
    );
});