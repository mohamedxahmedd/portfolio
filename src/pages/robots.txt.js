export function GET({ site }) {
    const sitemap = site ? `\nSitemap: ${new URL('sitemap.xml', site).href}\n` : '';
    return new Response(`User-agent: *\nAllow: /\n${sitemap}`, {
        headers: { 'Content-Type': 'text/plain; charset=utf-8' },
    });
}
