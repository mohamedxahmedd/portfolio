# Reeni CMS

Self-hosted Laravel 13 portfolio CMS for **Mohamed Ahmed**, Senior Flutter Developer (Cairo, Egypt). Replaces the WordPress site at `reeni-wp.laralink.com` with a fully-owned stack: Filament 4 admin panel + Blade public frontend with TailwindCSS 4, Livewire 4, and Alpine.js.

**Project goal:** edit every section of your portfolio (about, experience, education, skills, services, projects with App Store/Play Store links, testimonials, contact) from a beautiful admin dashboard — no WordPress, no redeploys for content changes, fully version-controlled.

---

## 🎯 What's included

- **Public site** rebuilt in Blade matching the Reeni design (hot-pink `#ff014f` on dark `#1a1a1a`, Rubik body / Rajdhani display fonts)
  - Single-page home with hero, about, experience, education, skills (with animated proficiency bars), services, projects, testimonials carousel, contact form
  - `/projects` listing page with tech-stack filter
  - `/projects/{slug}` detail page with **App Store + Play Store buttons**, screenshots gallery (lightbox), tech-stack pills, related projects
  - CMS pages (`/privacy-policy`, `/terms`)
  - `/sitemap.xml`, `/robots.txt`, `/health` JSON endpoint, Schema.org JSON-LD `Person` markup
- **Admin panel** at `/admin` (Filament 4)
  - 12 resources organized into navigation groups: **Portfolio** / **About Me** / **Social Proof** / **Communication** / **Content**
  - **Project resource** — tabbed form with sections for: Overview · Description (rich editor) · **Links (App Store + Play Store + GitHub + Demo)** · Media (cover + screenshots gallery + app icon) · Categorization (technologies + tags) · Display & SEO
  - Reorderable screenshots collection via Spatie Media Library
  - Dashboard widgets: portfolio stats + recent contact submissions
  - Filament Shield RBAC (super_admin / admin / editor roles)
  - Activity log on every model (Spatie)
- **Contact form** (Livewire 4) with rate limiting, honeypot, validation, email notification + DB storage
- **SEO:** sitemap.xml, JSON-LD, OG tags, per-meta override
- **Production-ready:** Oracle Cloud Always Free deployment scripts, Cloudflare Tunnel config, nginx + PHP-FPM tuning for ARM 24 GB box, Horizon queue worker, automated R2/B2 backups via spatie/laravel-backup

---

## 🚀 Quick start (local development)

### Prerequisites
- PHP 8.4 (via Homebrew: `brew install php@8.4`)
- Composer 2
- Node 20+
- SQLite (built into PHP) — no MySQL needed locally

### One-time setup
```bash
git clone <repo-url> reeni-cms
cd reeni-cms

# Add PHP 8.4 to PATH (one-time)
echo 'export PATH="$(brew --prefix php@8.4)/bin:$HOME/.composer/vendor/bin:$PATH"' >> ~/.zshrc
source ~/.zshrc

composer install
npm install
cp .env.example .env  # already exists for this repo with sqlite defaults
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build
```

### Boot the dev server
```bash
php artisan serve --port=8000
# In another terminal, for hot-reload assets:
npm run dev
```

Now visit:
- **Public site:** http://localhost:8000
- **Admin panel:** http://localhost:8000/admin (login: `admin@reeni.local` / `password`)

---

## 🗺️ Project structure

```
reeni-cms/
├── app/
│   ├── Filament/
│   │   ├── Resources/             ← 12 admin resources (Projects, Skills, Services, …)
│   │   └── Widgets/               ← Dashboard widgets
│   ├── Http/Controllers/          ← HomeController, ProjectController, PageController, SitemapController
│   ├── Livewire/                  ← ContactForm component
│   ├── Models/                    ← 17 Eloquent models with Spatie traits
│   ├── Notifications/             ← NewContactSubmissionNotification (email)
│   └── Providers/Filament/        ← AdminPanelProvider with brand + nav groups
├── database/
│   ├── migrations/                ← 18 migrations
│   └── seeders/                   ← 13 seeders (full Reeni demo content)
├── deploy/                        ← Production deployment scripts (Oracle Cloud)
│   ├── provision.sh               ← One-shot VM setup
│   ├── nginx.conf                 ← Nginx server block
│   ├── horizon.service            ← systemd unit for queue worker
│   └── deploy.sh                  ← Idempotent deploy script
├── resources/
│   ├── css/app.css                ← Tailwind 4 with brand tokens
│   ├── js/app.js                  ← Alpine + Swiper + counters
│   └── views/
│       ├── layouts/app.blade.php
│       ├── partials/              ← header, footer, project-card
│       ├── pages/                 ← home, project-show, projects-index, page
│       └── livewire/              ← contact-form
└── routes/web.php
```

