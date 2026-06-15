# G.F. Sculpture Studios — WordPress Theme

A gallery-quality artist website and WooCommerce store for sculptor Geoff Fahey.
Cinematic GSAP animations, editorial typography, and a genuinely easy-to-shop experience.

---

## Required Plugins

Install and activate these before activating the theme:

| Plugin | Version | Notes |
|--------|---------|-------|
| **WooCommerce** | 8.x+ | Core shop functionality |
| **Advanced Custom Fields (ACF)** | Free, 6.x+ | Artwork metadata fields |
| **Contact Form 7** | 5.x+ | Contact page form |

---

## Installation

1. Copy the `gf-sculpture-studios/` folder to `/wp-content/themes/`
2. Install and activate the required plugins above
3. Go to **Appearance → Themes** and activate **G.F. Sculpture Studios**
4. Run **Settings → Permalinks → Save** to flush rewrite rules (important for the Portfolio archive)

---

## ACF Field Groups — Import

ACF JSON sync files are in `/acf-json/`. ACF will auto-detect and sync them.

**To confirm sync:**
1. Go to **ACF → Field Groups**
2. You should see **Artwork Details** and **Homepage Options** listed
3. If shown as "outdated", click **Sync** to import them

**Groups included:**
- `group_artwork_meta.json` — Artwork post type fields (year, material, dimensions, edition, statement, images, enquiry toggle, availability)
- `group_homepage_options.json` — Homepage content controls (hero image, intro statement, featured works)

---

## Registered Image Sizes

These are registered in `functions.php`. Set your media library to crop accordingly.

| Size name | Dimensions | Crop | Use |
|-----------|-----------|------|-----|
| `artwork-full` | 1200 × 1500 | No | Single artwork main image |
| `artwork-card` | 700 × 700 | Yes | Grid cards (square) |
| `artwork-thumb` | 140 × 140 | Yes | Gallery thumbnail strip |
| `hero-full` | 1920 × 1080 | No | Hero backgrounds |
| `portrait` | 900 × 1100 | No | Geoff's portrait |
| `product-card` | 600 × 600 | Yes | WooCommerce product cards |

**Regenerate thumbnails** after activating the theme if you have existing images:
Install **Regenerate Thumbnails** plugin and run it once.

---

## Setting Up the Homepage

The homepage is controlled by `front-page.php` with ACF field groups.

**To configure:**
1. Go to **Pages → Home** (or whatever your front page is set to in **Settings → Reading**)
2. In the **Homepage Options** ACF panel you'll find:
   - **Hero Image** — upload a full-bleed sculpture photograph (min 1920×1080)
   - **Intro Statement** — the large italic sentence below the hero
   - **Statement Piece Heading/Text** — the full-bleed split section
   - **Featured Works (Horizontal Scroll)** — select 3–5 Artworks for the cinematic scroll

---

## Setting Up the Horizontal Scroll Section

This is the pinned GSAP section where cards scroll sideways.

1. In the Homepage Options panel, use the **Featured Works** relationship field
2. Select 3–5 artworks (works with strong images work best)
3. On mobile (≤768px) it automatically degrades to a vertical stack

> **Note:** GSAP's horizontal scroll uses `ScrollTrigger` pinning. If the section height looks wrong after adding images, visit any page and `ScrollTrigger.refresh()` is called on `window load` automatically.

---

## Adding Artwork

Artworks live in the **Artworks** post type (sidebar icon: palette).

**For each artwork:**
1. Create a new Artwork post
2. Set the **Featured Image** — this is the primary display image
3. Fill in the **Artwork Details** ACF panel:
   - **Year** — e.g. `2024`
   - **Material** — e.g. `Bronze`, `Portland Stone` (used for JS filtering)
   - **Dimensions** — e.g. `45 × 30 × 20 cm`
   - **Edition** — e.g. `Unique` or `Edition of 5, 2/5`
   - **Artist Statement** — Geoff's personal note about this piece
   - **Additional Images** — extra views shown in the thumbnail strip
   - **Enquire Only** — toggle on to hide Add to Cart and show Enquire button
   - **Availability** — Available / Sold / Reserved

