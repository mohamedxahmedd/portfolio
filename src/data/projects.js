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
import { pad2 } from '../lib/format.js';

// Screenshots: public/projects/<slug>/screen-01.webp … screen-NN.webp. Covers: thumbnail.webp (1200×900).
const screens = (slug, count) => Array.from({ length: count }, (_, i) => `/projects/${slug}/screen-${pad2(i + 1)}.webp`);

export const projects = [
    {
        slug: 'banko',
        title: 'Banko',
        subtitle: 'Shipment Tracking & Freight App',
        shortDescription:
            'The customer app of Banko Export & Shipping: follow shipments stop by stop from Cairo to Atbara, sign for deliveries in the app and pay in EGP or SDG.',
        description: `Banko is the customer app of Banko Export & Shipping, a commercial land-freight line between Cairo and Atbara. Traders follow their sent and incoming shipments on one screen, see each order's status and next step, and watch the journey stop by stop — or track any order by its code without signing in.

Every order opens into parcels, items, charges and parties, with the waybill, delivery note and receipts viewable in the app. When a shipment is ready, the customer checks the items one by one and signs with a finger — receiving all of it, part of it, or through a representative.

Payments show what is due per order in each currency; customers pay part or all of it, upload a transfer image or PDF for review, and keep separate statements in Egyptian and Sudanese pounds. The app speaks Sudanese Arabic, Egyptian Arabic or English, supports light and dark mode, and signs in with a phone number and PIN.`,
        features: [
            'Stop-by-stop shipment journey',
            'Track by code without sign-in',
            'Waybills & documents in-app',
            'Finger-signature receiving',
            'Payments with transfer-proof upload',
            'EGP & SDG statements',
            'Real-time notifications',
            '3 languages · light & dark mode',
        ],
        client: 'Banko Export & Shipping',
        role: 'Flutter Developer',
        platform: 'Android',
        technologies: ['Flutter', 'Dart', 'BLoC / Cubit', 'REST API', 'Push Notifications', 'Localization & RTL'],
        thumbnail: '/projects/banko/thumbnail.webp',
        images: screens('banko', 18),
        featured: true,
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.bankoeg.app',
    },
    {
        slug: 'habiby-clinic',
        title: 'Habiby Clinic',
        subtitle: 'Therapy & Healthcare Management App',
        shortDescription:
            'Book therapy sessions, follow a personal treatment plan, manage medications with reminders and keep a feelings diary — with secure payments.',
        description: `Habiby Clinic connects clients with their therapists. Clients choose a clinic or online session, pick a doctor and an available time, and pay by card, cash or WhatsApp transfer; bookings can be rescheduled or cancelled and every appointment keeps its full details.

Between sessions, the app follows the treatment plan: recommended sessions and services, diagnoses, homework assessments, a feelings diary with voice notes, current medicines with alarms and side-effect notes, and an editable medical history — in light and dark mode, with a focus on usability and data security.`,
        features: [
            'Clinic, doctor & time booking',
            'Secure payments',
            'Medication alarms & reminders',
            'Feelings diary with voice notes',
            'Homework assessments',
            'Medical history records',
            'Light & dark mode',
        ],
        role: 'Flutter Developer',
        platform: 'Android',
        technologies: ['Flutter', 'Dart', 'Firebase', 'Stripe', 'Push Notifications'],
        thumbnail: '/projects/habiby-clinic/thumbnail.webp',
        images: screens('habiby-clinic', 16),
        featured: true,
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.hossamxstudios.therapyapp',
    },
    {
        slug: 'stockey-ess',
        title: 'Stockey ESS',
        subtitle: 'Employee Self-Service HR App',
        shortDescription:
            'A production HR app for attendance, payslips, leave and overtime requests, shifts, notifications and biometric login — in Arabic and English.',
        description: `Stockey ESS puts everyday HR tasks in employees' pockets. Staff check in and out with GPS/geofenced attendance confirmed by a quick selfie, follow their working hours live, review a monthly attendance log with check-in/out photos, and submit attendance corrections when something is off.

Shifts and official holidays, leave balances, leave and overtime requests, loan requests with instalment plans, and payslips with a full salary breakdown and PDF download are all a tap away, alongside company announcements and HR notifications. The app supports biometric login, full Arabic/English with RTL, offline synchronisation, and light, dark and deep-dark themes with selectable colour palettes.`,
        features: [
            'GPS / geofenced attendance with selfie',
            'Attendance log & corrections',
            'Shifts & holidays',
            'Leave & overtime requests',
            'Payslips, salary & loan requests',
            'Announcements & notifications',
            'Biometric login & offline sync',
            'Arabic / English (RTL) · light, dark & deep dark',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'GPS & Geofencing', 'Biometrics', 'Offline Sync', 'Localization & RTL'],
        thumbnail: '/projects/stockey-ess/thumbnail.webp',
        images: screens('stockey-ess', 18),
        featured: true,
        appStoreUrl: 'https://apps.apple.com/us/app/stockey-ess/id6763894968',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.hossamxstudios.stockey',
    },
    {
        slug: 'insptrack',
        title: 'InspTrack',
        subtitle: 'Equipment Records & QR Identity App',
        shortDescription:
            'A digital passport for heavy equipment and vehicles: every machine gets a QR identity with its owner, full maintenance and inspection history, and the next service date.',
        description: `InspTrack gives every excavator, crane, forklift, truck or car one permanent digital record. Maintenance and inspection centers register equipment for its owner, and the app issues a unique Equipment ID, a QR code and a printable ID card — so scanning the machine opens its full history instead of a pile of paper invoices and WhatsApp photos.

Each record holds the specs, owner and license details, photos and files, and a timeline of maintenance, inspection, calibration and accident events, each stamped with the company and engineer who added it. Private records sit behind a secret code, a public verification portal lets anyone confirm an equipment card, and reminders flag upcoming services and expiring licenses.

Around the records, companies manage branches, employees, certificates, reports and a credits balance, while the community side adds an equipment marketplace, projects and jobs, a service-centers map, engineer and company profiles, and a feed for posts. The app is Arabic-first with full RTL and an English mode, and supports company and engineer accounts.`,
        features: [
            'QR identity & printable ID card',
            'Maintenance & inspection timeline',
            'Secret-protected records',
            'Public verification portal',
            'Service & license reminders',
            'Branches, employees & certificates',
            'Equipment marketplace & jobs',
            'Service-centers map & community',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'BLoC / Cubit', 'REST API', 'Push Notifications', 'Localization & RTL'],
        thumbnail: '/projects/insptrack/thumbnail.webp',
        images: screens('insptrack', 20),
        featured: true,
    },
    {
        slug: 'yala-box',
        title: 'Yala Box',
        subtitle: 'Courier & Delivery Tracking App',
        shortDescription:
            'A bilingual courier app for assigned shipments: accept orders, move them through each delivery stage, navigate with GPS and collect payments.',
        description: `Yala Box gives delivery drivers everything they need for their assigned shipments. Drivers see new orders, accept or reject them, and move each shipment through its lifecycle — processing, out for delivery, delivered and paid — with a clear progress tracker.

Each order shows customer details with one-tap calling, the delivery route on the map with live GPS tracking, order items and totals. Instant notifications, delivery history and preferences, Arabic/English support and dark mode complete the experience.`,
        features: [
            'Assigned shipments',
            'Accept / reject orders',
            'Step-by-step delivery status',
            'Live GPS tracking & maps',
            'Payment collection',
            'Call the customer in one tap',
            'Arabic / English · dark mode',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Google Maps', 'GPS & Geofencing', 'Push Notifications', 'Localization & RTL'],
        thumbnail: '/projects/yala-box/thumbnail.webp',
        images: screens('yala-box', 7),
        featured: true,
        appStoreUrl: 'https://apps.apple.com/us/app/yala-box/id6757748993',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.hossamxstudios.yala_box',
    },
    {
        slug: 'excraft',
        title: 'ExCraft',
        subtitle: 'Multi-Service Platform',
        shortDescription:
            'An all-in-one platform for exporters: online courses and in-person workshops, an import marketplace, vendor services and consultation booking.',
        description: `ExCraft brings e-commerce, vendor services, consultations and online learning into one Arabic-first mobile platform. Its academy offers video courses, learning tracks and in-person workshops with schedules, map locations and session-by-session curricula.

The import marketplace lets users browse offers, add products to the cart and check out securely, while vendors can submit their own products for export and clients can request consultations. Firebase handles authentication and real-time notifications, and payments run through Stripe.`,
        features: [
            'Course academy & workshops',
            'Workshop maps & schedules',
            'Import marketplace & checkout',
            'Export your products (vendors)',
            'Consultation booking',
            'Secure Stripe payments',
            'Arabic RTL UI',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'Firebase', 'REST API', 'Stripe', 'Push Notifications'],
        thumbnail: '/projects/excraft/thumbnail.webp',
        images: screens('excraft', 18),
        featured: true,
        appStoreUrl: 'https://apps.apple.com/eg/app/excraft/id6746088577',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.hossamXStudios.excraftApp',
    },
    {
        slug: 'kenooz',
        title: 'Kenooz',
        subtitle: 'Golden Deals · Luxury Gold E-Commerce',
        shortDescription:
            'A premium shopping app for gold and diamond jewellery with secure high-value payments, product verification, a coin wallet and transparent pricing.',
        description: `Kenooz (Golden Deals) is a luxury e-commerce app for gold, diamonds and precious stones. Customers browse curated gold and diamond categories, check product details and pricing, and order with secure payment flows built for high-value purchases.

A wallet with coin rewards and investment-portfolio tracking, live chat with support, order tracking with an activity log, blogs, and a theme picker (light/dark with gold, silver, diamond and red palettes) round out a performance-focused premium experience.`,
        features: [
            'Gold & diamond catalogues',
            'Secure high-value checkout',
            'Product verification',
            'Coin wallet & portfolio tracking',
            'Order tracking & activity log',
            'Live support chat',
            'Light/dark themes & palettes',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'BLoC / Cubit', 'REST API', 'Payment Gateways', 'Google Maps'],
        thumbnail: '/projects/kenooz/thumbnail.webp',
        images: screens('kenooz', 15),
        featured: true,
        appStoreUrl: 'https://apps.apple.com/eg/app/kenooz/id6477757090',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.Hossam_x_studios_Kenooz',
    },
    {
        slug: 'kenooz-worker',
        title: 'Kenooz Worker',
        subtitle: 'Workforce & Order Operations App',
        shortDescription:
            'The staff app behind Kenooz: record gold sales with live metal prices, handle customer complaints and manage attendance through a built-in ESS module.',
        description: `Kenooz Worker is the internal app for Kenooz staff. The home screen shows live dollar, gold and silver prices; workers record buy and sell operations, review the sales log and its analytics, and answer customer complaints through in-app conversations.

An integrated employee self-service module covers attendance check-in with biometrics, overtime and attendance corrections, a calendar, leave balances and payslips — all in a fully Arabic, right-to-left interface with selectable themes.`,
        features: [
            'Live gold, silver & dollar prices',
            'Sales log & order analytics',
            'Customer complaint chat',
            'Attendance & calendar (ESS)',
            'Leave balances & payslips',
            'Arabic RTL · themes',
        ],
        role: 'Flutter Developer',
        platform: 'iOS & Android',
        technologies: ['Flutter', 'Dart', 'BLoC / Cubit', 'REST API', 'Biometrics', 'Localization & RTL'],
        thumbnail: '/projects/kenooz-worker/thumbnail.webp',
        images: screens('kenooz-worker', 15),
        appStoreUrl: 'https://apps.apple.com/eg/app/kenooz-worker/id6764659534',
        playStoreUrl: 'https://play.google.com/store/apps/details?id=com.Hossam_x_studios_Kenooz_workers_app',
    },
    {
        slug: 'soul',
        title: 'SO·UL',
        subtitle: 'Candle & Wellness Store App',
        shortDescription:
            'A boutique shopping app for hand-poured candles and self-care goods, with curated collections, smart search and a three-step checkout.',
        description: `SO·UL is an e-commerce app for an artisan candle and wellness brand. Shoppers explore featured products and curated collections, search with recent and trending suggestions, and open rich product pages with sizes, scents and reviews.

Checkout is a guided three-step flow — shipping, payment and review — supporting cards, mobile wallets and cash on delivery, followed by order history and a profile with saved details.`,
        features: [
            'Curated collections',
            'Smart search',
            'Product sizes & scents',
            '3-step checkout',
            'Cards, wallets or cash on delivery',
            'Order history',
        ],
        role: 'Flutter Developer',
        technologies: ['Flutter', 'Dart', 'Payment Gateways', 'Animations', 'Custom UI'],
        thumbnail: '/projects/soul/thumbnail.webp',
        images: screens('soul', 11),
    },
];
