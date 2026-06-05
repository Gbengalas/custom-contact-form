<?php
if (!defined('ABSPATH')) exit;

function ccp_render_single_message() {

    global $wpdb;

    $table = $wpdb->prefix . 'ccp_messages';

    $id = isset($_GET['id'])
        ? intval($_GET['id'])
        : 0;

    if (!$id) {
        wp_die('Invalid message ID');
    }

    $message = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table WHERE id = %d",
            $id
        )
    );

    if (!$message) {
        wp_die('Message not found');
    }

    /*
    AUTO MARK READ
    */
    $wpdb->update(
        $table,
        ['status' => 'read'],
        ['id' => $id],
        ['%s'],
        ['%d']
    );

    echo '
        <div class="wrap">

            <h1>View Message</h1>

            <p> <strong>Name:</strong>' . esc_html($message->firstname) . ' </p>

            <p> <strong>Email:</strong> ' . esc_html($message->email) . ' </p>

            <p> <strong>Date:</strong>' . esc_html($message->created_at) . ' </p>

            <hr>

            <p><strong>Message:</strong></p>

            <p>' . esc_html($message->message) . ' </p>

            <br>

            <a href="' . admin_url('admin.php?page=ccp-messages') . '"> Back </a>

        </div>';
}