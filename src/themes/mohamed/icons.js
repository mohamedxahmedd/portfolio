/** Icomoon icon (bundled with the template) for each social platform in src/data/profile.js. */
const SOCIAL_ICONS = {
    linkedin: 'icon-linkedin-in',
    github: 'icon-github',
    instagram: 'icon-instagram',
    facebook: 'icon-facebook-f',
    x: 'icon-twitter-x',
    twitter: 'icon-twitter-x',
    youtube: 'icon-youtube',
    behance: 'icon-behance',
    dribbble: 'icon-dribbble',
    medium: 'icon-medium',
    tiktok: 'icon-tiktok-filled',
};

export const socialIcon = (platform) => `icon ${SOCIAL_ICONS[platform] ?? 'icon-global'}`;

/** Path helper for the template's static assets in public/themes/mohamed/. */
export const asset = (path) => `/themes/mohamed/${path}`;
