<?php

function revalidate_for_vercel_help_menu() {
    add_submenu_page(
        'revalidate-for-vercel',
        __('Help & Integration', 'revalidate-for-vercel'),
        __('Help & Integration', 'revalidate-for-vercel'),
        'manage_options',
        'revalidate-for-vercel-help',
        'revalidate_for_vercel_help_page'
    );
}
add_action('admin_menu', 'revalidate_for_vercel_help_menu');

function revalidate_for_vercel_help_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Integration with Next.js (Pages & App Router)', 'revalidate-for-vercel'); ?></h1>
        <p><?php esc_html_e('This plugin works with both routing systems in Next.js: Pages Router and App Router. Below are examples to help you set up your endpoint correctly.', 'revalidate-for-vercel'); ?></p>
    <div style="padding: 1rem; background: #f1f1f1; border-left: 4px solid #0073aa; margin-bottom: 2rem;">
      <p><strong><?php esc_html_e('🔒 This plugin uses HMAC signature validation by default.', 'revalidate-for-vercel'); ?></strong><br>
      <?php esc_html_e('All revalidation requests are cryptographically signed to ensure they are authentic and tamper-proof. Your secret key is never exposed in the URL — only a hashed version is transmitted. This protects your Next.js site from unauthorized invalidation attempts.', 'revalidate-for-vercel'); ?>
      </p>
    </div>
    <div style="padding: 1rem; background: #fff3cd; border-left: 4px solid #ff9900; margin-bottom: 2rem;">
      <p><strong><?php esc_html_e('⚠️ Important note about Edge Functions (App Router)', 'revalidate-for-vercel'); ?></strong><br>
      <?php esc_html_e('If your revalidation endpoint is deployed as an Edge Function (e.g. using the App Router in edge runtime mode), the native Node.js crypto module may not be available.', 'revalidate-for-vercel'); ?>
      <br>
      <?php esc_html_e('In that case, use the Web Crypto API instead to validate the HMAC signature.', 'revalidate-for-vercel'); ?>
      </p>
    </div>


        <h2><?php esc_html_e('1. Pages Router with TypeScript (/pages/api/revalidate.ts)', 'revalidate-for-vercel'); ?></h2>
        <pre><code>import type { NextApiRequest, NextApiResponse } from 'next';

export default async function handler(req: NextApiRequest, res: NextApiResponse) {
  const { slug, signature } = req.query;

  if (!slug || !signature) {
    return res.status(400).json({ message: 'Missing parameters' });
  }

  const expectedSig = require('crypto')
    .createHmac('sha256', process.env.REVALIDATE_SECRET!)
    .update(slug as string)
    .digest('hex');

  if (signature !== expectedSig) {
    return res.status(401).json({ message: 'Invalid signature' });
  }

  try {
    await res.revalidate(`/blog/${slug}`);
    return res.json({ revalidated: true });
  } catch (err: any) {
    return res.status(500).json({ message: 'Error revalidating', error: err.message });
  }
}</code></pre>

<h2><?php esc_html_e('2. Pages Router with JavaScript (/pages/api/revalidate.js)', 'revalidate-for-vercel'); ?></h2>
    <pre><code>const crypto = require('crypto');

export default async function handler(req, res) {
  const { slug, signature } = req.query;

  if (!slug || !signature) {
    return res.status(400).json({ message: 'Missing parameters' });
  }

  const expectedSig = crypto.createHmac('sha256', process.env.REVALIDATE_SECRET)
    .update(slug)
    .digest('hex');

  if (signature !== expectedSig) {
    return res.status(401).json({ message: 'Invalid signature' });
  }

  try {
    await res.revalidate(`/blog/${slug}`);
    return res.json({ revalidated: true });
  } catch (err) {
    return res.status(500).json({ message: 'Error revalidating', error: err.message });
  }
}</code></pre>

        <p><?php esc_html_e('Replace `/blog/${slug}` with the path matching your Next.js dynamic route.', 'revalidate-for-vercel'); ?></p>
    
    <h2><?php esc_html_e('3. App Router with TypeScript (/app/api/revalidate/route.ts)', 'revalidate-for-vercel'); ?></h2>
    <pre><code>import { NextRequest, NextResponse } from 'next/server';
import { createHmac } from 'crypto';

export async function GET(req: NextRequest) {
  const { searchParams } = new URL(req.url);
  const slug = searchParams.get('slug');
  const signature = searchParams.get('signature');

  if (!slug || !signature) {
    return NextResponse.json({ message: 'Missing parameters' }, { status: 400 });
  }

  const expectedSig = createHmac('sha256', process.env.REVALIDATE_SECRET!)
    .update(slug)
    .digest('hex');

  if (signature !== expectedSig) {
    return NextResponse.json({ message: 'Invalid signature' }, { status: 401 });
  }

  return new NextResponse(null, {
    status: 200,
    headers: {
      'x-revalidate-for-vercel': '1',
      'x-vercel-path': `/blog/${slug}`,
    },
  });
}</code></pre>

    <h2><?php esc_html_e('4. App Router with JavaScript (/app/api/revalidate/route.js)', 'revalidate-for-vercel'); ?></h2>
    <pre><code>const crypto = require('crypto');

export async function GET(req) {
  const { searchParams } = new URL(req.url);
  const slug = searchParams.get('slug');
  const signature = searchParams.get('signature');

  if (!slug || !signature) {
    return new Response(JSON.stringify({ message: 'Missing parameters' }), { status: 400 });
  }

  const expectedSig = crypto.createHmac('sha256', process.env.REVALIDATE_SECRET)
    .update(slug)
    .digest('hex');

  if (signature !== expectedSig) {
    return new Response(JSON.stringify({ message: 'Invalid signature' }), { status: 401 });
  }

  return new Response(null, {
    status: 200,
    headers: {
      'x-revalidate-for-vercel': '1',
      'x-vercel-path': `/blog/${slug}`,
    },
  });
}</code></pre>

</div>
    <?php
}