---

## 📦 What's seeded

Run `php artisan migrate:fresh --seed` to reset the DB and load:

- **Admin user:** `admin@reeni.local` / `password` (super_admin role)
- **Site settings** with brand colors `#ff014f` + Rubik/Rajdhani fonts
- **About section:** Mohamed Ahmed, 4 yrs experience, Cairo
- **Social links:** LinkedIn, GitHub, Instagram, Facebook (URLs from current WordPress site)
- **Contact info:** Cairo, Egypt + `hossamfarid71@gmail.com`
- **2 skill categories:** UI/UX Design + Development Skill (8 skills total: Figma 90%, Adobe XD 85%, Material Design 95%, Prototyping 80%, Flutter 95%, Dart 90%, Firebase 85%, REST APIs 88%)
- **3 services:** Flutter Development, State Management, API Integration
- **4 experiences** (2018 → present) and **4 educations**
- **13 technologies** (Flutter, Dart, Firebase, BLoC, Riverpod, GetX, REST API, Stripe, etc.)
- **4 projects** matching the current Reeni site (SAAS Website, Workout App, E-Commerce, Personal Portfolio) — each with technology relationships
- **3 testimonials** (replace with real client testimonials in admin)
- **2 pages:** Privacy Policy, Terms

---

## ✅ Things YOU must do manually (one-time)

These are non-automatable. The Laravel side is done; these complete production deployment.

### Account signups (before deploying)
- [ ] **Oracle Cloud Free Tier** at https://cloud.oracle.com/free
  - Use a real Visa/Mastercard (Egyptian-issued OK; not virtual/prepaid). $1 verification hold, refunded
  - Choose home region: **Frankfurt (eu-frankfurt-1)** — best Cairo latency
  - Wait 1-3 business days for approval
- [ ] **Provision Always-Free A1 VM** (after approval)
  - Shape: `VM.Standard.A1.Flex`, **4 OCPU + 24 GB RAM**
  - Image: Ubuntu 22.04 ARM
  - SSH key: `ssh-keygen -t ed25519`, paste the public key
- [ ] **Cloudflare** account at https://cloudflare.com (free)
- [ ] **DigitalPlat FreeDomain** at https://domain.digitalplat.org — claim a `.dpdns.org` subdomain (e.g. `mohamedahmed.dpdns.org` or `reeni.dpdns.org`)
- [ ] **Brevo** at https://brevo.com — free SMTP 300 emails/day
- [ ] **GitHub** private repo for the project
- [ ] **UptimeRobot** at https://uptimerobot.com — free 50 monitors; pings `/health` every 5 min (prevents Oracle's 7-day idle reclaim)
- [ ] **Cloudflare R2** OR **Backblaze B2** — 10 GB free off-site backup

### Server provisioning (after SSHing into VM)
```bash
git clone https://github.com/YOUR-USER/reeni-cms.git
cd reeni-cms
./deploy/provision.sh
# Then follow the printed "NEXT STEPS"
```

The provisioning script tells you exactly what to run next (MySQL setup, Cloudflare Tunnel install, nginx site activation, Horizon systemd service, cron for scheduler).

### Content you must provide (via admin panel)
The seeded content has placeholders. Update via `/admin`:
- [ ] **Real bio text** (2-4 paragraphs in About Section)
- [ ] **Real contact info** (phone, WhatsApp, address)
- [ ] **Confirm social URLs** (current LinkedIn/GitHub/Instagram/Facebook — confirm still right)
- [ ] **Real project data** — for each Flutter app: title, description, problem/solution, features, tech stack, screenshots (5-10 images), **App Store URL**, **Play Store URL**, GitHub URL (if public), demo video URL
- [ ] **Real testimonials** (replace 3 placeholder testimonials with real client feedback + photos)
- [ ] **Professional headshot** (transparent PNG ideal — upload via About Section → profile_photo media collection)
- [ ] **Company logos** for the experience section
- [ ] **CV/Resume PDF** (for download button — paste URL into About Section)

