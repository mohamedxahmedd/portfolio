/*
 * Mohamed theme preloader. BaseLayout inlines this into <head>, so it runs before
 * the first paint. Markup: components/Preloader.astro, look: styles/preloader.css.
 *
 * - First page of a visit (per tab): the full intro (counter, name), then the curtains lift.
 * - Later pages: a short curtain that lifts as soon as the page is ready.
 * - "Ready" = DOM parsed + theme fonts + above-the-fold images (fetchpriority="high"),
 *   or the window load event, whichever is first, and never later than MAX.
 * - While the curtain is down, <html> has `is-preloading`: scrolling is locked and the
 *   template's entrance animations wait. When it lifts, "preloader:release" is
 *   dispatched on window (theme.js resumes GSAP and starts the counters on it).
 */
(() => {
    const root = document.documentElement;
    const SEEN_KEY = 'mohamed:intro-seen';
    let seen = false;
    try {
        seen = sessionStorage.getItem(SEEN_KEY) === '1';
    } catch {
        // Storage blocked: every page gets the full intro.
    }
    const reduceMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;
    const quick = seen || reduceMotion;

    root.classList.add('js', 'is-preloading');
    if (quick) root.classList.add('preloader-quick');

    const MIN = quick ? 0 : 1400; // the first-visit counter runs at least this long (ms)
    const MAX = quick ? 4000 : 7000; // never hold a page longer than this
    const LIFT = quick ? 700 : 1000; // curtain transition, matches preloader.css
    const start = performance.now();

    let el, count, ring, line;
    let real = 0; // progress from real milestones, 0–100
    let shown = 0; // what the counter shows, eased towards the goal
    let ready = false;
    let state = 'loading'; // → 'leaving' → 'gone'
    let last = start;

    const addProgress = (points) => (real = Math.min(100, real + points));
    const once = (target, type) => new Promise((resolve) => target.addEventListener(type, resolve, { once: true }));
    const domReady = document.readyState === 'loading' ? once(document, 'DOMContentLoaded') : Promise.resolve();

    const release = () => {
        if (!root.classList.contains('is-preloading')) return;
        root.classList.remove('is-preloading');
        window.dispatchEvent(new Event('preloader:release'));
    };

    const finish = () => {
        state = 'gone';
        el?.remove();
        root.classList.remove('preloader-quick');
        release();
    };

    const leave = () => {
        state = 'leaving';
        try {
            sessionStorage.setItem(SEEN_KEY, '1');
        } catch {
            // Not fatal: the next page just plays the full intro again.
        }
        el.classList.add('is-done');
        setTimeout(() => {
            el.classList.add('is-leaving');
            // Let the page's own entrance animations start while the curtain is lifting.
            setTimeout(release, reduceMotion ? 0 : LIFT * 0.3);
            setTimeout(finish, (reduceMotion ? 300 : LIFT + 120) + 120);
        }, quick ? 40 : 160);
    };

    const tick = (now) => {
        if (state !== 'loading') return;
        if (!el && (el = document.getElementById('preloader'))) {
            count = el.querySelector('[data-preloader-count]');
            ring = el.querySelector('[data-preloader-ring]');
            line = el.querySelector('[data-preloader-line]');
        }
        const elapsed = now - start;
        const dt = Math.min(64, now - last);
        last = now;

        // Creep forward while waiting so the counter never looks stuck.
        const creep = 80 * (1 - Math.exp(-elapsed / 1800));
        let goal = ready ? 100 : Math.min(96, Math.max(creep, real));
        if (MIN) goal = Math.min(goal, (elapsed / MIN) * 100);
        shown = quick && ready ? 100 : shown + (goal - shown) * Math.min(1, dt / 110);
        if (goal === 100 && shown > 99.5) shown = 100;

        if (el) {
            count.textContent = String(Math.round(shown));
            ring.style.strokeDashoffset = String(100 - shown);
            line.style.transform = `scaleX(${shown / 100})`;
        }
        if (el && shown === 100) leave();
        else requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);

    // Real milestones feed the counter; any of the "ready" paths ends the wait.
    domReady.then(() => {
        addProgress(45);
        if (!document.getElementById('preloader')) finish();
    });
    const fonts = domReady
        .then(() => document.fonts && Promise.all(['300 1em Rajdhani', '400 1em Rajdhani', '500 1em Rajdhani'].map((font) => document.fonts.load(font))))
        .catch(() => {})
        .then(() => addProgress(20));
    const heroImages = domReady.then(() => {
        const images = [...document.querySelectorAll('img[fetchpriority="high"]')];
        if (!images.length) return addProgress(25);
        return Promise.all(
            images.map((img) =>
                (img.complete ? Promise.resolve() : Promise.race([once(img, 'load'), once(img, 'error')])).then(() =>
                    addProgress(25 / images.length),
                ),
            ),
        );
    });
    Promise.all([fonts, heroImages]).then(() => (ready = true));
    (document.readyState === 'complete' ? Promise.resolve() : once(window, 'load')).then(() => (ready = true));
    setTimeout(() => (ready = true), MAX);

    // Restored from the back/forward cache mid-intro: just show the page.
    window.addEventListener('pageshow', (event) => {
        if (event.persisted && state !== 'gone') finish();
    });
})();
