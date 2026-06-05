<?php
if (!defined('ABSPATH')) exit;

function ccp_render_messages_page() {

    global $wpdb;

    $table = $wpdb->prefix . 'ccp_messages';

    $total_messages = $wpdb->get_var(
    "SELECT COUNT(*) FROM $table"
    );

    $unread_messages = $wpdb->get_var(
        "SELECT COUNT(*) FROM $table WHERE status = 'unread'"
    );

    $read_messages = $wpdb->get_var(
        "SELECT COUNT(*) FROM $table WHERE status = 'read'"
    );

    $messages_per_page = 10;

    $current_page = isset($_GET['paged'])
        ? max(1, intval($_GET['paged']))
        : 1;

    $offset = ($current_page - 1) * $messages_per_page;

    $search = isset($_GET['s'])
        ? sanitize_text_field($_GET['s'])
        : '';

    $where = '';

    if (!empty($search)) {

        $where = $wpdb->prepare(
            "WHERE firstname LIKE %s
             OR email LIKE %s
             OR message LIKE %s",
            "%{$search}%",
            "%{$search}%",
            "%{$search}%"
        );
    }

    $total = $wpdb->get_var(
        "SELECT COUNT(*) FROM $table $where"
    );

    $pages = ceil($total / $messages_per_page);

    $results = $wpdb->get_results(
        "SELECT * FROM $table
         $where
         ORDER BY id DESC
         LIMIT $messages_per_page
         OFFSET $offset"
    );

    echo '<div class="wrap">';

        echo '
        <div class="ccp-stats-grid">

            <div class="ccp-stat-card">
                <span>Total Messages</span>
                <strong>' . $total_messages . '</strong>
            </div>

            <div class="ccp-stat-card">
                <span>Unread</span>
                <strong>' . $unread_messages . '</strong>
            </div>

            <div class="ccp-stat-card">
                <span>Read</span>
                <strong>' . $read_messages . '</strong>
            </div>

        </div> ';

     echo '<h1>Contact Messages</h1>';
     

        
        // SEARCH FORMs
        
        echo '
        <form method="GET">
            <input type="hidden" name="page" value="ccp-messages">

            <input type="search" name="s" value="' . esc_attr($search) . '" placeholder="Search messages...">

            <button class="button">Search</button>
        </form> <br>';

        
        // BULK ACTION FORM START
        
        echo '
        <form method="POST" action="' . admin_url('admin-post.php') . '">

            <input type="hidden" name="action" value="ccp_bulk_delete_messages">

            <select name="bulk_action">
                <option value="">Bulk Actions</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="button">Apply</button>

           <a href="' . wp_nonce_url(admin_url('admin-post.php?action=ccp_export_messages'),'ccp_export_messages') . '" class="button button-secondary">
                Export CSV
            </a>

            <br><br>

            <table class="widefat striped ccp-inbox-table">

                <thead>
                    <tr>
                        <th><input type="checkbox" id="ccp-select-all"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>';

                    foreach ($results as $row) {

                        //  FIX GMAIL STYLE ROW CLASS
                        $row_class = ($row->status === 'read') ? 'ccp-read' : 'ccp-unread';

                        $read_url = wp_nonce_url(
                            admin_url('admin-post.php?action=ccp_mark_read&id=' . $row->id),
                            'ccp_mark_read_' . $row->id
                        );

                        $view_url = admin_url('admin.php?page=ccp-view-message&id=' . $row->id);

                        $delete_url = wp_nonce_url(
                            admin_url('admin-post.php?action=ccp_delete_message&id=' . $row->id),
                            'ccp_delete_message_' . $row->id
                        );

                        echo '
                        <tr class="' . esc_attr($row_class) . '">

                            <td>
                                <input type="checkbox" name="message_ids[]" value="' . $row->id . '">
                            </td>

                            <td>' . $row->id . '</td>
                            <td>' . esc_html($row->firstname) . '</td>
                            <td>' . esc_html($row->email) . '</td>
                            <td>' . esc_html(wp_trim_words($row->message, 10)) . '</td>
                            <td>' . esc_html($row->created_at) . '</td>

                            <td>';

                              if ($row->status === 'read') {
                                    echo '<span class="ccp-badge ccp-badge-read">Read</span>';
                                } else {
                                    echo '<span class="ccp-badge ccp-badge-unread">Unread</span>';
                                }

                                echo '<br><a href="' . esc_url($read_url) . '">Mark as Read</a>';
                         echo '</td>

                           <td>
                                <a class="button button-small" href="' . esc_url($view_url) . '">View</a>
                                <a class="button button-small" href="' . esc_url($delete_url) . '">Delete</a>
                            </td>

                        </tr>';
                    }
                        echo '
                </tbody>
            </table>
        </form>
        ';

        
        // PAGINATION
        
        echo '<div class="ccp-pagination" style="margin-top:20px;">';

            for ($i = 1; $i <= $pages; $i++) {

                $url = add_query_arg(
                    [
                        'page'  => 'ccp-messages',
                        'paged' => $i,
                        's'     => $search
                    ],
                    admin_url('admin.php')
                );

                if ($i == $current_page) {
                    echo '<strong style="margin-right:10px;">' . $i . '</strong>';
                } else {
                    echo '<a style="margin-right:10px;" href="' . esc_url($url) . '">' . $i . '</a>';
                }
            }

        echo '</div>';
echo '</div>';
}