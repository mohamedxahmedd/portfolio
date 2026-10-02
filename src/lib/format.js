/** Small presentation helpers shared by both themes. */

/** "2020 — 2021", "2022 — Present". */
export const yearRange = (start, end) => `${start} — ${end ?? 'Present'}`;

/** Splits text on blank lines into paragraphs. */
export const paragraphs = (text) =>
    String(text ?? '')
        .split(/\n\s*\n/)
        .map((p) => p.trim())
        .filter(Boolean);

/** Shortens plain text at a word boundary, adding "...". */
export function truncate(text, max) {
    const plain = String(text ?? '').replace(/\s+/g, ' ').trim();
    if (plain.length <= max) return plain;
    const cut = plain.lastIndexOf(' ', max);
    return plain.slice(0, cut > 0 ? cut : max).replace(/[.,;:]$/, '') + '...';
}

/** "Andrew Bolar" → "AB". */
export const initials = (name) =>
    String(name)
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((w) => w[0].toUpperCase())
        .join('');

export const pad2 = (n) => String(n).padStart(2, '0');

export const mailtoHref = (email) => `mailto:${email}`;
export const telHref = (phone) => `tel:${String(phone).replace(/[^\d+]/g, '')}`;
export const whatsappHref = (number) => `https://wa.me/${String(number).replace(/\D/g, '')}`;