**Linking to WooCommerce:**
Each Artwork *is* a WooCommerce product. To enable purchasing:
1. Create a new **Product** OR convert by adding WooCommerce data to the Artwork post
2. Set the price in the **Product Data** panel
3. The theme's single artwork template calls `wc_get_product($post_id)` — the CPT and product share the same post ID

For works where you don't want a direct price (commissions, high-value works):
- Toggle **Enquire Only** in the Artwork Details panel
- The Add to Cart button is replaced with an Enquire button linking to the Contact page

---

## Toggling Enquire Only vs. Purchasable

Per-artwork toggle in the Artwork Details ACF panel:

| Setting | Result |
|---------|--------|
| **Enquire Only: OFF** | Price shown, Add to Cart button visible |
| **Enquire Only: ON** | Price hidden, "Enquire About This Work" button shown, links to contact page |

---

## Material Filtering

The portfolio archive (`/portfolio/`) filters by the **Material** ACF text field.

The filter bar looks for `data-material` attributes set to the lowercase material name. For filtering to work correctly:
- Use consistent capitalisation in the Material field: `Bronze`, `Stone`, `Resin`, `Steel`, `Wood`, `Ceramic`
- The filter converts to lowercase for matching — so `Bronze` and `bronze` both work

---

## Contact Form 7 Setup

1. Install and activate Contact Form 7
2. Go to **Contact → Add New**
3. Create a form with these fields:
   - Name (`text*`)
   - Email (`email*`)
   - Subject (`select` with options: General Enquiry, Commission, Purchase Enquiry, Press)
   - Message (`textarea*`)
4. Copy the form shortcode (e.g. `[contact-form-7 id="123" title="Contact Form"]`)
5. Open `page-contact.php` and replace `[PLACEHOLDER_CF7_ID]` with your actual form ID

The form styles are in `assets/css/woocommerce.css` under `/* ── CONTACT FORM 7 ──`.

---

## Google Maps Embed (Contact Page)

