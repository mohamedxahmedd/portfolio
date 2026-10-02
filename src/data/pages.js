/**
 * ─────────────────────────────────────────────────────────────
 *  SIMPLE PAGES — each entry becomes a page at /<slug>.
 * ─────────────────────────────────────────────────────────────
 *  `body` is HTML. Remove an entry to remove the page (also remove its
 *  footer link in the active theme if it has one).
 */
import { profile } from './profile.js';

export const pages = [
    {
        slug: 'privacy-policy',
        title: 'Privacy Policy',
        excerpt: 'How your data is handled.',
        body: `<p>This portfolio is a static website. It has no database and does not store anything you type into it.</p>
<p>When you use the contact form, your message is handed to your own email app (or, if enabled, to a form-delivery service) so it can be sent to me. I only use it to reply to your enquiry and never sell or share it. You can ask me to delete our correspondence at any time by emailing <strong>${profile.contact.email}</strong>.</p>
<p>The site does not use tracking cookies or analytics.</p>`,
    },
    {
        slug: 'terms',
        title: 'Terms of Use',
        excerpt: 'Terms governing use of this site.',
        body: `<p>This portfolio is provided as-is for informational purposes. All project case studies, code samples, and content are the intellectual property of ${profile.name} unless otherwise credited.</p>
<p>You are welcome to view and share content. You may not republish substantial portions without permission.</p>`,
    },
];
