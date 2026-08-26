# MA MA'ARIF NU ASSA'ADAH — Rebuild Planning & Architecture

Project: Rebuild official school website (Official School Website + Information Portal + CMS).
Goal: Modern Islamic School Information Portal — fast, secure, SEO-friendly, easy to manage.

Old site: `https://mamnu-assaadah.sch.id/` — used ONLY as content reference, NOT design/security reference.

---

## 1. Existing Website Analysis

- **Platform**: Indonesian school CMS script ("Powered by sekolahku.web.id"), likely a PHP app (CodeIgniter-style URL routing). Heavy client-side JS rendering ("You need to enable JavaScript to run this app").
- **Server-side URLs**: `/read/{id}/{slug}`, `/kategori/{slug}`, `/galeri-foto`, `/galeri-video`, `/direktori-alumni`, `/direktori-guru-dan-tenaga-kependidikan`, `/direktori-peserta-didik`, `/pendaftaran-alumni`, `/hubungi-kami`, `/sambutan-kepala-sekolah`, `/download/{slug}`, `/hasil-seleksi-...`, `/download-formulir-...`, `/feed`.
- **Identity**: name/tagline/email/phone match the brief. Headmaster: Mohammad Isma'il Cholilur Rohman, M.Pd.
- **Content present**: posts/berita (few, with slug+id), albums (Foto Terbaru), videos, tags, downloads (BOS reports, perangkat pembelajaran), alumni directory, GTK directory, participant directory, sambutan, quotes/kutipan.
- **Content quality**: sparse; a few legacy posts (2019–2025). One "direktori peserta didik" exists → privacy risk, remove.
- **Red flags**: mixed/duplicate menu links (LAPORAN DANA BOS appears twice, broken absolute-path links), category "uncategorized", a "SPMB 2026/2027" with external lynk.id forms (out of scope — brief says NO SPMB/PPDB).

## 2. Existing Feature Inventory

- Berita/posts + tags + categories (uncategorized only)
- Galeri foto (albums) + galeri video
- Direktori: alumni, guru & tendik, peserta didik (REMOVE peserta didik — privacy)
- Pendaftaran alumni
- Download center (BOS, perangkat pembelajaran)
- Sambutan kepala sekolah
- Contact (hubungi kami) + RSS feed + search
- Social links (Facebook, Instagram)

## 3. Problems & Technical Debt (old site)

- **UX**: requires JavaScript to render anything; dated portal look; no meaningful hierarchy.
- **Design**: generic template; heavy image slider; cluttered menu; duplicate links.
- **Security**: untrusted source — possible spam/injected links, unknown admin, aged dependencies. Treat ALL old code as untrusted. Do NOT copy `public_html` wholesale.
- **SEO**: non-semantic URLs for slugs (`/read/{id}/...`), "uncategorized", no clean sitemap metadata verified.
- **Performance**: JS-rendered content hurts LCP/SEO; oversized media likely unoptimized.
- **Privacy**: public "direktori peserta didik" — violates privacy mandate. Drop it.

## 4. Proposed Architecture

- **Stack**: Laravel 11 (PHP 8.2 ✓) + Blade + Livewire (optional, used lightly) + Tailwind CSS 3 + Alpine.js + Vite + Lucide icons. MySQL/MariaDB. Eloquent ORM. Shared-hosting friendly.
- **Pattern**: standard Laravel structure. Eloquent models, Form Requests, Policies, Enums for statuses, Blade components. No Repository pattern (avoid over-engineering).
- **Frontend**: server-rendered Blade (fast, SEO), Alpine for lightweight interactivity (mobile menu, toasts, lightbox, counters).
- **Admin**: separate `/admin` area with its own layout, RBAC (Spatie Permission or custom roles/permissions).
- **SEO**: clean slugs, per-entity SEO fields, sitemap.xml, robots.txt, Schema.org (EducationalOrganization, Article, NewsArticle, Event, BreadcrumbList), redirects table (301).
- **Privacy**: public site never exposes NISN/NIK/address/DOB/phones of students.

## 5. Sitemap (public)

```
/
/berita            /berita/{slug}
/artikel           /artikel/{slug}
/pengumuman        /pengumuman/{slug}
/agenda            /agenda/{slug}
/prestasi
/profil
/profil/sejarah
/profil/visi-misi
/profil/sambutan-kepala
/profil/struktur-organisasi
/profil/guru        (guru & tendik)
/profil/fasilitas
/program            /program/{slug}
/program/unggulan
/akademik/kurikulum
/akademik/kalender
/kesiswaan/ekstrakurikuler   /kesiswaan/ekstrakurikuler/{slug}
/kesiswaan/organisasi
/galeri/foto/{slug}   /galeri/video
/alumni              /alumni/{slug}   /alumni/registrasi
/download             /download/{slug}
/kontak
/cari
/{page}   (static CMS pages)
```

## 6. Feature Matrix