### Post-launch
- [ ] Submit `sitemap.xml` to **Google Search Console** + **Bing Webmaster Tools**
- [ ] (Optional) Install self-hosted **Umami** analytics on the same VM, OR use Plausible's free tier

---

## 🔑 Default admin credentials

After `php artisan migrate:fresh --seed`:

| Email | Password | Role |
|---|---|---|
| `admin@reeni.local` | `password` | super_admin |

**Change this immediately in production.** Go to `/admin` → profile → update.

---

## 🛠️ Common tasks

```bash
# Reset DB to clean seeded state
php artisan migrate:fresh --seed

# Create another admin user
php artisan tinker
> $u = App\Models\User::create(['name'=>'X', 'email'=>'x@y.com', 'password'=>bcrypt('secret')]);
> $u->assignRole('super_admin');

# Generate Filament Shield permissions for all resources
php artisan shield:generate --all

# Clear all caches
php artisan optimize:clear

# Compile production assets
npm run build

# Run tests
php artisan test
```

---

## 🌐 Public URLs (once deployed)

| URL | Purpose |
|---|---|
| `/` | Home page (all sections) |
| `/projects` | Projects listing (with filter) |
| `/projects/{slug}` | Project detail (with App/Play Store buttons + gallery) |
| `/privacy-policy`, `/terms` | CMS pages |
| `/sitemap.xml` | SEO sitemap |
| `/robots.txt` | Crawler directives |
| `/health` | JSON health check (used by UptimeRobot) |
| `/admin` | Filament admin panel |
| `/admin/horizon` | Queue monitor (super_admin only) |

---

## 🧪 End-to-end verification

When you finish manual setup, smoke-test these in order:

1. **Log into `/admin`** as the seeded admin
2. **Create a new Project** with cover image + 5 screenshots + App Store URL + Play Store URL → publish → visit `/projects/{new-slug}` → confirm App Store + Play Store store-style buttons render and link out
3. **Submit the contact form** on the public site → confirm email arrives → confirm submission appears in `/admin/contact-submissions` → mark as read
4. **`/sitemap.xml`** → valid XML containing all published projects
5. **Reorder projects** via display_order in admin → confirm public site reflects new order
6. **`curl /health`** → returns `{"ok":true,"time":"..."}`

---

## 🎨 Customizing the theme

In `/admin` → **Settings** (or directly in `database/seeders/SettingsSeeder.php`):
- `theme_primary_color` — currently `#ff014f` (Reeni signature hot pink)
- `theme_dark_bg` — currently `#1a1a1a`
- `theme_font_body` — currently Rubik
- `theme_font_display` — currently Rajdhani

CSS tokens live in `resources/css/app.css` under `@theme { --color-brand-* }`. After changing them, run `npm run build`.

---

## 🔒 Security notes

- Cloudflare Tunnel means **no open ports** on the VM (zero attack surface for HTTP)
- UFW firewall blocks everything except SSH
- fail2ban monitors SSH brute-force attempts
- Filament admin requires the `super_admin` or `admin` or `editor` role
- Contact form has honeypot + 3-attempts-per-10-minutes rate limit per IP
- All Cloudflare-forwarded IPs are trusted via `CF-Connecting-IP` header
- HTTPS terminated at Cloudflare edge (free SSL)

---

## 📚 Stack reference

- [Laravel 13 docs](https://laravel.com/docs/13.x)
- [Filament 4 docs](https://filamentphp.com/docs/4.x)
- [Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)
- [Spatie Permission](https://spatie.be/docs/laravel-permission)
- [Spatie Activity Log](https://spatie.be/docs/laravel-activitylog)
- [Spatie Backup](https://spatie.be/docs/laravel-backup)
- [Livewire 4](https://livewire.laravel.com)
- [Alpine.js](https://alpinejs.dev)

---

## 📝 License

Private — for portfolio use by Mohamed Ahmed.

Built with ❤️ on Laravel + Filament.
# portfolio
