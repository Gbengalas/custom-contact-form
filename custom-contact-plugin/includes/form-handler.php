<?php
if (!defined('ABSPATH')) exit;


    // if (
    //     !isset($_POST['ccp_contact_form_nonce']) ||
    //     !wp_verify_nonce($_POST['ccp_contact_form_nonce'],'ccp_contact_form_action')
    // ) {
    //     wp_die('Security check failed.');
    //   }

function ccp_handle_contact_form() {


    if (!empty($_POST['website'])) {
        wp_die('Spam detected.');
    }

  if (  !isset($_POST['ccp_contact_form_nonce']) || !wp_verify_nonce($_POST['ccp_contact_form_nonce'],'ccp_contact_form_action')) {
        wp_die('Security check failed.');
    }


    global $wpdb;

    $table = $wpdb->prefix . 'ccp_messages';

    $wpdb->insert($table, [
        'firstname' => sanitize_text_field($_POST['firstname']),
        'email'     => sanitize_email($_POST['email']),
        'message'   => sanitize_textarea_field($_POST['message']),
    ]);


       // Email notification
    $admin_email = get_option('admin_email');

    $subject = 'New Contact Form Message';

    $email_message = "Name: {$firstname} Email: {$email} Message:{$message}";

    wp_mail( $admin_email, $subject, $email_message);

    wp_redirect( 
      add_query_arg('ccp_status','success', wp_get_referer())
    );
    exit;
}

add_action('admin_post_ccp_handle_contact_form', 'ccp_handle_contact_form');
add_action('admin_post_nopriv_ccp_handle_contact_form', 'ccp_handle_contact_form');