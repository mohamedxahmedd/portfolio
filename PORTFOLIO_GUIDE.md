# Portfolio Guide

Everything you need to run, edit and deploy this portfolio.

The site is **fully static**: no backend, no database, no dashboard, no secrets.
All content lives in a handful of files in `src/data/` and `src/config/`, and images
live in `public/`. Change a file, push to GitHub, and Vercel rebuilds the site
automatically.

```text
src/
  config/site.js          ← ACTIVE THEME, site title/description, contact-form option
  data/profile.js         ← you: name, bio, contact, socials, stats, experience,
                            education, skills, services, process, testimonials
  data/projects.js        ← your projects (add / remove / reorder here)
  data/technologies.js    ← tech stack list (marquee, slider, /projects filter)
  data/pages.js           ← simple pages: privacy policy, terms
  themes/reeni/           ← theme 1 (layout, components, sections, pages, styles, scripts)
  themes/mohamed/         ← theme 2 (same structure)
  pages/                  ← routes — shared by both themes, you never edit these
  lib/                    ← shared logic (project rules, validation, contact form, filter)
  components/shared/      ← shared <head> SEO tags
public/
  profile/                ← your photo, signature (and resume.pdf if you add one)
  projects/<slug>/        ← each project's thumbnail + screenshots
  themes/mohamed/         ← vendor CSS/JS/images used by the Mohamed theme
```

---

## Run it locally

Requires **Node.js 22.12 or newer** (`node -v` to check).

```bash
npm install        # once
npm run dev        # http://localhost:4321 — live reload while you edit
npm run build      # production build into dist/ (same as Vercel runs)
npm run preview    # serve the built dist/ locally
```

---

## How to change the theme

Open **`src/config/site.js`** and change this one line:

```js
theme: 'reeni',
```

to

```js
theme: 'mohamed',
```

| Value       | Look                                                                                         |
| ----------- | -------------------------------------------------------------------------------------------- |
| `'reeni'`   | Dark hot-pink design: 3D tilt cards, custom cursor, letter-by-letter reveals, mouse parallax |
| `'mohamed'` | Orange 3D-showcase: looping video background, sidebar profile card, GSAP scroll effects      |

**Is a rebuild needed?** Yes, the theme is chosen at build time (so only one theme's
code is shipped to visitors). In practice:

- **On Vercel:** just commit and push; the automatic rebuild picks it up.
- **Locally:** stop `npm run dev` (Ctrl + C) and start it again.

A typo in the theme name stops the build with a message listing the valid names.

---

## How to add a new project

### Step 1: add the images

Create a folder named after the project's slug (lowercase, dashes, no spaces):

```text
public/projects/my-new-project/
  thumbnail.webp        ← card / cover image (landscape, ~1200×900 looks best)
  screen-01.webp        ← screenshots for the gallery (any number, phone screenshots are fine)
  screen-02.webp
```

WebP is recommended (small and sharp). If you only have PNG/JPG files, drop them in
the folder and run `npm run optimize-images`: it converts them to `.webp` for you.
File names are up to you; the paths just have to match Step 2.

### Step 2: add the project object

Open **`src/data/projects.js`** and paste this inside the `projects` array, where
you want it to appear:

```js
{
    slug: 'my-new-project',
    title: 'My New Project',
    subtitle: 'Short tagline',
    shortDescription: 'One or two sentences shown on cards and in search results.',
    description: `First paragraph of the full write-up.

Second paragraph — separate paragraphs with a blank line.`,
    problem: 'What problem it solved.',
    solution: 'How you solved it.',
    features: ['Feature one', 'Feature two', 'Feature three'],
    year: '2026',
    client: 'Client name',
    role: 'Senior Flutter Developer',
    duration: '3 months',
    platform: 'iOS & Android',
    technologies: ['Flutter', 'Dart', 'Firebase'],
    thumbnail: '/projects/my-new-project/thumbnail.webp',
    images: [
        '/projects/my-new-project/screen-01.webp',
        '/projects/my-new-project/screen-02.webp',
    ],
    featured: true,
    appStoreUrl: 'https://apps.apple.com/app/...',
    playStoreUrl: 'https://play.google.com/store/apps/details?id=...',
    githubUrl: null,
    liveUrl: null,
},
```

If your screenshots are named `screen-01.webp`, `screen-02.webp`, … you can write
`images: screens('my-new-project', 12),` instead of listing them one by one. `screens` is
defined at the top of `projects.js`, and the number is how many screenshots there are.

Save. That's it: the card, the `/projects` listing, the filter buttons and the page
at **`/projects/my-new-project`** are all generated automatically. No page, route
or component to create.

### Field reference

