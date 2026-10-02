/**
 * Client-side "filter by technology" for the /projects page (browser script,
 * shared by both themes). Works on a static site: the selected filter lives in
 * the URL (?tech=flutter), so filtered links can be shared and refreshed.
 *
 * Markup contract:
 *   <a data-tech-filter="all" href="/projects">            (and one per tech: data-tech-filter="<slug>")
 *   <… data-project-card data-techs="flutter dart …">      (one per project)
 *   <… data-projects-empty hidden>                          (shown when nothing matches)
 *
 * @param {{ activeClass: string }} options  space-separated classes for the active filter
 */
export function initProjectFilter({ activeClass }) {
    const filters = [...document.querySelectorAll('[data-tech-filter]')];
    if (!filters.length) return;

    const cards = [...document.querySelectorAll('[data-project-card]')];
    const empty = document.querySelector('[data-projects-empty]');
    const classes = activeClass.split(/\s+/).filter(Boolean);
    const known = new Set(filters.map((f) => f.dataset.techFilter));

    const apply = (tech) => {
        const active = known.has(tech) ? tech : 'all';
        filters.forEach((f) => {
            const on = f.dataset.techFilter === active;
            classes.forEach((c) => f.classList.toggle(c, on));
            f.setAttribute('aria-current', on ? 'true' : 'false');
        });
        let visible = 0;
        cards.forEach((card) => {
            const show = active === 'all' || card.dataset.techs.split(' ').includes(active);
            card.hidden = !show;
            if (show) visible++;
        });
        if (empty) empty.hidden = visible > 0;
        // Let scroll-reveal/animation libraries recalculate positions.
        window.dispatchEvent(new Event('resize'));
    };

    filters.forEach((f) =>
        f.addEventListener('click', (event) => {
            event.preventDefault();
            const tech = f.dataset.techFilter;
            const url = new URL(window.location.href);
            if (tech === 'all') url.searchParams.delete('tech');
            else url.searchParams.set('tech', tech);
            history.replaceState(null, '', url);
            apply(tech);
        }),
    );

    apply(new URLSearchParams(window.location.search).get('tech') ?? 'all');
}
