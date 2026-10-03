/*
 * Mohamed theme glue (bundled by Astro). The template's own behaviour comes
 * from the vendor scripts in public/themes/mohamed/js, loaded by BaseLayout.
 */
import { initContactForms } from '../../../lib/contact-form.js';
import { initProjectFilter } from '../../../lib/project-filter.js';

const root = document.documentElement;

// While the preloader covers the page (scripts/preloader.js), hold the template's
// GSAP entrance animations so they play as the curtain lifts instead of behind it.
if (root.classList.contains('is-preloading') && window.gsap) {
    window.gsap.globalTimeline.pause();
    window.addEventListener('preloader:release', () => window.gsap.globalTimeline.resume(), { once: true });
}

initContactForms();
initProjectFilter({ activeClass: 'is-active' });
initMediaFrames();

// The template only starts its odometer counters on a scroll event, so counters
// already on screen (the hero) stayed at 0. Nudge it once the page is visible.
const nudgeCounters = () => window.dispatchEvent(new Event('scroll'));
window.addEventListener('preloader:release', nudgeCounters);
window.addEventListener('load', () => root.classList.contains('is-preloading') || nudgeCounters());

/** Covers and screenshots fade in over a shimmer placeholder once loaded (overrides.css). */
function initMediaFrames() {
    document.querySelectorAll('.media-frame').forEach((frame) => {
        const img = frame.querySelector('img');
        const show = () => frame.classList.add('is-loaded');
        if (!img || img.complete) return show();
        img.addEventListener('load', show, { once: true });
        img.addEventListener('error', show, { once: true });
    });
}
