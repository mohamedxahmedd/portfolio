import { getProjects } from '../lib/portfolio.js';
import { pages } from '../data/pages.js';

/*
 * Sitemaps need absolute URLs, so entries are only listed when the public URL
 * is known (siteConfig.url, or Vercel's production URL — see astro.config.mjs).
 */
export function GET({ site }) {
    const base = site?.href.replace(/\/$/, '');
    const paths = base ? ['/', '/projects', ...getProjects().map((p) => p.url), ...pages.map((p) => `/${p.slug}`)] : [];
    const body = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${paths.map((path) => `  <url><loc>${base}${path}</loc></url>`).join('\n')}
</urlset>
`;
    return new Response(body, { headers: { 'Content-Type': 'application/xml; charset=utf-8' } });
}