### MVP (build first)
- Auth + Roles/Permissions (RBAC)
- General Settings (identity, contact, social, SEO defaults, WhatsApp float)
- Menus + static Pages CMS
- Berita + Kategori + Tag; Artikel
- Pengumuman; Agenda; Prestasi
- Guru & Tendik directory; Struktur Organisasi; Fasilitas (Sarana & Prasarana)
- Program Pendidikan; Program Unggulan; Kurikulum; Kalender Akademik
- Ekstrakurikuler; Organisasi Siswa
- Galeri Foto (album→foto) + Galeri Video
- Alumni + Registrasi Alumni (pending→verified)
- Download Center
- Global Search; Kontak (form + validation + turnstile + ratelimit); WhatsApp float
- Media Library
- SEO (meta, sitemap, robots, schema, redirects)
- Admin dashboard overview + activity log
- Error pages (403/404/419/429/500/503), empty states, toasts

### Recommended (after MVP)
- 2FA for admin, login throttling/history
- Backup module/docs, audit trail granularity
- Content migration tooling for legacy posts/media

### Future
- RSS feed, newsletters, alumni portal login, photo EXIF, advanced analytics

## 7. User Roles

- **Super Administrator**: everything.
- **Administrator**: most of the site.
- **Humas / Editor**: berita, artikel, galeri, agenda, pengumuman.
- **Operator Akademik**: program, kurikulum, kalender, prestasi.
- **Operator Kesiswaan**: kegiatan, organisasi, ekstrakurikuler.

Permissions (dot-style): `posts.create/update/delete`, `gallery.manage`, `teachers.manage`, `settings.manage`, etc. Enforced via Laravel Policies + middleware. Single source of truth in a seeder + permission registration list.

## 8. Database ERD Plan

Core + content tables (all use `id`, `timestamps`, `softDeletes` where sensible; UUID not needed):

```
users, roles, permissions, role_user, permission_role
posts (content_type: berita|artikel), post_categories, post_tags, tags
pages, announcements, events, achievements
education_programs, featured_programs, curriculums, academic_calendars
teachers (type: guru|tendik), organization_members (structure org tree)
facilities, extracurriculars, student_organizations
albums, media, photos (album_photo pivot via media.folder), videos
alumni, alumni_submissions
downloads, download_categories
contact_messages, social_links, menus, settings, redirects, activity_logs
```

Relationships:
- posts 1–N categories (FK `post_category_id`), N–N tags
- albums 1–N photos (via `media` or dedicated `photos`), media polymorphic attachments
- teachers N–1 (self) none; organization_members 1–N parent_id (tree)
- events/calendars standalone; achievements N–1 teacher/student optional
- downloads N–1 download_categories
- redirects standalone lookup

Indexes on: slug (unique), foreign keys, status, published_at, timestamps; composite where useful. Soft deletes on content & media.

## 9. UI Design System

- **Colors**: Primary Emerald `#10b981`/`#059669`, Secondary Forest `#064e3b`, Accent Gold `#d4af37` (sparing), Background white/off-white `#f8fafc`, Text Dark Slate `#0f172a`/`#334155`.
- **Typography**: Poppins (400/500/600/700). H1 44–56px, H2 30–40px, H3 22–28px, body 15–16px. Comfortable line-height (1.6). Mobile-responsive scale.
- **Spacing**: 4px base scale; generous whitespace; section padding ~ py-16/20.
- **Buttons**: rounded-lg, primary emerald, subtle hover lift + darken; focus-visible ring.
- **Cards**: white, 1px border `slate-200`, rounded-xl, subtle shadow, hover border/translate.
- **Forms**: labeled, clear focus ring, error text red, disabled/double-submit guard.
- **Icons**: Lucide, stroke 1.75, consistent 20–24px.
- **Responsive**: mobile-first; sticky translucent navbar; hamburger below lg; fluid grids.

## 10. Homepage Wireframe (top→bottom)

1. Topbar (contact/social) + Sticky Navbar
2. Hero (headline, subhead, 2 CTAs, real photo)
3. Quick Links (berita, pengumuman, agenda, prestasi, galeri, download)
4. Tentang Madrasah (2-col: image + blurb/values, CTA)
5. Statistik (animated counters: siswa, guru, tendik, alumni, prestasi, ekstra)
6. Sambutan Kepala (photo + quote, CTA)
7. Program Unggulan (cards)
8. Berita Terbaru (3-col grid)
9. Pengumuman (list, featured highlighted)
10. Agenda (upcoming list)
11. Prestasi (highlights)
12. Ekstrakurikuler (compact grid)
13. Galeri (photo thumbnails + video)
14. Jejak Alumni (testimonials)
15. CTA / Kontak band
16. Footer (identitas, madrasah, informasi, tautan, kontak, social, copyright)

## 11. Public Page Architecture

- Shared `layouts/app` (nav, footer, meta), `components/` for navbar, footer, section headers, cards, breadcrumbs, pagination, empty state, toast, whatsapp float.
- Blade views per module under `resources/views/`. SEO meta via a `Seo` component + per-entity `seo()`.
- Route groups: public, `pages` wildcard after explicit routes.

