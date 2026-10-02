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
    { name: 'Firebase', icon: 'fas fa-fire', color: '#FFCA28' },
    { name: 'BLoC', icon: 'fas fa-cube', color: '#1976D2' },
    { name: 'Riverpod', icon: 'fas fa-water', color: '#3578E5' },
    { name: 'Provider', icon: 'fas fa-share-alt', color: '#1389FD' },
    { name: 'GetX', icon: 'fas fa-bolt', color: '#9B40A2' },
    { name: 'REST API', icon: 'fas fa-server', color: '#6C757D' },
    { name: 'Cloud Firestore', icon: 'fas fa-database', color: '#FF9800' },
    { name: 'Stripe', icon: 'fab fa-stripe', color: '#635BFF' },
    { name: 'FCM Notifications', icon: 'fas fa-bell', color: '#FF6F00' },
    { name: 'Animations', icon: 'fas fa-magic', color: '#E91E63' },
    { name: 'Custom UI', icon: 'fas fa-paint-brush', color: '#9C27B0' },
];
