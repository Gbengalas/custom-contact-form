<?php

if (!defined('ABSPATH')) exit;

if (
    isset($_GET['ccp_status']) &&
    $_GET['ccp_status'] === 'success'
) :?>

    <p  class="ccp-success-message">
        <?php echo esc_html(
            get_option('ccp_success_message','Your message was sent successfully.')
        ); ?>
    </p>
     <?php endif; ?>

<div class="ccp-form-wrapper">

    <h2 class="ccp-form-title">Contact Us</h2>

    <form class="ccp-contact-form" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">

        <input type="hidden" name="action" value="ccp_handle_contact_form">

        <div class="ccp-form-group">
            <label for="firstname">First Name</label>
            <input class="ccp-input" type="text" id="firstname" name="firstname" required >
        </div>

        <div class="ccp-form-group">
            <label for="email">Email</label>
            <input  class="ccp-input" type="email" id="email"   name="email"  required >
        </div>

        <div class="ccp-form-group">
            <label for="message">Message</label>
            <textarea class="ccp-textarea" id="message"  name="message" required ></textarea>
        </div>

        <?php
        wp_nonce_field('ccp_contact_form_action','ccp_contact_form_nonce');
        ?>

       <div class="ccp-honeypot">
         <input type="text" name="website"  value=""  autocomplete="off" >
      </div>

        <button type="submit" class="ccp-submit-btn"> Send Message </button>

    </form>

</div>