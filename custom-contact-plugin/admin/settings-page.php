<?php
if (!defined('ABSPATH')) exit;

function ccp_render_settings_page() {

    if (   isset($_POST['ccp_save_settings']) &&  current_user_can('manage_options')  ) {


        check_admin_referer('ccp_save_settings','ccp_settings_nonce');

        update_option('ccp_notification_email',
            sanitize_email($_POST['ccp_notification_email'])
        );

        update_option('ccp_success_message',
            sanitize_text_field($_POST['ccp_success_message'])
        );

        update_option(  'ccp_email_notifications',
            isset($_POST['ccp_email_notifications'])
                ? 'yes'
                : 'no'
        );

        echo '<div class="notice notice-success"><p>Settings saved successfully.</p></div>';
    }

    echo '<div class="wrap ccp-settings-page">';
         echo '<h1>Plugin Settings</h1>';
        echo '<div class="ccp-settings-card">';

            echo '<form method="POST">';
               
              wp_nonce_field('ccp_save_settings','ccp_settings_nonce');

                echo '
                <div class="ccp-settings-card">

                    <table class="form-table">

                        <tr>
                            <th>Notification Email</th>
                            <td>
                                <input type="email" name="ccp_notification_email" value="' . esc_attr(
                                        get_option('ccp_notification_email', get_option('admin_email'))
                                    ) . '"class="regular-text"
                                >
                            </td>
                        </tr>

                        <tr>
                            <th>Success Message</th>
                            <td>
                                <input type="text" name="ccp_success_message" value="' . esc_attr(
                                        get_option('ccp_success_message','Your message was sent successfully.')
                                    ) . '"class="regular-text"
                                >
                            </td>
                        </tr>

                        <tr>
                            <th>Email Notifications</th>
                            <td>
                                <label>
                                    <input  type="checkbox" name="ccp_email_notifications"' . checked(
                                            get_option('ccp_email_notifications','yes'),'yes',false) .
                                    '>
                                    Enable Email Notifications
                                </label>
                            </td>
                        </tr>

                    </table>

                    <p>
                        <button type="submit" name="ccp_save_settings"  class="button button-primary">Save Settings</button>
                    </p>

                </div>';

            echo '</form>';
        echo '</div>';
    echo '</div>';
}
