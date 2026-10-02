// @ts-check
import { defineConfig } from 'astro/config';
import tailwindcss from '@tailwindcss/vite';
import { existsSync, readdirSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import { siteConfig } from './src/config/site.js';

/*
 * Theme switching: `@theme` is an import alias that points at the folder of
 * the theme chosen in src/config/site.js. Routes in src/pages import
 * `@theme/pages/...`, so only the active theme's code and CSS end up in the
 * build — the two themes can never leak styles into each other.
 */
const themesDir = fileURLToPath(new URL('./src/themes/', import.meta.url));
const availableThemes = readdirSync(themesDir, { withFileTypes: true })
    .filter((d) => d.isDirectory())
    .map((d) => d.name);

if (!availableThemes.includes(siteConfig.theme)) {
    throw new Error(
        `[site.js] Unknown theme "${siteConfig.theme}". Available themes: ${availableThemes.map((t) => `"${t}"`).join(', ')}.`,
    );
}

const themeDir = themesDir + siteConfig.theme;
for (const page of ['Home', 'Projects', 'Project', 'SimplePage', 'NotFound']) {
    if (!existsSync(`${themeDir}/pages/${page}.astro`)) {
        throw new Error(`[themes] Theme "${siteConfig.theme}" is missing pages/${page}.astro.`);
    }
}

// Public URL: explicit config → Vercel's production URL (set automatically on Vercel) → none.
const vercelUrl = process.env.VERCEL_PROJECT_PRODUCTION_URL;
const site = siteConfig.url || (vercelUrl ? `https://${vercelUrl}` : undefined);

export default defineConfig({
    site,
    output: 'static',
    trailingSlash: 'ignore',
    build: {
        format: 'directory',
    },
    vite: {
        plugins: [tailwindcss()],
        resolve: {
            alias: {
                '@theme': themeDir,
            },
        },
    },
});
