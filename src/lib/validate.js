/**
 * Build-time checks for src/data/projects.js.
 *
 * Runs while Astro builds the site (never in the browser). A mistake —
 * missing required field, duplicate slug, image path that doesn't exist —
 * stops the build with a message pointing at the exact project, so a broken
 * page can never be deployed.
 */
import { existsSync } from 'node:fs';
import { join } from 'node:path';

// Astro always runs from the project root (locally and on Vercel).
const PUBLIC_DIR = join(process.cwd(), 'public');
const SLUG_PATTERN = /^[a-z0-9]+(?:-[a-z0-9]+)*$/;
const REQUIRED = ['slug', 'title', 'shortDescription'];

function fail(project, index, message) {
    const name = project?.slug || project?.title || `#${index + 1}`;
    throw new Error(`[projects.js] Project "${name}": ${message}`);
}

function checkLocalImage(project, index, field, path) {
    if (typeof path !== 'string' || !path.startsWith('/')) {
        fail(project, index, `${field} must be a path starting with "/" (e.g. "/projects/${project.slug}/thumbnail.webp"), got: ${JSON.stringify(path)}`);
    }
    // External URLs are not allowed on purpose: every image lives in /public.
    if (!existsSync(join(PUBLIC_DIR, decodeURI(path)))) {
        fail(project, index, `${field} points to "${path}" but public${path} does not exist.`);
    }
}

function checkUrl(project, index, field) {
    const value = project[field];
    if (value == null || value === '') return;
    if (!/^https?:\/\//.test(value)) {
        fail(project, index, `${field} must start with http:// or https://, got: ${JSON.stringify(value)}`);
    }
}

export function validateProjects(projects) {
    if (!Array.isArray(projects)) {
        throw new Error('[projects.js] `projects` must be an array.');
    }

    const seen = new Set();

    projects.forEach((project, index) => {
        for (const field of REQUIRED) {
            if (typeof project[field] !== 'string' || project[field].trim() === '') {
                fail(project, index, `"${field}" is required.`);
            }
        }
        if (!SLUG_PATTERN.test(project.slug)) {
            fail(project, index, 'slug may only contain lowercase letters, numbers and single dashes (e.g. "my-new-project").');
        }
        if (seen.has(project.slug)) {
            fail(project, index, `slug "${project.slug}" is used by more than one project.`);
        }
        seen.add(project.slug);

        if (project.thumbnail) checkLocalImage(project, index, 'thumbnail', project.thumbnail);
        if (project.images != null) {
            if (!Array.isArray(project.images)) fail(project, index, 'images must be an array of paths.');
            project.images.forEach((img, i) => checkLocalImage(project, index, `images[${i}]`, img));
        }
        for (const list of ['technologies', 'features']) {
            if (project[list] != null && !Array.isArray(project[list])) {
                fail(project, index, `${list} must be an array, e.g. ["Flutter", "Dart"].`);
            }
        }
        ['appStoreUrl', 'playStoreUrl', 'githubUrl', 'liveUrl'].forEach((f) => checkUrl(project, index, f));
    });
}
