/*
 * Mohamed theme glue (bundled by Astro). The template's own behaviour comes
 * from the vendor scripts in public/themes/mohamed/js, loaded by BaseLayout.
 */
import { initContactForms } from '../../../lib/contact-form.js';
import { initProjectFilter } from '../../../lib/project-filter.js';

initContactForms();
initProjectFilter({ activeClass: 'is-active' });

// The template only starts its odometer counters on a scroll event, so counters
// already on screen at load (the hero) stayed at 0. Nudge it once on load.
window.addEventListener('load', () => window.dispatchEvent(new Event('scroll')));
