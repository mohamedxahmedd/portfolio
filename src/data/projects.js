/**
 * ─────────────────────────────────────────────────────────────
 *  PROJECTS — add, remove, edit and reorder your work here.
 * ─────────────────────────────────────────────────────────────
 *  To add a project:
 *    1. Put its images in public/projects/<slug>/
 *    2. Copy an object below, change the values.
 *    3. Save (and push). The card, the /projects listing and the
 *       /projects/<slug> detail page are generated automatically.
 *
 *  ORDER: projects appear in the order they are written here.
 *  FEATURED: `featured: true` projects are shown on the home page
 *            (up to siteConfig.homeProjectsLimit) with a "Featured" badge.
 *  DRAFT: `draft: true` hides a project everywhere without deleting it.
 *
 *  Required: slug, title, shortDescription. Everything else is optional —
 *  leave a field out (or set it to null / []) and that bit isn't shown.
 *  Full field reference: PORTFOLIO_GUIDE.md
 */
export const projects = [
    {
        slug: 'excraft',
        title: 'ExCraft',
        subtitle: 'Export Academy & Import Marketplace',
        shortDescription:
            'An Arabic-first mobile platform for aspiring exporters: an academy of courses and in-person workshops, plus a marketplace for importing products to Egypt.',
        description: `ExCraft helps people launch their export journey with confidence. The app combines an academy — video courses, categorised learning tracks and in-person workshops with schedules, locations and session-by-session curricula — with an import marketplace for sourcing products into Egypt.

Built with Flutter as a fully right-to-left Arabic experience, it ships to both the App Store and Google Play.`,
        features: ['Course academy', 'Workshops with maps & schedules', 'Import marketplace', 'Cart & checkout', 'Instructor profiles', 'Arabic RTL UI'],
        year: '2025',
        role: 'Senior Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'REST API'],
        thumbnail: '/projects/excraft/thumbnail.webp',
        images: [
            '/projects/excraft/screen-01.webp',
            '/projects/excraft/screen-02.webp',
            '/projects/excraft/screen-03.webp',
            '/projects/excraft/screen-04.webp',
            '/projects/excraft/screen-05.webp',
            '/projects/excraft/screen-06.webp',
            '/projects/excraft/screen-07.webp',
            '/projects/excraft/screen-08.webp',
            '/projects/excraft/screen-09.webp',
            '/projects/excraft/screen-10.webp',
            '/projects/excraft/screen-11.webp',
            '/projects/excraft/screen-12.webp',
            '/projects/excraft/screen-13.webp',
        ],
        featured: true,
        appStoreUrl: 'https://apps.apple.com/br/app/excraft/id6746088577',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.hossamXStudios.excraftApp',
    },
    {
        slug: 'saas-website-design',
        title: 'SAAS Website Design',
        subtitle: 'Comprehensive SAAS Platform',
        shortDescription:
            'A comprehensive SAAS platform with subscription management, real-time analytics, and a multi-tenant architecture.',
        description:
            'A full-featured SAAS platform built end-to-end with Flutter for the front-end and Firebase for the back-end. Includes subscription management, real-time analytics dashboards, and a multi-tenant architecture supporting hundreds of organizations.',
        problem: 'Clients needed a unified way to manage subscriptions across iOS and Android with real-time analytics.',
        solution: 'Built a Flutter codebase with shared architecture that handles authentication, subscription state, and live data sync via Firestore.',
        features: ['User authentication', 'Real-time data sync', 'Responsive design', 'Dark/light mode', 'Subscription management', 'Multi-tenant architecture'],
        year: '2024',
        role: 'Senior Flutter Developer',
        duration: '3 months',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Firebase', 'Provider', 'REST API'],
        featured: true,
    },
    {
        slug: 'workout-app-design',
        title: 'Workout App Design',
        subtitle: 'Fitness Tracking Application',
        shortDescription:
            'A fitness-tracking application with custom workout plans, progress analytics, and social-sharing features.',
        description:
            'A complete fitness companion built with Flutter — track workouts, follow custom exercise plans, and watch progress with detailed analytics. Includes social sharing, daily reminders, and personal-records tracking.',
        problem: 'Existing fitness apps were either too complex or lacked custom plan creation.',
        solution: 'A clean, focused Flutter app with intuitive workout logging, custom plan builder, and rich progress visualizations.',
        features: ['Workout tracking', 'Custom exercise plans', 'Progress analytics', 'Social sharing', 'Push notifications', 'Personal records'],
        year: '2024',
        role: 'Senior Flutter Developer',
        duration: '4 months',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Firebase', 'BLoC', 'Cloud Firestore', 'FCM Notifications'],
        featured: true,
    },
    {
        slug: 'e-commerce-mobile-app',
        title: 'E-Commerce Mobile App',
        subtitle: 'Full-Featured Shopping Platform',
        shortDescription:
            'A fully-featured e-commerce application with secure payments, product catalog, shopping cart, and order tracking.',
        description:
            'A production e-commerce app built with Flutter and GetX state management. Integrated Stripe payments, full order lifecycle, real-time inventory, push notifications, and a beautiful shopping experience.',
        problem: 'A retail brand needed a fast, branded mobile shopping experience to complement their web store.',
        solution: 'Flutter app with shared API, branded UI matching their web identity, and a payments stack handling Stripe + Apple Pay + Google Pay.',
        features: ['Product catalog', 'Shopping cart', 'Secure payments', 'Order history', 'Push notifications', 'Wishlist'],
        year: '2023',
        role: 'Senior Flutter Developer',
        duration: '5 months',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Firebase', 'GetX', 'REST API', 'Stripe'],
        featured: true,
    },
    {
        slug: 'personal-portfolio-app',
        title: 'Personal Portfolio App',
        subtitle: 'Modern Portfolio Showcase',
        shortDescription:
            'A modern portfolio application with smooth animations, project showcase, and interactive contact form.',
        description:
            "A polished mobile portfolio built with Flutter — showcases projects, skills, and contact form with custom animations and Lottie graphics. Demonstrates Flutter's capability for marketing-quality apps.",
        problem: 'Wanted a flagship sample app demonstrating advanced Flutter UI and animation skills.',
        solution: 'Custom-built portfolio with custom render objects, hero transitions, and Lottie integrations.',
        features: ['Animated UI', 'Project showcase', 'Skills presentation', 'Contact form', 'Lottie animations', 'Smooth transitions'],
        year: '2024',
        role: 'Senior Flutter Developer',
        duration: '2 months',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Animations', 'Custom UI'],
        githubUrl: 'https://github.com/mohamedxahmedd',
    },
];
