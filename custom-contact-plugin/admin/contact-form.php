<?php

if (!defined('ABSPATH')) exit;


function ccp_render_contact_form_guide() {

    echo '<div class="wrap ccp-guide-page">';

    echo '<h1>Contact Form</h1>';

    echo '<p class="ccp-subtitle">Manage and embed your contact form anywhere on your website. </p>';

    
     //  SHORTCODE CARD
    
       echo '<div class="ccp-card">';
         echo '<h2>Shortcode</h2>';
         echo '
            <div class="ccp-shortcode-wrapper">
               <input type="text" id="ccp-shortcode" value="[custom_contact_form]" readonly class="ccp-shortcode-input">

               <button type="button"id="ccp-copy-shortcode"class="button button-primary"> Copy</button>
            </div>
         ';
      echo '</div>';

    
    //   INSTRUCTIONS CARD
    
      echo '<div class="ccp-card">';

         echo '<h2>Instructions</h2>';

         echo '
         <ul class="ccp-guide-list">
            <li>Paste the shortcode into any page or post.</li>
            <li>Visitors can submit messages through the form.</li>
            <li>Messages are saved in your inbox.</li>
            <li>Email notifications can be enabled in settings.</li>
            <li>You can search, read, export and delete messages.</li>
         </ul> ';

      echo '</div>';

    
    //  LIVE PREVIEW CARD
    
      echo '<div class="ccp-card">';

         echo '<h2>Live Preview</h2>';

         echo do_shortcode('[custom_contact_form]');

      echo '</div>';

   echo '</div>';
}
