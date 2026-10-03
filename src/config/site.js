/**
 * ─────────────────────────────────────────────────────────────
 *  SITE CONFIG — the one file for site-wide switches.
 * ─────────────────────────────────────────────────────────────
 *
 *  Personal info  → src/data/profile.js
 *  Projects       → src/data/projects.js
 *  Tech stack     → src/data/technologies.js
 *  Legal pages    → src/data/pages.js
 */
export const siteConfig = {
    /**
     * ACTIVE THEME — change this one value to switch the whole site.
     *
     *   "reeni"    → Dark hot-pink design (Tailwind + Alpine.js): 3D tilt cards,
     *                custom cursor, letter-by-letter reveals, mouse parallax.
     *   "mohamed"  → Orange 3D-showcase design (Bootstrap template): looping
     *                video background, sidebar profile card, GSAP scroll effects.
     *
     * Each theme lives in src/themes/<name>/. After changing it, restart
     * `npm run dev` (or just push — Vercel rebuilds automatically).
     */
    theme: 'mohamed',

    /**
     * Public URL of the site, used for the sitemap, canonical links and
     * social-share tags. Leave empty on Vercel: the production URL Vercel
     * assigns is picked up automatically. Set it once you add a custom domain,
     * e.g. 'https://mohamedahmed.dev'.
     */
    url: '',

    /** Browser-tab title and search-engine description. */
    title: 'Mohamed Ahmed',
    tagline: 'Senior Flutter Developer · Cairo, Egypt',
    description:
        'Mohamed Ahmed — Senior Flutter developer in Cairo, building beautiful cross-platform mobile applications with state management and Firebase integration. Available for freelance & full-time work.',
    language: 'en',

    /** Max number of featured projects shown on the home page. */
    homeProjectsLimit: 6,

    /**
     * CONTACT FORM — optional, works without any service.
     *
     *   endpoint: null  → (default) "Send" opens the visitor's email app with
     *                     the message pre-filled, addressed to profile.contact.email.
     *                     No backend, no account, nothing to configure.
     *
     *   endpoint: 'https://formspree.io/f/xxxxxxx'
     *                   → messages are POSTed to a free form inbox service
     *                     (Formspree, Getform, Basin, …) and land in your email
     *                     without the visitor leaving the page. If the service
     *                     fails, the form falls back to the email-app method.
     */
    contactForm: {
        endpoint: 'https://formspree.io/f/xwlpgveq',
    },
};