| Field              | Required | What it does                                                                                                    |
| ------------------ | :------: | --------------------------------------------------------------------------------------------------------------- |
| `slug`             | **yes**  | URL of the project page (`/projects/<slug>`). Lowercase letters, numbers, single dashes. Must be unique.        |
| `title`            | **yes**  | Project name.                                                                                                   |
| `shortDescription` | **yes**  | Short summary on cards, at the top of the project page, and in search/social previews.                          |
| `subtitle`         |    no    | Tagline under the title.                                                                                        |
| `description`      |    no    | Full write-up on the project page. Blank line = new paragraph.                                                  |
| `problem`          |    no    | "The problem" block on the project page.                                                                        |
| `solution`         |    no    | "The solution" block.                                                                                           |
| `features`         |    no    | List shown as "Key features".                                                                                   |
| `year`             |    no    | Shown in the project header / details.                                                                          |
| `client`           |    no    | Shown in "Project details".                                                                                     |
| `role`             |    no    | Shown in "Project details".                                                                                     |
| `duration`         |    no    | Shown in "Project details".                                                                                     |
| `platform`         |    no    | e.g. `'iOS & Android'`; shown in the header.                                                                    |
| `technologies`     |    no    | Tags + `/projects` filter + related projects. Use the same names as in `src/data/technologies.js` to get icons. |
| `thumbnail`        |    no    | Path to the card/cover image. Without it, a branded placeholder is shown.                                       |
| `images`           |    no    | Screenshot gallery (click to enlarge). Leave out or `[]` for no gallery.                                        |
| `featured`         |    no    | `true` → shown on the home page with a "Featured" badge.                                                        |
| `appStoreUrl`      |    no    | Adds the "Download on the App Store" button (and an iOS badge on cards).                                        |
| `playStoreUrl`     |    no    | Adds the "Get it on Google Play" button (and an Android badge).                                                 |
| `githubUrl`        |    no    | Adds a "View source" button.                                                                                    |
| `liveUrl`          |    no    | Adds a "Live demo" button.                                                                                      |
| `draft`            |    no    | `true` → hidden everywhere without deleting it.                                                                 |

Optional fields can be left out entirely, or set to `null` / `[]`.

**Safety net:** the build checks every project. A missing required field, a
duplicate slug, a badly formed link, or an image path that doesn't exist in
`public/` stops the build with a message naming the project, so a broken page
never gets deployed.

---

## How to remove a project

1. Delete its object from `src/data/projects.js`.
2. Delete its folder `public/projects/<slug>/`.

To hide it temporarily instead, add `draft: true` to its object.

---

## How to reorder projects

Projects appear **in the order they are written** in `src/data/projects.js`, both on
the home page and on `/projects`. Cut and paste the objects into the order you want.

---

## How to mark a project as featured

Set `featured: true` on the project. Featured projects:

- appear in the **home page** projects section (in file order, up to
  `homeProjectsLimit` in `src/config/site.js`, default 6);
- get a **"Featured"** badge on their card (Reeni theme).

Set `featured: false` (or remove the line) to keep it only on `/projects`. If no
project is featured, the home page shows the first six projects instead.

---

## How to change your personal information

Everything about you is in **`src/data/profile.js`**:

| What                                           | Field in `profile.js`                                         |
| ---------------------------------------------- | ------------------------------------------------------------- |
| Name, job title, headline, short bio, long bio | `name`, `jobTitle`, `headline`, `shortBio`, `bio`             |
| Location, availability badge                   | `location`, `availability`                                    |
| Rotating hero phrases (Reeni)                  | `heroRoles`                                                   |
| Photo, signature, CV                           | `photo`, `signature`, `resume`                                |
| Email, phone, WhatsApp, working hours          | `contact`                                                     |
| Hero counters                                  | `stats` (Mohamed theme shows the first two)                   |
| Experience, education                          | `experience`, `education` (`end: null` = "Present")           |
| Skill bars                                     | `skills`                                                      |
| Services                                       | `services`                                                    |
| "How I work" steps (Reeni)                     | `process`                                                     |
| Testimonials                                   | `testimonials` (optional `avatar` image; otherwise initials)  |

Site-wide text, i.e. the browser-tab title, tagline and the search-engine description,
is in **`src/config/site.js`** (`title`, `tagline`, `description`).

Section headings like "Selected work" or "Got a project? Let's talk." are part of
each theme's design and live in its section files, e.g.
`src/themes/reeni/sections/Contact.astro`.

### Adding your CV

1. Put the PDF at `public/profile/resume.pdf`.
2. In `profile.js` set `resume: '/profile/resume.pdf'`.

A "Download CV" button then appears in the Reeni hero. (`resume: null` hides it.)

---

## How to change social links

In **`src/data/profile.js`**, edit the `socials` list:

```js
socials: [
    { platform: 'linkedin', label: 'LinkedIn', url: 'https://linkedin.com/in/…', showInHeader: true },
    { platform: 'github',   label: 'GitHub',   url: 'https://github.com/…',      showInHeader: true },
    { platform: 'instagram', label: 'Instagram', url: 'https://instagram.com/…' },
],
```

- `platform` picks the icon. Supported: `linkedin`, `github`, `instagram`, `facebook`,
  `x`, `twitter`, `youtube`, `behance`, `dribbble`, `medium`, `tiktok`, `whatsapp`.
