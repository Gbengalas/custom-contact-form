<?php

if (!defined('ABSPATH')) exit;

function ccp_register_contact_form_shortcode() {

    ob_start();

    include plugin_dir_path(__FILE__) . '../templates/contact-form.php';
    

    return ob_get_clean();

}

add_shortcode('custom_contact_form', 'ccp_register_contact_form_shortcode');