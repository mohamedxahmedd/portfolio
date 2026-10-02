/** Font Awesome icon for each social platform used in src/data/profile.js. */
const SOCIAL_ICONS = {
    linkedin: 'fab fa-linkedin-in',
    github: 'fab fa-github',
    instagram: 'fab fa-instagram',
    facebook: 'fab fa-facebook-f',
    x: 'fab fa-x-twitter',
    twitter: 'fab fa-x-twitter',
    youtube: 'fab fa-youtube',
    behance: 'fab fa-behance',
    dribbble: 'fab fa-dribbble',
    medium: 'fab fa-medium',
    tiktok: 'fab fa-tiktok',
    whatsapp: 'fab fa-whatsapp',
};

export const socialIcon = (platform) => SOCIAL_ICONS[platform] ?? 'fas fa-link';
