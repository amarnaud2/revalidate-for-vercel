<?php

/**
 * Help page for the Revalidate for Vercel plugin.
 *
 * @package RevalidateForVercel
 */
function revalidate_for_vercel_admin_menu() {
    add_menu_page(
        'Revalidate for Vercel',
        'Revalidate for Vercel',
        'manage_options',
        'revalidate-for-vercel',
        'revalidate_for_vercel_settings_page',
        'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCA3NiA2NSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cGF0aCBkPSJNMzcuNTI3NCAwTDc1LjA1NDggNjVIMEwzNy41Mjc0IDBaIiBmaWxsPSIjMDAwMDAwIi8+Cjwvc3ZnPg==',
        81
    );
}
add_action('admin_menu', 'revalidate_for_vercel_admin_menu');

/**
 * Callback function for the Revalidate for Vercel settings page.
 */
function revalidate_for_vercel_settings_page() {
    ?>
    <div class="wrap">
        <h1>Revalidate for Vercel Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('revalidate_for_vercel_settings');
            do_settings_sections('revalidate-for-vercel');
            submit_button();
            ?>
        </form>

        <hr />

        <h2>Manual Revalidation Test</h2>
        <form method="post">
            <?php wp_nonce_field('revalidate_for_vercel_test_action', 'revalidate_for_vercel_nonce'); ?>
            <input type="text" name="revalidate_for_vercel_test_slug" placeholder="Enter slug (e.g. my-post-slug)" class="regular-text" required />
            <?php submit_button('Revalidate Now', 'primary', 'revalidate_for_vercel_test_submit'); ?>
        </form>

        <?php
        if (
            isset($_POST['revalidate_for_vercel_test_submit']) &&
            check_admin_referer('revalidate_for_vercel_test_action', 'revalidate_for_vercel_nonce')
        ) {
            $slug = isset($_POST['revalidate_for_vercel_test_slug'])
                ? sanitize_text_field(wp_unslash($_POST['revalidate_for_vercel_test_slug']))
                : '';

            $secret = get_option('revalidate_for_vercel_secret');
            $endpoint = get_option('revalidate_for_vercel_url');

            if ($slug && $secret && $endpoint) {
                $url = add_query_arg([
                    'secret' => $secret,
                    'slug'   => $slug,
                ], $endpoint);

                $response = wp_remote_get($url, [
                    'method'    => 'GET',
                    'timeout'   => 5,
                    'headers'   => [
                        'Content-Type' => 'application/json',
                    ],
                ]);

                if (!is_wp_error($response)) {
                    echo '<div class="notice notice-success"><p>Revalidation triggered for <code>/blog/' . esc_html($slug) . '</code>.</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error: ' . esc_html($response->get_error_message()) . '</p></div>';
                }
            }
        }
        ?>
    </div>
    <?php
}

/**
 * Register settings for the Revalidate for Vercel plugin.
 */
function revalidate_for_vercel_secret_args() {
    return [
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'string',
        'show_in_rest'      => false,
    ];
}

/** 
 * Register settings for the Revalidate for Vercel plugin.
 */
function revalidate_for_vercel_url_args() {
    return [
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'string',
        'show_in_rest'      => false,
    ];
}

/**
 * Register settings for the Revalidate for Vercel plugin.
 */
function revalidate_for_vercel_register_settings() {
    register_setting('revalidate_for_vercel_settings', 'revalidate_for_vercel_secret', revalidate_for_vercel_secret_args());
    register_setting('revalidate_for_vercel_settings', 'revalidate_for_vercel_url', revalidate_for_vercel_url_args());
    
    add_settings_section(
        'revalidate_for_vercel_section',
        'Revalidation Settings',
        null,
        'revalidate-for-vercel'
    );

    add_settings_field(
        'revalidate_for_vercel_secret',
        'Revalidation Secret',
        'revalidate_for_vercel_secret_render',
        'revalidate-for-vercel',
        'revalidate_for_vercel_section'
    );

    add_settings_field(
        'revalidate_for_vercel_url',
        'Revalidation Endpoint URL',
        'revalidate_for_vercel_url_render',
        'revalidate-for-vercel',
        'revalidate_for_vercel_section'
    );
}
add_action('admin_init', 'revalidate_for_vercel_register_settings');

/**
 * Render the Revalidation Secret input field.
 */
function revalidate_for_vercel_secret_render() {
    $value = get_option('revalidate_for_vercel_secret');
    echo "<input type='text' name='revalidate_for_vercel_secret' value='" . esc_attr($value) . "' class='regular-text' />";
}

/**
 * Render the Revalidation Endpoint URL input field.
 */
function revalidate_for_vercel_url_render() {
    $value = get_option('revalidate_for_vercel_url');
    echo "<input type='text' name='revalidate_for_vercel_url' value='" . esc_attr($value) . "' class='regular-text' />";
}