1. Go to [maps.google.com](https://maps.google.com)
2. Search for the studio address
3. Click **Share → Embed a map**
4. Copy the `<iframe>` HTML
5. Open `page-contact.php` and replace the placeholder `<div>` inside `.map-embed` with the iframe

---

## Navigation Setup

1. Go to **Appearance → Menus**
2. Create a menu called "Primary Navigation"
3. Add pages: Portfolio, Shop, About, Contact
4. Set the display location to **Primary Navigation**
5. Save

The mobile overlay nav in `template-parts/header.php` has hardcoded fallback links — these work automatically once pages exist with the correct slugs (`about`, `contact`).

---

## GSAP & SplitText Note

The theme uses **GSAP** (free) and **ScrollTrigger** (free) loaded via CDN.

**SplitText** is a premium GreenSock plugin (requires Club GreenSock membership). The theme:
- Uses SplitText for heading reveals if it's loaded
- Falls back gracefully to a simpler whole-element reveal if it isn't

To use SplitText:
1. Purchase a Club GreenSock membership at [greensock.com](https://greensock.com)
2. Download `SplitText.min.js`
3. Host it locally and enqueue it in `functions.php` before `gfs-animations`

---

## Placeholder Checklist — Before Going Live

Replace all `[PLACEHOLDER: ...]` comments throughout the templates:

- [ ] **Logo** — Replace `assets/images/logo.svg` with a refined version or upload via **Appearance → Customize → Site Identity**
- [ ] **Hero image** — Upload via Homepage Options ACF panel
- [ ] **Geoff's portrait** — `page-about.php` about-hero section
- [ ] **Studio photos** — `page-about.php` studio grid (6 images)
- [ ] **Bio text** — `page-about.php` bio section
- [ ] **Timeline entries** — `page-about.php` career timeline
- [ ] **Intro statement** — Homepage Options ACF panel
- [ ] **About snippet quote** — `front-page.php` blockquote
- [ ] **About snippet bio** — `front-page.php` paragraph
- [ ] **Commission paragraph** — `front-page.php` and `page-contact.php`
- [ ] **Studio address** — `template-parts/footer.php` and `page-contact.php`
- [ ] **Email address** — `template-parts/footer.php` and `page-contact.php`
- [ ] **Phone number** — `page-contact.php`
- [ ] **Social links** — `template-parts/header.php` overlay nav and `template-parts/footer.php`
- [ ] **Google Maps embed** — `page-contact.php`
- [ ] **Contact Form 7 ID** — `page-contact.php`
- [ ] **Copyright year** — Auto-generated, but confirm studio name is correct in footer

---

## Recommended WordPress Settings

| Setting | Value |
|---------|-------|
| **Settings → Reading → Front page** | Static page → Home |
| **Settings → Reading → Posts page** | (leave unset or set to a Blog page) |
| **Settings → Permalinks** | Post name (`/%postname%/`) |
| **WooCommerce → Settings → Products → Display** | Show products, not categories |
| **WooCommerce → Settings → Account → Guest checkout** | Enabled (recommended) |

---

## Performance Notes

- All images use `loading="lazy"` (except hero which uses `fetchpriority="high"`)
- Google Fonts loaded with `preconnect` hints for fastest load
- All JS files are enqueued in footer (`true` as last arg in `wp_enqueue_script`)
- GSAP and Lenis are loaded from CDN (fast, cached by browsers)
- Add a caching plugin (e.g. WP Super Cache or LiteSpeed Cache) in production
- Use WebP images where possible — WordPress 6.1+ converts automatically on upload

---

## Theme File Map

```
gf-sculpture-studios/
├── style.css                    Theme header
├── functions.php                Setup, enqueue, CPT, ACF, WooCommerce
├── front-page.php               Homepage
├── index.php                    Blog/fallback
├── page.php                     Default page
├── page-about.php               About page
├── page-contact.php             Contact page
├── single.php                   Default single post
├── single-artwork.php           Single artwork (gallery + sticky panel)
├── archive-artwork.php          Portfolio archive (filter + grid)
├── search.php                   Search results
├── 404.php                      404 error page
├── woocommerce/
│   ├── archive-product.php      Shop archive
│   ├── single-product.php       Single product
│   ├── cart/cart.php            Cart
│   └── checkout/form-checkout.php  Checkout
├── template-parts/
│   ├── header.php               Site header, nav overlay
│   ├── footer.php               Site footer
│   ├── hero.php                 Hero section (reusable)
│   ├── artwork-card.php         Artwork grid card
│   ├── product-card.php         WooCommerce product card
│   ├── horizontal-scroll.php    Pinned horizontal scroll
│   └── statement-piece.php      Full-bleed split section
├── assets/
│   ├── css/
│   │   ├── main.css             All design: palette, type, layout, components
│   │   ├── animations.css       Cursor, curtain, reveal states, reduced-motion
│   │   └── woocommerce.css      WooCommerce + Contact Form 7 styles
│   ├── js/
│   │   ├── main.js              GSAP/Lenis init, curtain, header behaviour
│   │   ├── animations.js        All ScrollTrigger animations
│   │   ├── cursor.js            Custom bronze cursor
│   │   ├── nav.js               Mobile overlay nav + page transitions
│   │   └── filter.js            Portfolio filter + load more
│   └── images/
│       └── logo.svg             Placeholder text logo
├── acf-json/
│   ├── group_artwork_meta.json  ACF: Artwork fields
│   └── group_homepage_options.json  ACF: Homepage controls
└── README.md                    This file
```

---

Built for G.F. Sculpture Studios · Geoff Fahey · Sculptor
