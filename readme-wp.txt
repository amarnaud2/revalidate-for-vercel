=== Revalidate for Vercel ===
Contributors: arnaudmartin
Tags: nextjs, vercel, isr, revalidate, static
Requires at least: 5.5
Tested up to: 6.7
Stable tag: 1.5
Requires PHP: 7.4
Tested up to PHP: 8.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Trigger ISR (Incremental Static Regeneration) from WordPress to Vercel on post update. Perfect for decoupled Next.js + WordPress setups.

== Description ==

This lightweight plugin sends a revalidation request to your Vercel-hosted Next.js app every time a WordPress post is updated or published.

Features:
* Automatic revalidation on post update
* Admin settings page to configure endpoint and secret
* Secure HMAC signature verification by default
* Manual revalidation form for any slug
* Log history with export and cleanup
* Compatible with Next.js Pages Router & App Router
* Multilingual support: English and French

Ideal if you're using `getStaticProps` with `revalidate` in your Next.js app.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu.
3. Go to **Settings > Revalidate for Vercel** and configure your secret and endpoint URL.
4. Ensure your Next.js app has an API route like `/api/revalidate` that validates the secret and triggers ISR.

== Frequently Asked Questions ==

= Do I need to use Vercel? =
Yes. This plugin is designed to work with ISR via a custom API endpoint deployed on Vercel.

= Can I revalidate a specific slug manually? =
Yes. The admin settings page includes a form to revalidate any given slug manually.

= How do I secure the connection? =
Use a strong secret key and check it inside your Next.js API route before triggering revalidation. This key is never send in clear. It's encrypted.

= Is it compatible with all themes? =
Yes. The plugin works in the background and doesn’t interfere with any frontend theme.

= Can I clear the logs? =
Yes, the Logs page allows you to view and delete all revalidation history.

= Is this plugin an official plugin from Vercel? =
No, it's not affiliated with Vercel.

== Screenshots ==
1. Settings page to configure endpoint and secret
2. Logs with time, slug, and status
3. Help and Integration tab

== Changelog =

= 1.5 =
* 🔒 WP_Filesystem export refactor
* 🛠️ GitHub Actions release flow with auto-zip
* 🧼 Clean build without DS_Store or build-release.sh

= 1.4 =
* Added HMAC signature verification for secure endpoint calls
* Added App Router and Pages Router examples in JS and TS
* Integrated help link in admin panel for direct access to documentation

= 1.3 =
* Added multilingual support (en_US, fr_FR)
* Added FAQ and About section
* SVG icon support (Vercel triangle)

= 1.2 =
* Added admin logs, error badges, and email alerts

= 1.1 =
* Added manual revalidation test form

= 1.0 =
* Initial release with automatic post-based ISR trigger

== Donations ==

If you enjoy this plugin and want to support its development, consider buying me a coffee or making a donation via PayPal:

👉 https://paypal.me/arnaud2m