- `showInHeader: true` also shows it in the Reeni top navigation. All links appear in
  the footer / profile card.
- Remove a line to remove the link; reorder lines to reorder icons.

---

## How to change portfolio images

| Image                              | File                                                                                    | Set in                                            |
| ---------------------------------- | --------------------------------------------------------------------------------------- | ------------------------------------------------- |
| Your photo                         | `public/profile/photo.webp`                                                             | `profile.photo`                                   |
| Signature (Mohamed theme)          | `public/profile/signature.webp`                                                         | `profile.signature` (`null` hides it)             |
| CV                                 | `public/profile/resume.pdf`                                                             | `profile.resume`                                  |
| Project thumbnail                  | `public/projects/<slug>/thumbnail.webp`                                                 | project `thumbnail`                               |
| Project screenshots                | `public/projects/<slug>/…`                                                              | project `images`                                  |
| Testimonial avatar                 | e.g. `public/testimonials/name.webp`                                                    | testimonial `avatar`                              |
| Browser icon (Reeni)               | `public/favicon.svg`                                                                    | replace the file                                  |
| Mohamed theme background video     | `public/themes/mohamed/images/bg-3d/video3.mp4` (+ `poster.webp`, its first frame)      | replace the files, keep the names                 |
| Mohamed theme logo / favicon       | `public/themes/mohamed/images/logo/`                                                    | replace the files, keep the names                 |
| Fallback art for projects without a thumbnail (Mohamed) | `public/themes/mohamed/images/section/works-1..3.webp`         | replace the files, keep the names                 |

To swap an image, replace the file with one of the same name, or add a new file and
update its path in the data file. Paths always start with `/` and are relative to
`public/` (`/profile/photo.webp` = `public/profile/photo.webp`).

---

## Contact form

The form needs **no backend**. By default, pressing "Send" opens the visitor's email
app with the message already written and addressed to `profile.contact.email`.
Email, WhatsApp and phone links are shown next to it as well.

**Optional:** if you'd rather receive messages without the visitor's email app
opening, create a free form endpoint (e.g. [Formspree](https://formspree.io): sign up,
create a form, copy its URL) and paste it in `src/config/site.js`:

```js
contactForm: {
    endpoint: 'https://formspree.io/f/abcdwxyz',
},
```

If that service is ever unavailable, the form automatically falls back to the
email-app method. Set it back to `null` to stop using it.

---

## How to deploy to Vercel (free)

### First time

1. **Check it builds locally:**
   ```bash
   npm install
   npm run build
   ```
2. **Push the code to GitHub** (the `static-portfolio` branch of
   `mohamedxahmedd/portfolio`, or a new repository).
3. Open **[vercel.com](https://vercel.com)** → sign in with GitHub → **Add New… → Project**.
4. **Import** the repository.
5. **Framework Preset:** `Astro` (detected automatically).
6. **Build Command:** `npm run build` (already set by `vercel.json`, nothing to change).
7. **Output Directory:** `dist` (already set by `vercel.json`).
8. **Environment variables:** none needed.
9. If you deploy from the `static-portfolio` branch rather than `main`: after
   the first deploy go to **Settings → Git → Production Branch** and set it to
   `static-portfolio` (or merge the branch into `main`).
10. Click **Deploy**. You get a URL like `https://your-project.vercel.app`.

### After that

Every `git push` to the production branch redeploys automatically (~1 minute).
Pushes to other branches get their own preview URLs.

### Custom domain (optional)

Vercel → your project → **Settings → Domains** → add your domain and follow the DNS
instructions. Then set `url: 'https://your-domain.com'` in `src/config/site.js` so the
sitemap and social-share links use it. (Without it, the Vercel production URL is used
automatically.)

### `vercel.json`

The repository includes a small `vercel.json`:

- `framework` / `buildCommand` / `outputDirectory`: tell Vercel how to build
  (Astro → `dist/`), so the import needs no manual settings.
- `cleanUrls` / `trailingSlash`: pages are served at `/projects/excraft` (no
  `.html`, no trailing slash), and refreshing any page works.
- `headers`: long browser caching for fingerprinted build assets (`/_astro/*`) and
  a week of caching for images/video.

Vercel serves `dist/404.html` automatically for unknown URLs.

---

## Good to know

- **Node version:** Vercel uses Node 22+ by default, which satisfies `engines` in
  `package.json`.
- **Generated extras:** `/sitemap.xml` and `/robots.txt` are built automatically from
  your projects and pages.
- **Adding a third theme:** copy `src/themes/reeni/` to `src/themes/<new-name>/`,
  restyle it, and set `theme: '<new-name>'`. A theme must provide
  `pages/Home.astro`, `pages/Projects.astro`, `pages/Project.astro`,
  `pages/SimplePage.astro` and `pages/NotFound.astro`. The build checks this.
- **Themes read data through `src/lib/portfolio.js`**, so rules such as ordering,
  featured, draft and related projects behave the same in every theme.
