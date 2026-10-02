/**
 * ─────────────────────────────────────────────────────────────
 *  TECH STACK — shown in the tech marquee / tech-stack slider,
 *  and used for the "filter by technology" buttons on /projects.
 * ─────────────────────────────────────────────────────────────
 *  A project lists technologies by `name` (see src/data/projects.js).
 *  Names are matched case-insensitively. A project may also use a
 *  name that isn't listed here — it still shows as a tag, just with
 *  a generic icon.
 *
 *  icon:  Font Awesome class — https://fontawesome.com/search?o=r&m=free
 *  color: brand color, used by the Mohamed theme's tech-stack cards.
 */
export const technologies = [
    { name: 'Flutter', icon: 'fas fa-mobile-alt', color: '#02569B' },
    { name: 'Dart', icon: 'fas fa-code', color: '#0175C2' },
    { name: 'BLoC / Cubit', icon: 'fas fa-cube', color: '#1976D2' },
    { name: 'Clean Architecture', icon: 'fas fa-layer-group', color: '#455A64' },
    { name: 'REST API', icon: 'fas fa-server', color: '#6C757D' },
    { name: 'Firebase', icon: 'fas fa-fire', color: '#FFCA28' },
    { name: 'Stripe', icon: 'fab fa-stripe', color: '#635BFF' },
    { name: 'Payment Gateways', icon: 'fas fa-credit-card', color: '#2E7D32' },
    { name: 'Push Notifications', icon: 'fas fa-bell', color: '#FF6F00' },
    { name: 'Google Maps', icon: 'fas fa-map-marked-alt', color: '#34A853' },
    { name: 'GPS & Geofencing', icon: 'fas fa-location-arrow', color: '#EA4335' },
    { name: 'Biometrics', icon: 'fas fa-fingerprint', color: '#00897B' },
    { name: 'Localization & RTL', icon: 'fas fa-language', color: '#5C6BC0' },
    { name: 'Offline Sync', icon: 'fas fa-sync-alt', color: '#8D6E63' },
    { name: 'Animations', icon: 'fas fa-magic', color: '#E91E63' },
    { name: 'Custom UI', icon: 'fas fa-paint-brush', color: '#9C27B0' },
];
