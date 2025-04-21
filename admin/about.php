<?php

/**
 * About page for the Revalidate for Vercel plugin.
 */
function revalidate_for_vercel_about_menu() {
    add_submenu_page(
        'revalidate-for-vercel',
        __('About', 'revalidate-for-vercel'),
        __('About', 'revalidate-for-vercel'),
        'manage_options',
        'revalidate-for-vercel-about',
        'revalidate_for_vercel_about_page'
    );
}
add_action('admin_menu', 'revalidate_for_vercel_about_menu');

/**
 * Callback function for the About page.
 */
function revalidate_for_vercel_about_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('About Revalidate for Vercel', 'revalidate-for-vercel'); ?></h1>
        <p>
            <?php esc_html_e('This plugin allows your WordPress site to trigger Incremental Static Regeneration (ISR) on a Next.js frontend hosted on Vercel, each time a post is updated.', 'revalidate-for-vercel'); ?>
        </p>
        <p>
            <?php esc_html_e('It supports admin configuration, manual testing, logging, email alerts on failure, and CSV export.', 'revalidate-for-vercel'); ?>
        </p>
        <h2><?php esc_html_e('Developed by', 'revalidate-for-vercel'); ?></h2>
        <p>
            Arnaud Martin — <a href="https://www.digital-advantage.com" target="_blank">digital-advantage.com</a>
        </p>
        <h2><?php esc_html_e('Version', 'revalidate-for-vercel'); ?></h2>
        <p>1.5</p>
    </div>
    <?php
}
