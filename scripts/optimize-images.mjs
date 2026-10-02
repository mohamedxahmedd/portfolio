/**
 * Optional helper: converts every .png / .jpg / .jpeg in public/projects/ and
 * public/profile/ to a compressed .webp next to it (max 1600px wide) and
 * deletes the original.
 *
 *   npm run optimize-images
 *
 * Afterwards, use the .webp paths in src/data/projects.js. Nothing in the
 * build depends on this script — it just keeps the site fast.
 */
import { existsSync } from 'node:fs';
import { readdir, unlink } from 'node:fs/promises';
import { join, extname } from 'node:path';
import sharp from 'sharp';

const ROOTS = ['public/projects', 'public/profile'];
const SOURCE = new Set(['.png', '.jpg', '.jpeg']);

async function* walk(dir) {
    for (const entry of await readdir(dir, { withFileTypes: true }).catch(() => [])) {
        const path = join(dir, entry.name);
        if (entry.isDirectory()) yield* walk(path);
        else if (SOURCE.has(extname(entry.name).toLowerCase())) yield path;
    }
}

let count = 0;
for (const root of ROOTS) {
    for await (const file of walk(root)) {
        const out = file.slice(0, -extname(file).length) + '.webp';
        if (existsSync(out)) {
            console.warn(`• skipped ${file}: ${out} already exists (rename one of them)`);
            continue;
        }
        await sharp(file).resize({ width: 1600, withoutEnlargement: true }).webp({ quality: 80 }).toFile(out);
        await unlink(file);
        console.log(`✓ ${file} → ${out}`);
        count++;
    }
}
console.log(count ? `Converted ${count} image(s). Update the paths in src/data/projects.js to .webp.` : 'No .png/.jpg images found — nothing to do.');
