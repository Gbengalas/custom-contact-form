<?php
    if (!defined('ABSPATH')) exit;

    // MARK AS READ
    function ccp_mark_as_read() {

        global $wpdb;

        $id = intval($_GET['id']);

        check_admin_referer('ccp_mark_read_' . $id);

        $wpdb->update(
            $wpdb->prefix . 'ccp_messages',
            ['status' => 'read'],
            ['id' => $id],
            ['%s'],
            ['%d']
        );

        wp_redirect(admin_url('admin.php?page=ccp-messages'));
        exit;
    }

    add_action('admin_post_ccp_mark_read', 'ccp_mark_as_read');



    // DELETE SINGLE MESSAGE

    function ccp_delete_message() {

        global $wpdb;

        $id = intval($_GET['id']);

        check_admin_referer('ccp_delete_message_' . $id);

        $wpdb->delete(
            $wpdb->prefix . 'ccp_messages',
            ['id' => $id],
            ['%d']
        );

        wp_redirect(admin_url('admin.php?page=ccp-messages'));
        exit;
    }

    add_action('admin_post_ccp_delete_message', 'ccp_delete_message');



    // BULK DELETE

    function ccp_bulk_delete_messages() {

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        if (
            !isset($_POST['message_ids']) ||
            !is_array($_POST['message_ids'])
        ) { 
            wp_redirect(admin_url('admin.php?page=ccp-messages'));
            exit;
        }

        global $wpdb;

        $table = $wpdb->prefix . 'ccp_messages';

        foreach ($_POST['message_ids'] as $id) {

            $wpdb->delete(
                $table,
                ['id' => intval($id)],
                ['%d']
            );
        }

        wp_redirect(admin_url('admin.php?page=ccp-messages'));
        exit;
    }

    add_action(  'admin_post_ccp_bulk_delete_messages','ccp_bulk_delete_messages');