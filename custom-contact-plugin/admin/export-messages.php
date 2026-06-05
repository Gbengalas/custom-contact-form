<?php

if (!defined('ABSPATH')) exit;


function ccp_export_messages() {

    check_admin_referer('ccp_export_messages');

    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to export messages.');
    }

    global $wpdb;

    $table = $wpdb->prefix . 'ccp_messages';

    $messages = $wpdb->get_results(
        "SELECT * FROM $table ORDER BY id DESC"
    );

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=contact-messages.csv');

    $output = fopen('php://output', 'w');

    fputcsv(
        $output,
        ['ID', 'Name', 'Email', 'Message', 'Status', 'Date']
    );

    foreach ($messages as $message) {

        fputcsv(
            $output,
            [
                $message->id,
                $message->firstname,
                $message->email,
                $message->message,
                $message->status,
                $message->created_at
            ]
        );
    }

    fclose($output);
    exit;
}

add_action('admin_post_ccp_export_messages','ccp_export_messages');