## 12. Admin Dashboard Structure

`/admin`, layout `layouts/admin`, sidebar:
Dashboard | Konten (Berita, Artikel, Pengumuman, Agenda, Halaman) | Akademik (Program Pendidikan, Program Unggulan, Kurikulum, Kalender, Prestasi) | Kesiswaan (Ekstrakurikuler, Organisasi, Kegiatan) | SDM (Guru, Tendik, Struktur) | Fasilitas | Media (Galeri Foto, Galeri Video, Media Library) | Alumni (Data, Registrasi) | Dokumen (Download) | Komunikasi (Pesan Masuk) | Sistem (Pengguna, Role, Menu, Pengaturan, Redirect, Audit Log, Backup).

Tables: search/filter/sort/paginate; Indonesian labels; toasts; confirm destructive.

## 13. Security Strategy

CSRF, XSS-escaping, parameterized queries, Policies, server-side validation, rate limiting (login, forms), bcrypt, secure sessions, file upload validation (MIME, size, random name, re-encode images), security headers (CSP, X-Content-Type-Options, Referrer-Policy, Permissions-Policy, HSTS prod). Admin: throttling, timeout, audit log, optional 2FA. Treat old site as untrusted: sanitize all migrated content.

## 14. Content Migration Strategy

Phase: backup (do at old host), extract, sanitize (strip scripts/iframes/spam/backlinks), validate, map categories (uncategorized→Informasi), import posts/media via CLI scripts, delete media not referenced, QA. Never blind-copy DB.

## 15. SEO Migration Strategy

`redirects` table: source_url → destination_url, 301. Map `/read/{id}/{slug}`→`/berita/{slug}`, `/kategori/{slug}`→`/berita?kategori=`, `/galeri-foto`→`/galeri/foto`, etc. Keep sitemap/robots, canonical, schema. Remove PPDB/SPMB old URLs (410 Gone) or map to `/berita`.

## 16. Performance Strategy

Eager loading, indexes, pagination, caching (config/settings/menu), lazy-load images, responsive/WebP, minified assets (Vite prod build), no N+1, limit hero weight, preload LCP.

## 17. Implementation Roadmap

Phase 0 audit → 1 foundation → 2 core public → 3 content CMS → 4 media → 5 alumni → 6 download → 7 SEO → 8 security → 9 performance → 10 testing → 11 migration → 12 deploy. (Full detail in root prompt §75.)

## 18. Recommended Folder Structure

```
app/
  Models/
  Http/Controllers/{Public,Admin}/
  Http/Requests/
  Http/Middleware/
  Policies/
  Services/           # MediaService, SeoService, SettingsService
  Enums/
database/migrations + seeders
resources/views/{layouts,components,public,admin,errors}
routes/{web,admin}.php
```

---

## Decisions locked
- NO SPMB/PPDB/registration of students. No student directories.
- Privacy: never expose student PII (NISN/NIK/DOB/phone/address).
- Indonesian admin UI. Poppins + emerald/gold. Server-rendered Blade.
- Roles/permissions enforced via Policies + middleware.

## 19. Implementation Progress

Last updated: 26 August 2026

- [x] Laravel 11 foundation, core dependencies, environment configuration
- [x] Database schema for content, academic, people, media, alumni, downloads, contact, settings, menus, redirects, and activity logs
- [x] RBAC permission seeder, settings seeder, navigation seeder, and development demo data
- [x] Shared public layout, responsive navigation, footer, SEO meta foundation, security headers, and reusable UI components
- [x] Public homepage backed by published database content
- [x] Berita and artikel listing/detail pages with category filtering, pagination, related content, reading time, and sanitized CMS body
- [x] Pengumuman, agenda, and prestasi listing/detail pages
- [x] Contact and alumni submission forms with validation and rate limiting
- [x] Search, static CMS page rendering, download delivery guard, and XML sitemap foundation
- [x] Admin login and authenticated dashboard overview
- [x] Integrated CMS dashboard, RBAC middleware, Berita/Artikel CRUD, Page CRUD, website settings, account/password management, and activity logging
- [x] Dedicated Profile CMS for about, history, vision/mission, principal speech, and organization structure
- [x] Guru and Tendik CMS with public visibility controls, image upload, ordering, soft delete, and restore
- [x] Pengumuman, Agenda, Prestasi, and Alumni CMS with publication workflows and alumni submission moderation
- [x] Profile, program, teacher, facility, gallery, alumni, and download presentation pages
- [x] Global search grouped across posts, announcements, events, achievements, teachers, pages, documents, and extracurriculars
- [ ] Admin CMS CRUD modules and authorization policies
- [ ] Media upload pipeline, image optimization, and production storage setup
- [ ] SEO redirects, expanded sitemap entities, error pages, and structured-data coverage
- [ ] Feature tests for every public module, forms, permissions, and admin workflows
- [ ] Legacy content migration, QA, performance pass, and deployment

See [`FEATURE_STATUS.md`](FEATURE_STATUS.md) for the master-prompt gap matrix and the recommended implementation order.
