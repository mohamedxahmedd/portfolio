/**
 * ─────────────────────────────────────────────────────────────
 *  PROFILE — everything about you, in one place.
 * ─────────────────────────────────────────────────────────────
 *  Both themes read from this file. Edit a value, save, done.
 *  Images referenced here live in /public (e.g. /profile/photo.webp
 *  is the file public/profile/photo.webp).
 */

export const profile = {
    name: 'Mohamed Ahmed',
    jobTitle: 'Senior Flutter Developer',
    /** Big hero headline (Mohamed theme) and About heading. */
    headline: 'Building Amazing Mobile Apps with Flutter',
    /** One-liner under the hero title. */
    shortBio: 'Flutter Developer delivering exceptional mobile applications.',
    /** Long bio. Separate paragraphs with a blank line. */
    bio: `I'm a passionate Flutter developer based in Cairo, Egypt, with 4+ years of experience in building cross-platform mobile applications.

I specialize in creating beautiful, performant apps using Flutter and Dart, with deep expertise in state management patterns (BLoC, Provider, Riverpod, GetX), Firebase integration, REST APIs, and material design systems.

From concept to deployment on the App Store and Play Store, I deliver production-ready apps that solve real problems for real users.`,
    location: 'Cairo, Egypt',
    availability: 'Available for freelance & full-time roles',

    /** Rotating phrases typed out in the Reeni hero. */
    heroRoles: [
        'Senior Flutter Developer.',
        'Cross-platform App Builder.',
        'State Management Expert.',
        'Firebase Architect.',
    ],

    /** Your photo. Replace the file, or point to a new one. */
    photo: '/profile/photo.webp',
    /** Handwritten signature (Mohamed theme). Set to null to hide it. */
    signature: '/profile/signature.webp',
    /**
     * Downloadable CV/resume. Drop a PDF at public/profile/resume.pdf and set
     * this to '/profile/resume.pdf'. null hides the "Download CV" button.
     */
    resume: null,

    contact: {
        email: 'mmmohamedahmedmm@gmail.com',
        /** Shown as written; also used for the tap-to-call link. */
        phone: '+20 101 396 4804',
        /** International format, digits only (country code first). null hides WhatsApp. */
        whatsapp: '201013964804',
        workingHours: 'Mon — Fri · 9:00 AM — 6:00 PM (GMT+2)',
    },

    /**
     * Social links. `platform` picks the icon — supported: linkedin, github,
     * instagram, facebook, x, twitter, youtube, behance, dribbble, medium,
     * tiktok, whatsapp. Unknown platforms get a generic link icon.
     * showInHeader: also show it in the top navigation (Reeni theme).
     */
    socials: [
        { platform: 'linkedin', label: 'LinkedIn', url: 'https://linkedin.com/in/mohamed-ahmed-517408238', showInHeader: true },
        { platform: 'github', label: 'GitHub', url: 'https://github.com/mohamedxahmedd', showInHeader: true },
        { platform: 'instagram', label: 'Instagram', url: 'https://instagram.com/mohamedxahmedd' },
        { platform: 'facebook', label: 'Facebook', url: 'https://facebook.com/share/1DDTyVTFSe' },
    ],

    /**
     * Counters in the hero. Shown in this order (Mohamed theme shows the
     * first two). `suffix` is appended after the number.
     */
    stats: [
        { label: 'Years experience', value: 4, suffix: '+' },
        { label: 'Projects shipped', value: 10, suffix: '+' },
        { label: 'Core services', value: 3, suffix: '' },
    ],

    /** Newest first. `end: null` means "Present". */
    experience: [
        {
            role: 'Senior Flutter Developer',
            company: 'TechFlow Solutions',
            location: 'Remote',
            start: '2022',
            end: null,
            description:
                'Leading Flutter app development for cross-platform mobile applications. Architected scalable BLoC patterns, integrated Firebase services, and mentored junior developers.',
        },
        {
            role: 'Mobile App Developer',
            company: 'AppVenture Studio',
            location: 'Cairo, Egypt',
            start: '2020',
            end: '2021',
            description:
                'Developed production Flutter apps for fitness, e-commerce, and social-media clients. Implemented complex animations and real-time data synchronization.',
        },
        {
            role: 'Flutter Developer',
            company: 'Digital Innovations Ltd',
            location: 'Cairo, Egypt',
            start: '2019',
            end: '2020',
            description:
                'Built mobile applications using Flutter for clients across the Middle East. Focused on UI/UX implementation, REST API integration, and Play Store deployments.',
        },
        {
            role: 'Junior Flutter Developer',
            company: 'StartUp Mobile Labs',
            location: 'Cairo, Egypt',
            start: '2018',
            end: '2019',
            description:
                'Started professional Flutter development. Learned modern mobile-app architecture, contributed to client projects, and built foundational skills with state management.',
        },
    ],

    /** `end: null` means "Present". */
    education: [
        {
            degree: 'Advanced Flutter Development',
            institution: 'Google Developer Certification',
            start: '2022',
            end: null,
            description:
                'Specialized in advanced Flutter techniques, animations, custom render objects, and platform-channels integration.',
        },
        {
            degree: "Bachelor's Degree in Computer Science",
            institution: 'Tech University',
            start: '2014',
            end: '2018',
            description:
                'Foundation in algorithms, software engineering, mobile development, and computer-science fundamentals.',
        },
        {
            degree: 'UI/UX Design Certification',
            institution: 'Design Institute',
            start: '2019',
            end: '2019',
            description:
                'Mastered mobile-first UI/UX design principles, Material Design, prototyping, and user-research methodology.',
        },
        {
            degree: 'Mobile Development Bootcamp',
            institution: 'Online Coding Academy',
            start: '2018',
            end: '2018',
            description:
                'Intensive bootcamp on Dart, Flutter framework basics, and modern mobile-app architecture patterns.',
        },
    ],

    /**
     * Skill groups with proficiency bars (0–100).
     * `icon` values are Font Awesome classes: https://fontawesome.com/search?o=r&m=free
     */
    skills: [
        {
            category: 'UI/UX Design',
            icon: 'fas fa-pencil-ruler',
            items: [
                { name: 'Figma', level: 90, icon: 'fab fa-figma' },
                { name: 'Adobe XD', level: 85, icon: 'fab fa-adobe' },
                { name: 'Material Design', level: 95, icon: 'fab fa-google' },
                { name: 'Prototyping', level: 80, icon: 'fas fa-vector-square' },
            ],
        },
        {
            category: 'Development Skill',
            icon: 'fas fa-code',
            items: [
                { name: 'Flutter', level: 95, icon: 'fas fa-mobile-alt' },
                { name: 'Dart', level: 90, icon: 'fas fa-code' },
                { name: 'Firebase', level: 85, icon: 'fas fa-fire' },
                { name: 'REST APIs', level: 88, icon: 'fas fa-server' },
            ],
        },
    ],

    services: [
        {
            title: 'Flutter Development',
            tagline: 'Cross-Platform Apps',
            description:
                'Building beautiful, performant cross-platform mobile apps for iOS and Android with a single Flutter codebase. From MVP to production, I deliver pixel-perfect apps that users love.',
            icon: 'fas fa-mobile-alt',
            features: ['Pixel-perfect UI', 'Custom animations', 'Native integrations', 'Adaptive layouts'],
        },
        {
            title: 'State Management',
            tagline: 'Mobile Apps',
            description:
                'Implementing robust state management solutions using BLoC, Provider, Riverpod, and GetX. Clean architecture, testable code, predictable state — built for scale.',
            icon: 'fas fa-cogs',
            features: ['BLoC pattern', 'Riverpod', 'Clean architecture', 'Testable code'],
        },
        {
            title: 'API Integration',
            tagline: 'Backend Connectivity',
            description:
                'Seamless REST API integration, Firebase services, push notifications, real-time data sync, authentication flows, and third-party SDK integrations.',
            icon: 'fas fa-server',
            features: ['REST & GraphQL', 'Firebase Suite', 'Push notifications', 'OAuth & JWT'],
        },
    ],

    /** "How I work" steps (Reeni theme). */
    process: [
        { title: 'Discover', icon: 'fas fa-comments', text: 'We talk through your idea, users, constraints, and what success looks like — no fluff, just clarity.' },
        { title: 'Design', icon: 'fas fa-pencil-ruler', text: 'Wireframes & high-fidelity Figma mocks so you can see and feel the app before we build a screen.' },
        { title: 'Build', icon: 'fas fa-code', text: 'Production-grade Flutter with BLoC/Riverpod state, Firebase backend, and weekly demo builds.' },
        { title: 'Launch', icon: 'fas fa-rocket', text: 'App Store + Play Store submission, post-launch monitoring, and a 30-day support window included.' },
    ],

    /**
     * Client testimonials. `avatar` is optional (e.g. '/testimonials/andrew.webp');
     * without it, the person's initials are shown.
     */
    testimonials: [
        {
            name: 'Andrew Bolar',
            role: 'Product Manager',
            company: 'TechFlow Solutions',
            quote: 'Mohamed delivered our Flutter app ahead of schedule and exceeded every expectation. Communication was excellent, code quality was top-tier, and the final product launched smoothly on both stores.',
            rating: 5,
        },
        {
            name: 'Theresa Webb',
            role: 'UI Designer',
            company: 'Design Studio',
            quote: 'Working with Mohamed was a pleasure. He translated our designs pixel-perfectly into Flutter and added subtle animations that made the app feel premium. Highly recommend.',
            rating: 5,
        },
        {
            name: 'Keil Johnson',
            role: 'Software Engineer',
            company: 'AppVenture Studio',
            quote: 'Mohamed is a talented Flutter developer with deep knowledge of state management. He architected our app with BLoC and the codebase is clean, testable, and maintainable.',
            rating: 5,
        },
    ],
};
