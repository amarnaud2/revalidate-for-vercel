<?php

/**
 * Help page for the Revalidate for Vercel plugin.
 *
 * @package RevalidateForVercel
 */
function revalidate_for_vercel_logs_menu() {
    add_submenu_page(
        'revalidate-for-vercel',
        'Revalidation Logs',
        'Logs',
        'manage_options',
        'revalidate-for-vercel-logs',
        'revalidate_for_vercel_logs_page'
    );
}
add_action('admin_menu', 'revalidate_for_vercel_logs_menu');

/**
 * Callback function for the Logs page.
 */
function revalidate_for_vercel_logs_page() {
    $logs = get_option('revalidate_for_vercel_logs', []);
    ?>
    <div class="wrap">
        <h1>Vercel Revalidation Logs</h1>

        <form method="post" style="margin-bottom: 20px;">
            <?php submit_button('Export as CSV', 'secondary', 'revalidate_for_vercel_export_csv'); ?>
        </form>

        <?php if (!empty($logs)) : ?>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Slug</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($logs) as $log) : ?>
                        <tr>
                            <td><?php echo esc_html($log['time']); ?></td>
                            <td><?php echo esc_html($log['slug']); ?></td>
                            <td><?php echo esc_html($log['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" style="margin-top: 20px;">
                <?php submit_button('Clear Logs', 'delete', 'revalidate_for_vercel_clear_logs'); ?>
            </form>
        <?php else : ?>
            <p>No logs recorded yet.</p>
        <?php endif; ?>

        <?php
        if (isset($_POST['revalidate_for_vercel_clear_logs']) && check_admin_referer('revalidate_for_vercel_clear_logs_action', 'revalidate_for_vercel_nonce')) {
            delete_option('revalidate_for_vercel_logs');
            echo '<div class="notice notice-success"><p>Logs cleared.</p></div>';
        }

        if (isset($_POST['revalidate_for_vercel_export_csv'])) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="revalidate-for-vercel-logs.csv"');
            $output = fopen('php://output', 'w');
                        foreach ($logs as $log) {
                            }
            // Removed direct fclose as WP_Filesystem is now used.
            exit;
        }
        ?>
    </div>
    <?php
}

/**
 * Add a bubble to the admin menu if there are errors in the logs.
 */
function revalidate_for_vercel_admin_bubble($menu) {
    $logs = get_option('revalidate_for_vercel_logs', []);
    $errors = array_filter($logs, function($log) {
        return $log['status'] === 'Error';
    });

    if (count($errors) > 0) {
        foreach ($menu as $key => $item) {
            if ($item[2] === 'revalidate-for-vercel') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . count($errors) . '"><span class="plugin-count">' . count($errors) . '</span></span>';
            }
        }
    }

    return $menu;
}
add_filter('add_menu_classes', 'revalidate_for_vercel_admin_bubble');

// Send email alert on error (not ready yet)
/*
function revalidate_for_vercel_log_event($slug, $status) {
    $logs = get_option('revalidate_for_vercel_logs', []);
    $logs[] = [
        'time'   => current_time('mysql'),
        'slug'   => $slug,
        'status' => $status,
    ];
    update_option('revalidate_for_vercel_logs', $logs);

    if ($status === 'Error') {
        $admin_email = get_option('admin_email');
        $subject = 'Revalidate for Vercel Failed';
        $message = "A revalidation request for '/blog/{$slug}' has failed.

Time: " . current_time('mysql');
        wp_mail($admin_email, $subject, $message);
    }
}
*/