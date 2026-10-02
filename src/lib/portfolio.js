/**
 * Theme-agnostic read layer over src/data/*.
 *
 * Themes never import the raw data files for projects/technologies — they
 * call these helpers, so ordering, featured/draft rules, technology lookup
 * and related-project logic behave identically in every theme.
 */
import { projects as rawProjects } from '../data/projects.js';
import { technologies as rawTechnologies } from '../data/technologies.js';
import { siteConfig } from '../config/site.js';
import { validateProjects } from './validate.js';

validateProjects(rawProjects);

export const slugify = (value) =>
    String(value)
        .toLowerCase()
        .normalize('NFKD')
        .replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

const techByKey = new Map(rawTechnologies.map((t) => [t.name.toLowerCase(), t]));

const DEFAULT_TECH_ICON = 'fas fa-code';

/** Resolves a technology name to { name, slug, icon, color }. Unknown names still work. */
export function resolveTechnology(name) {
    const known = techByKey.get(String(name).toLowerCase());
    return {
        name: known?.name ?? name,
        slug: slugify(known?.name ?? name),
        icon: known?.icon ?? DEFAULT_TECH_ICON,
        color: known?.color ?? null,
    };
}

function normalize(project) {
    return {
        subtitle: null,
        description: null,
        problem: null,
        solution: null,
        year: null,
        client: null,
        role: null,
        duration: null,
        platform: null,
        thumbnail: null,
        appStoreUrl: null,
        playStoreUrl: null,
        githubUrl: null,
        liveUrl: null,
        ...project,
        features: project.features ?? [],
        images: project.images ?? [],
        featured: Boolean(project.featured),
        technologies: (project.technologies ?? []).map(resolveTechnology),
        url: `/projects/${project.slug}`,
    };
}

const published = rawProjects.filter((p) => !p.draft).map(normalize);

/** All visible projects, in the order written in projects.js. */
export function getProjects() {
    return published;
}

export function getProjectBySlug(slug) {
    return published.find((p) => p.slug === slug) ?? null;
}

/** Featured projects for the home page; falls back to the first N if none are featured. */
export function getHomeProjects() {
    const limit = siteConfig.homeProjectsLimit;
    const featured = published.filter((p) => p.featured);
    return (featured.length ? featured : published).slice(0, limit);
}

/** Up to `limit` other projects sharing at least one technology. */
export function getRelatedProjects(project, limit = 3) {
    // Technologies every project uses (e.g. Flutter, Dart) say nothing about relatedness.
    const universal = new Set(
        [...new Set(published.flatMap((p) => p.technologies.map((t) => t.slug)))].filter((slug) =>
            published.every((p) => p.technologies.some((t) => t.slug === slug)),
        ),
    );
    const slugs = new Set(project.technologies.map((t) => t.slug).filter((slug) => !universal.has(slug)));
    return published
        .filter((p) => p.slug !== project.slug)
        .map((p) => ({ p, shared: p.technologies.filter((t) => slugs.has(t.slug)).length }))
        .filter(({ shared }) => shared > 0)
        .sort((a, b) => b.shared - a.shared) // stable: ties keep projects.js order
        .slice(0, limit)
        .map(({ p }) => p);
}

/** The full tech stack from technologies.js, each with its project count. */
export function getTechStack() {
    return rawTechnologies.map((t) => {
        const tech = resolveTechnology(t.name);
        return { ...tech, projectCount: published.filter((p) => p.technologies.some((pt) => pt.slug === tech.slug)).length };
    });
}

/** Technologies actually used by at least one project — for the /projects filter. */
export function getFilterTechnologies() {
    return getTechStack()
        .filter((t) => t.projectCount > 0)
        .concat(
            // Technologies used by projects but not listed in technologies.js
            [...new Map(published.flatMap((p) => p.technologies).map((t) => [t.slug, t])).values()]
                .filter((t) => !techByKey.has(t.name.toLowerCase())),
        );
}
