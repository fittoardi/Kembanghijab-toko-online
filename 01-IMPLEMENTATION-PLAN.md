# Implementation Plan — Kembang Hijab Customer Storefront (Frontend)

**Sources:** `PRD.md` v1.0, `DB.md` v1.0 `DESIGN.md` v1.0 `DB.md`
**Scope:** All customer-facing views (Blade + Tailwind CSS + Vite). The Filament 4 admin panel is **out of scope**.
**Stack:** Laravel 13, PHP 8.3+, MySQL, Blade, Tailwind CSS, Vite, Alpine.js (ships with Breeze), Eloquent.

---

## 1. Scope

### 1.1 In scope (customer view)

| # | Feature | PRD § | Main DB tables |
|---|---------|-------|----------------|
| 1 | Landing page | 5.1 | products, categories, product_images, reviews, (banners*) |
| 2 | Register / Login / Forgot & Reset password / Email verification | 6 | users |
| 3 | Product listing: search, filter, sort, pagination | 7 | products, categories, product_variants, reviews |
| 4 | Product detail + variant selection + stock | 8, 9 | products, product_variants, product_images, reviews |
| 5 | Wishlist | 10 | wishlists, wishlist_items |
| 6 | Shopping cart + mini-cart | 11 | carts, cart_items |
| 7 | Address management | 12 | addresses |
| 8 | Voucher & automatic promotion display | 13 | vouchers, promotions |
| 9 | Checkout (address → shipping → voucher → payment → review → place) | 14 | orders, order_items, shipments |
| 10 | Payment page (Tripay) + status | 15 | payments, payment_webhooks |
| 11 | Order history + order detail + tracking | 16, 17, 18 | orders, order_items, payments, shipments |
| 12 | Review & rating | 19 | reviews |
| 13 | Customer service chat | 20 | chat_conversations, chat_messages |
| 14 | Notifications (in-app bell; email/WA are backend) | 21 | notifications* |
| 15 | Customer profile | 22 | users |
| 16 | SEO | 28 | products, categories |
| 17 | Social media section (Instagram / TikTok) | 29 | config |

`*` = not in `DB.md`; see **§14 Gaps & Decisions**.

### 1.2 Out of scope

- Filament admin resources and dashboard.
- Real Tripay, shipping-provider, and WhatsApp integrations. The frontend talks to **service interfaces**; fake implementations are used until Phase 2 of the PRD (see §9).
- Webhook handling (backend only). The frontend only **reads** payment status.

### 1.3 Definition of "frontend complete"

Every customer flow in PRD §33 can be clicked through end-to-end on seeded data: **Landing → List → Detail → Cart → Checkout → Pay → Track → Review**, on mobile, tablet, and desktop, including empty, loading, error, and validation states.

---

## 2. Technical Decisions

| Topic | Decision | Reason |
|-------|----------|--------|
| Rendering | Server-rendered Blade, one Blade component per UI atom | PRD says Blade + Tailwind; good for SEO |
| Interactivity | Alpine.js + `fetch` (JSON) for cart, wishlist, voucher, shipping options, chat polling, payment polling | Light, already in Breeze; no SPA needed |
| Auth scaffolding | Laravel Breeze (Blade stack), restyled to the design system | PRD §6 |
| Styling | Tailwind CSS with design tokens in CSS (`@theme`); a few `@layer components` classes for glass | Consistent look, no per-page one-offs |
| Fonts | Self-hosted (`@fontsource`): **Cormorant Garamond** (display), **Plus Jakarta Sans** (body) | Performance and privacy |
| Icons | Inline SVG via `<x-icon name="...">` (Lucide set) | No icon font download |
| Images | `loading="lazy"`, `width`/`height` always set, `srcset` when thumbnails exist, WebP preferred | PRD §32 |
| Money | `rupiah($n)` helper → `Rp 1.250.000` | Indonesian market |
| Timezone / locale | `Asia/Jakarta`; UI copy in English (matches PRD labels); dates `d M Y, H:i` | |
| Mobile-first | Design at 360px, then `sm` / `md` / `lg` / `xl` | PRD §32 |
| Authorization | Customer routes under `auth` (+ `verified` only for checkout if email verification is turned on); `role = customer` check; admins redirected to `/admin` | PRD §31 |

---

## 3. Design System

### 3.1 Style

**Premium + Minimal + Elegant Glassmorphism** — soft gradient background, translucent cards with backdrop blur, thin white borders, large radii, generous whitespace, soft shadows, subtle motion.

### 3.2 Color tokens

| Token | Hex | Use |
|-------|-----|-----|
| `cream` | `#FBF7F0` | Page base |
| `ivory` | `#FFFDFA` | Cards / inputs |
| `beige` | `#EFE6D8` | Dividers, secondary surfaces |
| `blush` (soft pink) | `#F3D9D6` | Accents, badges, gradient |
| `dusty` | `#D9A8A5` | Hover on blush, wishlist active |
| `lilac` (soft purple) | `#D9CFEA` | Gradient accent, info badges |
| `cocoa` (brown) | `#5B4636` | Primary text and primary button |
| `cocoa-soft` | `#8A7261` | Secondary text |
| `gold` | `#C9A24D` | CTA highlight, ratings, focus accents |
| Semantic | success `#4F8A6B`, warning `#C98A2B`, danger `#B5483F`, info `#6C5BA8` | Status badges |

Rule: at most **two** accent colors visible in any viewport. Body text must keep ≥ 4.5:1 contrast on glass surfaces.

### 3.3 `resources/css/app.css` (Tailwind v4 style; adapt to `tailwind.config.js` if the project is on v3)

```css
@import "tailwindcss";

@theme {
  --color-cream: #FBF7F0;
  --color-ivory: #FFFDFA;
  --color-beige: #EFE6D8;
  --color-blush: #F3D9D6;
  --color-dusty: #D9A8A5;
  --color-lilac: #D9CFEA;
  --color-cocoa: #5B4636;
  --color-cocoa-soft: #8A7261;
  --color-gold: #C9A24D;

  --font-display: "Cormorant Garamond", ui-serif, Georgia, serif;
  --font-sans: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;

  --radius-glass: 1.5rem;
  --shadow-glass: 0 8px 32px rgba(91, 70, 54, 0.08);
}

@layer base {
  body {
    @apply bg-cream font-sans text-cocoa antialiased;
    background-image:
      radial-gradient(60rem 40rem at 10% -10%, rgba(243,217,214,.7), transparent 60%),
      radial-gradient(50rem 40rem at 100% 0%, rgba(217,207,234,.55), transparent 60%);
    background-attachment: fixed;
  }
  h1, h2, h3 { @apply font-display tracking-tight; }
}

@layer components {
  .glass {
    @apply rounded-[--radius-glass] border border-white/60 bg-white/60 shadow-glass backdrop-blur-xl;
  }
  .glass-strong { @apply glass bg-white/80; }
  @supports not (backdrop-filter: blur(1px)) {
    .glass, .glass-strong { @apply bg-ivory; }
  }
}

@media (prefers-reduced-motion: reduce) {
  * { animation-duration: .01ms !important; transition-duration: .01ms !important; }
}
```

### 3.4 Typography scale

| Role | Mobile | Desktop |
|------|--------|---------|
| Hero H1 | 40/44 display | 72/76 display |
| H2 section | 30/36 display | 44/50 display |
| H3 card title | 18/26 sans semibold | 20/28 |
| Body | 15/24 | 16/26 |
| Caption / badge | 12/16 uppercase tracking-wide | same |

### 3.5 Motion

- Hover lift: `transition duration-300 hover:-translate-y-0.5 hover:shadow-lg`.
- Reveal-on-scroll: fade + 12px translate via `IntersectionObserver` (Alpine `x-intersect` or small vanilla helper).
- Drawer/modal: 200–250 ms ease-out. Toasts: slide + fade, 3.5 s auto-dismiss.
- Always honor `prefers-reduced-motion`.

---

## 4. Project Structure

```
resources/
├── css/app.css
├── js/
│   ├── app.js                  # Alpine bootstrap + stores
│   ├── stores/{toast,cart,wishlist,ui}.js
│   ├── lib/{http,format,debounce,clipboard}.js
│   └── pages/{checkout,payment,chat,product-detail}.js
└── views/
    ├── layouts/{app,account,checkout,auth}.blade.php
    ├── components/
    │   ├── ui/            # button, input, select, textarea, checkbox, radio-card, badge, modal, drawer,
    │   │                  # toast, skeleton, empty-state, breadcrumb, pagination, icon, qty-stepper,
    │   │                  # countdown, tabs, accordion, section-heading, glass-card
    │   ├── shop/          # product-card, product-gallery, variant-selector, price, rating-stars,
    │   │                  # rating-input, stock-badge, wishlist-button, category-tile, filter-panel,
    │   │                  # sort-select, review-card, review-summary
    │   ├── cart/          # cart-item, mini-cart, order-summary, voucher-input
    │   ├── account/       # address-card, address-form, sidebar, order-card, status-stepper,
    │   │                  # payment-badge, order-status-badge, notification-item
    │   ├── chat/          # bubble, composer, topic-chips
    │   └── layout/        # navbar, mobile-menu, footer, search-overlay, floating-chat
    ├── pages/
    │   ├── home.blade.php
    │   ├── products/{index,show}.blade.php
    │   ├── categories/show.blade.php
    │   ├── wishlist/index.blade.php
    │   ├── cart/index.blade.php
    │   ├── checkout/index.blade.php
    │   ├── payments/show.blade.php
    │   ├── orders/{index,show}.blade.php
    │   ├── reviews/create.blade.php
    │   ├── account/{profile,password,addresses}.blade.php
    │   ├── chat/index.blade.php
    │   ├── notifications/index.blade.php
    │   └── errors/{404,403,419,500,503}.blade.php
    └── auth/{login,register,forgot-password,reset-password,verify-email}.blade.php

app/
├── Http/Controllers/Storefront/...        # thin controllers returning views / JSON
├── Http/Requests/...                      # FormRequests (validation)
├── Http/Resources/...                     # JSON resources for AJAX responses
├── Services/{Cart,Checkout,Shipping,Payment,Voucher,Promotion}/...
├── Contracts/{ShippingService,PaymentGateway,RegionService}.php
└── Support/{helpers.php,Swatches.php}

config/{brand.php,storefront.php,swatches.php}
database/{factories,seeders}               # demo catalog so every page has data
```

---

## 5. Layouts

| Layout | Used by | Notes |
|--------|---------|-------|
| `layouts.app` | Public & most pages | Navbar (sticky glass), `<main>`, footer, toast host, mini-cart drawer, floating chat button |
| `layouts.account` | Profile, addresses, orders, wishlist, chat, notifications | Sidebar (desktop) / horizontally scrollable tabs (mobile) inside `layouts.app` |
| `layouts.checkout` | Checkout, payment | Minimal header (logo + "Secure checkout" + back to cart), no footer clutter |
| `layouts.auth` | Login / register / reset | Split layout: brand image (hidden on mobile) + glass form card |

**Navbar contents:** logo · Shop · Categories (mega-menu desktop / accordion mobile) · Search (overlay with live suggestions) · Wishlist (count) · Cart (count, opens mini-cart) · Account menu (or Login / Register when guest) · Notification bell (logged in).

**Footer:** brand blurb, shop links, help links (shipping, payment, returns, contact), social icons, payment-channel strip, copyright.

---

## 6. Route Map (customer)

| Method | URI | Name | Auth | Page / response |
|--------|-----|------|------|-----------------|
| GET | `/` | `home` | – | Landing |
| GET | `/products` | `products.index` | – | Listing (`?q&category&min_price&max_price&availability&sort&page`) |
| GET | `/products/{slug}` | `products.show` | – | Detail |
| GET | `/categories/{slug}` | `categories.show` | – | Listing scoped to category |
| GET | `/search/suggest?q=` | `search.suggest` | – | JSON (top 5 products + categories) |
| GET | `/sitemap.xml` | `sitemap` | – | XML |
| GET/POST | `/login`, `/register`, `/forgot-password`, `/reset-password/{token}` | Breeze names | guest | Auth pages |
| GET | `/verify-email` | `verification.notice` | auth | Only if verification enabled |
| POST | `/logout` | `logout` | auth | |
| GET | `/cart` | `cart.index` | auth | Cart page |
| GET | `/cart/summary` | `cart.summary` | auth | JSON (count, subtotal, items) for mini-cart |
| POST | `/cart/items` | `cart.items.store` | auth | JSON add `{product_variant_id, quantity}` |
| PATCH | `/cart/items/{item}` | `cart.items.update` | auth | JSON `{quantity}` |
| DELETE | `/cart/items/{item}` | `cart.items.destroy` | auth | JSON |
| POST | `/buy-now` | `buy-now` | auth | Creates a one-item checkout session, redirects |
| GET | `/wishlist` | `wishlist.index` | auth | Wishlist page |
| POST | `/wishlist/toggle` | `wishlist.toggle` | auth | JSON `{product_id}` → `{wishlisted}` |
| POST | `/wishlist/{product}/move-to-cart` | `wishlist.move` | auth | JSON (needs `product_variant_id`) |
| GET | `/checkout` | `checkout.index` | auth | Checkout |
| POST | `/checkout/voucher` | `checkout.voucher.apply` | auth | JSON totals |
| DELETE | `/checkout/voucher` | `checkout.voucher.remove` | auth | JSON totals |
| POST | `/checkout/shipping-options` | `checkout.shipping` | auth | JSON options for `address_id` |
| POST | `/checkout` | `checkout.store` | auth | Place order → redirect to `payments.show` |
| GET | `/orders/{order_number}/payment` | `payments.show` | auth + owner | Payment page |
| GET | `/orders/{order_number}/payment/status` | `payments.status` | auth + owner | JSON `{payment_status, order_status}` |
| GET | `/account/orders` | `orders.index` | auth | History (`?status=`) |
| GET | `/account/orders/{order_number}` | `orders.show` | auth + owner | Detail + tracking |
| POST | `/account/orders/{order_number}/cancel` | `orders.cancel` | auth + owner | Only `pending` + unpaid |
| POST | `/account/orders/{order_number}/complete` | `orders.complete` | auth + owner | "Confirm received" (when `shipped`) |
| GET/POST | `/account/orders/{order_number}/reviews/{product}` | `reviews.create` / `reviews.store` | auth + owner | Only when `completed` |
| GET/PUT | `/account/profile` | `account.profile` | auth | Profile + photo |
| PUT | `/account/password` | `account.password` | auth | |
| GET/POST/PUT/DELETE | `/account/addresses…` | `account.addresses.*` | auth | CRUD + `PATCH …/default` |
| GET | `/account/chat` | `chat.index` | auth | Chat page |
| GET/POST | `/account/chat/messages` | `chat.messages` | auth | JSON poll (`?after_id=`) / send (multipart) |
| GET | `/account/notifications` | `notifications.index` | auth | List |
| POST | `/account/notifications/{id}/read` | `notifications.read` | auth | JSON |

Rate limiting: login, register, forgot-password, voucher apply (10/min), chat send (20/min), search suggest (60/min).

---

## 7. Shared Rules (apply everywhere)

### 7.1 Price & discount display

```
effective_price = variant.price ?? product.price
original_price = product.compare_price (shown only if > effective_price)
discount_percent = round((1 - effective_price / compare_price) * 100)
```

- Listing/product card with several variant prices: show `From Rp X` using the minimum active-variant price.
- Automatic `promotions` are **not** baked into card prices. They appear as a banner/notice and as a line in cart/checkout totals (the DB has a single `discount_amount`).

### 7.2 Stock status (variant level — PRD §9)

| Stock | Label | Badge | Behavior |
|------:|-------|-------|----------|
| > 10 | In Stock | success | Normal |
| 1–10 | Low Stock — only {n} left | warning | Show remaining count |
| 0 | Out of Stock | muted/danger | Variant disabled, "Add to Cart" disabled, "Notify me" is **not** in scope |

Product-level status = best status among active variants (sum of stock for the card badge). A product is "Out of Stock" only if every active variant is 0.

### 7.3 Rating

- Only reviews with `is_approved = true` count.
- Show average (1 decimal) + count. No reviews → "No reviews yet" (never `0.0`).
- Implement as Eloquent `withAvg('approvedReviews','rating')` and `withCount('approvedReviews')`.

### 7.4 Status vocabulary

| Order status | Label | Badge |
|--------------|-------|-------|
| pending | Awaiting Payment / Pending | warning |
| processing | Processing | info |
| packed | Packed | info |
| shipped | Shipped | info |
| completed | Completed | success |
| cancelled | Cancelled | danger |

| Payment status | Label | Badge |
|----------------|-------|-------|
| unpaid | Unpaid | warning |
| pending | Waiting for Payment | warning |
| paid | Paid | success |
| failed | Failed | danger |
| expired | Expired | muted |
| refunded | Refunded | info |

Order and payment status are **always shown as two separate badges** (PRD §16).

### 7.5 UX states every page must have

1. **Loading** — skeletons matching final layout (no spinners for page content).
2. **Empty** — `x-ui.empty-state` with illustration/icon, one sentence, one CTA.
3. **Error** — inline message + retry for AJAX; styled error pages for HTTP errors.
4. **Validation** — field-level messages under inputs, summary at top on long forms, preserved old input.
5. **Success** — toast for non-navigational actions.

### 7.6 Security in the frontend layer

- `@csrf` on every form; `X-CSRF-TOKEN` header on `fetch`.
- Escape all user content with `{{ }}`; never `{!! !!}` for review comments, chat messages, or names.
- Uploads (review photo, chat attachment, profile photo): client-side type/size check **and** server validation; accept `jpg, jpeg, png, webp` ≤ 2 MB.
- Ownership checks (`order.user_id === auth.id`) via policies, never only by hiding links.
- Never trust client-side totals: checkout totals are recomputed on the server at every step and on placement.

---

## 8. Page Specifications

Format: **Data** (DB source) · **UI** · **Interactions** · **States/Rules**.

### 8.1 Landing page — `home` (PRD §5.1)

- **Data:** featured products (`is_featured`), newest products, best sellers (by sold quantity), active categories, approved reviews with rating ≥ 4, banners*, brand config.
- **Sections (in order):**
  1. Navbar (transparent over hero, glass on scroll)
  2. Hero — headline, subcopy, two CTAs (**Shop Now**, **Explore Collection**), hero image with floating glass mini-cards (e.g., "New: Pashmina Silk")
  3. Category tiles (4–6, image + name + "Explore")
  4. Featured products (carousel on mobile, 4-col grid desktop)
  5. Promotional banner (active promotion / voucher teaser)
  6. New arrivals
  7. Best sellers
  8. Brand story (image + text + **Discover More**)
  9. Customer reviews (carousel of glass cards)
  10. Instagram / TikTok section (6-tile grid + follow CTAs)
  11. Newsletter strip (optional, UI only)
  12. Footer
- **Interactions:** scroll reveal, product-card quick wishlist, horizontal snap scrolling on mobile.
- **States:** a section with no data is hidden (never an empty frame).

### 8.2 Authentication (PRD §6)

| Page | Fields | Notes |
|------|--------|-------|
| Register | name, email, phone, password, password_confirmation | Show/hide password, strength hint, terms checkbox; phone normalized to `62…` or `08…` format on blur |
| Login | email, password, remember me | "Forgot password?" link; honors `intended` URL (e.g., back to checkout) |
| Forgot password | email | Neutral success message (no user enumeration) |
| Reset password | email (readonly), password, confirmation | |
| Verify email | — | "Resend" with 60 s cooldown; only if enabled |

- Glass card on soft-gradient background; the brand image side panel is hidden below `lg`.
- After register → redirect to the page the user came from, else `/`.
- Admin users logging in → redirect to `/admin`; customers are never routed to Filament.

### 8.3 Product listing — `products.index`, `categories.show` (PRD §7)

- **Data:** `products` (active) with `primaryImage`, min variant price, stock sum, rating, wishlist state for the current user.
- **Layout:** title + result count · search field · sort select · filter panel (sidebar on `lg+`, bottom-sheet drawer on mobile) · grid (2 cols mobile, 3 tablet, 4 desktop) · pagination.
- **Filters:** category (checkbox list, single-select when on `categories.show`), price range (min/max inputs + quick chips), availability (In stock only), clear-all, active-filter chips.
- **Sorting values:** `newest`, `oldest`, `price_asc`, `price_desc`, `popular`, `rating`.
- **Product card:** primary image (hover → second image on desktop), name, category, price (+ strikethrough + `-%` badge), rating stars, stock badge, wishlist heart. Out-of-stock cards are dimmed with a label but still link to detail.
- **Interactions:** filters submit via GET (shareable URLs). Enhance with Alpine to debounce and update with `fetch` + `history.pushState` (optional). Wishlist heart toggles instantly (optimistic) and rolls back on error.
- **States:** skeleton grid; empty → "No products match your filters" + Clear filters; guests tapping the heart are sent to login and returned to the same page.

### 8.4 Product detail — `products.show` (PRD §8, §9)

- **Data:** product + category + images (ordered by `sort_order`, primary first) + active variants + approved reviews (paginated) + related products (same category).
- **Layout (desktop):** left gallery (main image + thumbnails, zoom on hover, swipe on mobile, lightbox) · right purchase panel (sticky).
- **Purchase panel:** breadcrumb · name · category link · rating link (scrolls to reviews) · price block · short description · **Color** swatches · **Size** pills · stock badge · **quantity stepper** · **Add to Cart** · **Buy Now** · **Wishlist** toggle · shipping/returns mini-info.
- **Below:** tabs/accordion — Description · Material & Care · Reviews (summary bars 5→1, list, pagination, photo thumbnails) · Related products. On mobile, a sticky bottom bar with price + Add to Cart.
- **Variant logic:**
  - Build a JS map `variants = [{id, color, size, price, stock}]` (JSON in a `<script type="application/json">`).
  - Selecting a color enables only sizes available for that color (and vice versa). Combos with stock 0 render struck-through and disabled.
  - On a valid combo: update price, stock badge, `max` of the stepper, and the image (if a variant image convention exists; otherwise keep gallery).
  - Add to Cart / Buy Now stay disabled until a valid in-stock combo is selected (tooltip: "Select color and size").
  - A product with a single variant is auto-selected.
- **Color swatches:** `config/swatches.php` maps `color` string → hex (`Black`, `Cream`, `Brown`, `Dusty Pink`, …); unknown colors render as a labeled pill.
- **Add to Cart:** `POST cart.items.store` → toast "Added to cart", bump navbar counter, open mini-cart drawer. Guest → login with `intended` + remembered selection.
- **Buy Now:** `POST buy-now` → checkout with only that variant.
- **Rules:** quantity is clamped to `min(stock, remaining capacity vs. existing cart quantity)`; show "Max available: n".
- **SEO:** `<title>`, meta description, canonical, Open Graph, JSON-LD `Product` (offers, aggregateRating).

### 8.5 Wishlist — `wishlist.index` (PRD §10)

- **Data:** `wishlist_items` → products (product-level, not variant-level).
- **UI:** grid of cards with Remove (×) and **Move to Cart**.
- **Move to Cart:** if the product has exactly one in-stock variant → add directly; otherwise open a quick-select modal (color/size/qty) then add. On success, the item is removed from the wishlist after a toast with Undo.
- **States:** empty → "Your wishlist is empty" + Shop Now; out-of-stock items remain, with the button replaced by "Out of stock".
- Only for logged-in users; the heart on guest sessions redirects to login.

### 8.6 Cart — `cart.index` + mini-cart (PRD §11)

- **Data:** `cart_items` → variant → product (+ primary image), current stock and price.
- **Row:** image, product name (link), variant (color · size), unit price, quantity stepper, subtotal, remove.
- **Summary (glass, sticky on desktop):** total items, subtotal, notice for automatic promotions ("Add Rp 50.000 more to get Rp 25.000 off"), voucher teaser (voucher is applied at checkout), **Proceed to Checkout**, **Continue Shopping**.
- **Interactions:** stepper `PATCH` with debounce 400 ms and optimistic totals; remove with Undo toast; stepper `max` = variant stock.
- **Rules:** quantity can never exceed stock (inline message "Only n left"); items whose variant became inactive/out of stock are flagged "No longer available" and block checkout until removed; price changes since add-time show an "Updated price" chip.
- **Mini-cart drawer:** last items, subtotal, View Cart / Checkout buttons; opened from navbar and after Add to Cart.
- **Guest:** `carts.user_id` is required by the DB → guests are prompted to log in (see §14 decision D1).

### 8.7 Address management — `account.addresses.*` (PRD §12)

- **Fields:** `recipient_name`, `phone`, `label` (chips: Rumah / Kantor / Kos / custom), `province`, `city`, `district`, `postal_code`, `address` (textarea), `is_default` (switch).
- **UI:** address-card grid (label badge, "Default" badge, Edit / Delete / Set as default). Add/Edit in a modal (checkout) or a dedicated page (account).
- **Region inputs:** dependent selects via `RegionService` (Province → City → District); the fallback is text inputs with `datalist`.
- **Rules:** first address becomes default automatically; deleting the default promotes the next one; cannot delete an address used in a pending checkout without confirmation (orders keep `address_snapshot`, so deleting is otherwise safe).
- **Validation:** phone `^(\+62|62|0)8[1-9][0-9]{6,11}$`, postal code 5 digits.

### 8.8 Checkout — `checkout.index` (PRD §13, §14)

- **Layout:** `layouts.checkout`. Desktop: two columns (left steps, right sticky **Order Summary**). Mobile: single column, summary collapsed at top with total, expandable.
- **Steps (accordion; a step unlocks when the previous is valid):**
  1. **Address** — radio list of saved addresses (default preselected), "Add new address" modal. No address → forced to add one.
  2. **Shipping** — fetched from `ShippingService` after address selection: courier, service, estimated delivery, cost (radio cards). Skeleton while loading; error with retry.
  3. **Voucher** — input + Apply; shows applied code chip with Remove; error messages from server (expired, minimum purchase not met, usage limit, per-customer limit). Automatic promotion line shown read-only.
  4. **Payment** — channel groups from `PaymentGateway::channels()`: Bank Transfer (VA), E-Wallet, Retail, QRIS, plus **COD** if enabled in config. Each channel: logo, name, fee (if any).
  5. **Review** — read-only recap of address, shipping, payment, item list, optional **order note** (`orders.notes`, 200 chars).
- **Summary lines:** Products (thumbnails + qty) · Subtotal · Discount (voucher/promo) · Shipping Cost · Voucher · **Grand Total**.
- **Place Order:** disabled until steps 1, 2, 4 are valid; click → button loading state + double-submit guard (idempotency token in the form) → `POST checkout.store`.
  - Success → redirect to `payments.show` (or to `orders.show` for COD).
  - Stock conflict → return to the cart-item list with per-item error ("Only 2 left for Cream / 115×115"); totals recomputed.
- **Rules:** totals come from the server on every change (address, shipping, voucher); order stores `address_snapshot`, item snapshots (`product_name`, `variant_name`, `sku`, `price`); `Buy Now` mode checks out a single item and leaves the cart untouched.

### 8.9 Payment page — `payments.show` (PRD §15)

- **Data:** `payments` (+ `raw_response` for pay code / QR / checkout URL / instructions), order summary.
- **Header:** order number, amount (large), **countdown** to `expired_at`.
- **Method block (adapts to channel):**
  - *Virtual Account / bank transfer:* bank logo, VA number with **Copy**, amount with Copy.
  - *QRIS:* QR image + "Download QR".
  - *E-wallet / redirect:* **Pay Now** button to the gateway checkout URL.
  - *Instructions:* accordion (ATM / m-banking / internet banking).
- **Status handling:** poll `payments.status` every 5 s (stop on terminal states or after tab hidden). Transitions:
  - `paid` → success state ("Payment received — we're preparing your order"), CTA **View Order**.
  - `expired` / `failed` → message + **Buy Again** (re-adds items to cart).
  - `unpaid` / `pending` → keep the page.
- **Never** mark anything paid on the client; the UI reflects only server state.

### 8.10 Order history — `orders.index` (PRD §18)

- **Data:** the user's orders, newest first, paginated.
- **Filters:** tabs — All · To Pay · Processing · Shipped · Completed · Cancelled (mapped to order/payment status).
- **Order card:** order number, date, first item thumbnails (+n more), total, **payment badge** and **order badge**, actions (View Detail, Pay Now if payable, Track if shipped).
- **States:** empty per tab, skeleton, pagination.

### 8.11 Order detail & tracking — `orders.show` (PRD §16, §17, §18)

- **Sections:**
  1. Header — order number, placed date, both badges, action buttons.
  2. **Status stepper:** Pending → Processing → Packed → Shipped → Completed (Cancelled replaces the stepper with a red notice).
  3. Items — product, variant, qty, snapshot price, subtotal; **Write Review** per item when completed and not yet reviewed.
  4. Shipping — courier, service, estimated delivery, **tracking number (Copy)**, shipped/delivered timestamps, simple timeline.
  5. Address (from `address_snapshot`).
  6. Payment — method/channel, paid at, status.
  7. Totals — subtotal, discount (with `voucher_code`), shipping, grand total.
- **Actions (conditional):**

| Action | Condition |
|--------|-----------|
| Pay Now | payment `unpaid`/`pending` and not expired |
| Cancel Order | order `pending` and payment not `paid` (confirm modal + optional reason) |
| Confirm Received | order `shipped` (or shipment `delivered`) |
| Write Review | order `completed` and the item not yet reviewed |
| Buy Again | any finished order |
| Contact CS | always → chat prefilled with the order number |

### 8.12 Review & rating — `reviews.create` (PRD §19)

- **Entry:** from the order detail (completed orders only).
- **Form:** product header (image, name, variant), **star input** (keyboard-accessible, 1–5), comment (textarea, 10–1000 chars, counter), optional **photo** (preview, remove, ≤ 2 MB).
- **After submit:** "Thanks! Your review will appear after moderation" (`is_approved = false` by default). The button changes to "Reviewed".
- **Display (product detail):** only approved reviews; summary bars; photo thumbnails open a lightbox.
- **Rule:** one review per product per order; cannot review when not purchased or not completed.

### 8.13 Customer service chat — `chat.index` (PRD §20)

- **Data:** the customer's open `chat_conversation` (created on first message) and `chat_messages`.
- **UI:** header (status "We usually reply within a few hours"), message list (customer right / admin left, timestamps, read ticks from `read_at`), composer (textarea, attach image, send), **topic chips** to start (Product / Order / Payment / Shipping).
- **Interactions:** poll `chat.messages?after_id=` every 5 s while the tab is visible; Enter to send, Shift+Enter newline; optimistic bubble with "sending/failed-retry"; auto-scroll unless the user scrolled up; upgrade to Laravel Reverb/Echo later without UI changes.
- **Entry points:** floating chat button on all pages, "Contact CS" on orders, footer link.
- **Closed conversation:** composer replaced by "Start a new conversation".

### 8.14 Notifications (PRD §21, customer-visible part)

- **Bell dropdown:** latest 5, unread dot, "Mark all as read", "View all".
- **Page:** list grouped by day; types — registration, order created, payment successful, order processing, order shipped, order completed. Each links to the related order.
- Email/WhatsApp templates are backend work; the frontend only renders in-app notifications (database channel).

### 8.15 Profile — `account.profile` (PRD §22)

- **Account layout:** sidebar — Profile · Orders · Wishlist · Addresses · Chat · Notifications · Logout.
- **Profile form:** avatar (upload + preview + remove), name, email (re-verification notice if changed), phone.
- **Password form:** current, new, confirmation.
- **Overview cards:** recent orders, default address, wishlist count.
- **Danger zone:** none for v1.

### 8.16 Social media section (PRD §29)

- Config-driven (`config/brand.php`): Instagram/TikTok handles, URLs, and a curated array of 6–8 tiles (`image`, `url`, `platform`). Hover reveals a platform icon; CTA buttons "Follow on Instagram / TikTok".
- No third-party embeds in v1 (performance + privacy). Live feeds are a later enhancement.

### 8.17 SEO (PRD §28)

- `<x-seo :title :description :image :canonical>` partial in `layouts.app`.
- Slugs: `/products/{slug}`, `/categories/{slug}`; semantic landmarks (`header`, `nav`, `main`, `section`, `article`, `footer`), one `h1` per page.
- Open Graph + Twitter card; JSON-LD `Product`, `BreadcrumbList`, `Organization`.
- `sitemap.xml` (home, categories, active products), `robots.txt` (disallow `/cart`, `/checkout`, `/account`, `/admin`).
- Listing pages with filters: `noindex,follow` + canonical to the base URL; `rel=prev/next` not required.

### 8.18 System pages

404 (search box + popular categories), 403, 419 (session expired → reload), 429, 500, 503 (maintenance) — all on-brand.

---

## 9. Backend Seams the Frontend Needs

Build these as thin, testable layers so the PRD Phase 2 integrations drop in without touching views.

```php
interface ShippingService   { public function options(Address $address, Cart|array $items): array; }
interface PaymentGateway    { public function channels(): array;
                              public function createTransaction(Order $order, string $channel): Payment; }
interface RegionService     { public function provinces(): array; public function cities(string $province): array;
                              public function districts(string $city): array; }
```

- `FakeShippingService` returns JNE/J&T/SiCepat-like options with deterministic costs and ETAs.
- `FakePaymentGateway` returns a VA number, QR URL, and expiry (+24 h) and lets a dev-only route simulate `paid`.
- Bind real vs fake in `AppServiceProvider` by `config('services.*.driver')`.
- Seeders create: 1 admin, 2 customers, 5 categories, 24+ products with 1–6 variants each (mixed stock incl. 0 and ≤ 10), 3–5 images per product, orders in every status, reviews (approved/pending), vouchers (valid/expired/limit-reached), 2 promotions.

### 9.1 AJAX contracts

```
POST /cart/items            {product_variant_id, quantity}
  → 200 {count, subtotal, item:{id, quantity, subtotal}}   | 422 {message, errors}
PATCH /cart/items/{id}      {quantity}
  → 200 {item:{...}, summary:{count, subtotal, discount, total}} | 422 {message, max}
POST /wishlist/toggle       {product_id}
  → 200 {wishlisted: bool, count}
POST /checkout/voucher      {code}
  → 200 {voucher:{code, name}, summary:{subtotal, discount, shipping, total}} | 422 {message}
POST /checkout/shipping-options {address_id}
  → 200 {options:[{id, courier, service, etd, cost}]}
GET  /orders/{no}/payment/status
  → 200 {payment_status, order_status, paid_at, expired_at}
GET  /account/chat/messages?after_id=123
  → 200 {messages:[{id, sender_id, is_mine, message, attachment_url, read_at, created_at}], conversation:{status}}
```

All 422/409 responses use `{message, errors?}`; the frontend surfaces `message` in a toast or inline.

---

## 10. Accessibility

- Semantic HTML, visible `:focus-visible` ring (gold, 2 px offset), skip-to-content link.
- Forms: `<label for>`, `aria-describedby` for hints/errors, `aria-invalid`, `autocomplete` tokens (`name`, `email`, `tel`, `street-address`, `new-password`).
- Variant selector = `radiogroup` with arrow-key navigation; star input = `radiogroup`; modals/drawers trap focus, close on `Esc`, restore focus.
- Live regions: `aria-live="polite"` for toasts, cart count, payment status.
- Touch targets ≥ 44 × 44 px; contrast ≥ 4.5:1; no information by color alone (badges carry text).
- Glass surfaces keep an opaque fallback; images have meaningful `alt` (`product_images.alt_text` → fallback to product name).

## 11. Performance Budget (PRD §32)

- Lighthouse mobile: Performance ≥ 85, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95.
- LCP image on landing/detail: `fetchpriority="high"`, no lazy; all other images lazy with explicit dimensions (CLS < 0.1).
- JS: Alpine + page scripts only; split page scripts via Vite dynamic import; total ≤ 90 KB gz on first load.
- Eager-load relations (`with`, `withMin`, `withAvg`, `withCount`) — no N+1 on listing/cart/orders; paginate everything; add the DB indexes from `DB.md §29`.
- Avoid heavy `backdrop-filter` stacking: max 2 blurred layers in view at once; no blur on scrolling lists of cards (use semi-opaque fill instead on the product grid).

---

## 12. Implementation Phases

Frontend-first order, mapped to PRD phases. Each task is done only when it meets the Definition of Done in §13.

### F0 — Foundation *(PRD Phase 1)*
- [ ] Laravel 13 project, Breeze (Blade), Vite, Tailwind, Alpine, fonts.
- [ ] Design tokens + `glass` utilities (§3).
- [ ] Migrations/models/relations from `DB.md` for tables used by the customer app; factories + seeders (§9).
- [ ] Helpers: `rupiah()`, `Swatches`, status label maps, stock-status methods on `ProductVariant`/`Product`.
- [ ] Service interfaces + fake implementations.

### F1 — Shell & components *(Phase 1)*
- [ ] Layouts (§5), navbar, mobile menu, footer, toast, modal, drawer, skeleton, empty-state.
- [ ] `ui/*` and `shop/*` components with a hidden `/_styleguide` route (local only) to review them.

### F2 — Auth *(Phase 1)*
- [ ] Restyle Breeze pages; phone field; intended-URL redirect; role-based redirect.

### F3 — Landing *(Phase 1)*
- [ ] All sections of §8.1 with seeded data and scroll reveal.

### F4 — Catalog & detail *(Phase 1)*
- [ ] Listing + filters + sort + pagination + search suggest.
- [ ] Product detail with gallery, variant logic, reviews list, related products, SEO/JSON-LD.

### F5 — Cart & wishlist *(Phase 1 + 3)*
- [ ] Cart page, mini-cart drawer, AJAX endpoints, stock rules.
- [ ] Wishlist page, heart toggle everywhere, move-to-cart modal.

### F6 — Address & checkout *(Phase 1 + 3)*
- [ ] Address CRUD (account + modal).
- [ ] Checkout steps, shipping options (fake), voucher apply/remove, promotion line, place order, stock conflict handling.

### F7 — Payment & orders *(Phase 2)*
- [ ] Payment page (all channel variants) + polling.
- [ ] Order history, order detail, stepper, tracking, cancel, confirm received, buy again.

### F8 — Review & profile *(Phase 3)*
- [ ] Review form + display + moderation notice.
- [ ] Profile, password, avatar, account layout.

### F9 — Chat, notifications, social *(Phase 3 + 4)*
- [ ] Chat page + floating button + polling.
- [ ] Notification bell + page.
- [ ] Social section + brand config.

### F10 — Hardening
- [ ] SEO pass, sitemap, robots, error pages.
- [ ] Accessibility audit (keyboard + screen reader smoke test).
- [ ] Performance pass (images, N+1, JS size).
- [ ] Cross-browser: Safari iOS, Chrome Android, Chrome/Firefox/Safari desktop; test at 360, 390, 768, 1024, 1440 px.
- [ ] Feature tests (§13) green.

---

## 13. Testing & Definition of Done

### 13.1 Definition of Done (per feature — from PRD §38)

1. Needed tables/migrations exist and seed correctly.
2. Models and relationships are correct.
3. FormRequest validation exists and errors render in the UI.
4. Authorization/policies applied (ownership, role).
5. UI is responsive at 360 / 768 / 1280 px.
6. Loading, empty, error, and success states implemented.
7. Keyboard and screen-reader basics pass (§10).
8. Tests for the business logic touched.
9. No console errors or failed network calls in the main flow.

### 13.2 Automated tests (Pest or PHPUnit)

| Area | Cases |
|------|-------|
| Pages | Every public page returns 200; every auth page redirects guests to login |
| Catalog | Search, each filter, each sort returns the expected order; inactive products hidden |
| Stock | Status thresholds (11 → In Stock, 10 → Low, 0 → Out); price fallback `variant.price ?? product.price` |
| Cart | Add increments instead of duplicating; quantity cannot exceed stock; other users' items inaccessible |
| Wishlist | Toggle is idempotent; unique `(wishlist_id, product_id)` |
| Checkout | Totals recomputed server-side; voucher rules (expired, min purchase, usage limit, per-user limit); stock conflict returns per-item error; snapshots stored |
| Payment | Page only accessible by the owner; status endpoint returns server state |
| Orders | Cancel allowed only for pending + unpaid; confirm-received only for shipped |
| Review | Only for completed orders containing the product; one per product per order; unapproved hidden |
| Chat | Only own conversation; attachment validation |

### 13.3 Manual QA — acceptance mapping (PRD §36, Customer)

| Acceptance item | Verified in |
|-----------------|-------------|
| Register / Login | §8.2 |
| View / search / filter products | §8.3 |
| Choose variant, see stock | §8.4 |
| Add to cart | §8.4, §8.6 |
| Checkout, choose address, choose shipping | §8.8 |
| Make payment | §8.9 |
| See order status / history | §8.10, §8.11 |
| Give review | §8.12 |

---

## 14. Gaps & Decisions

Items where the PRD and DB documents leave something open. Defaults are chosen so work is not blocked; confirm or change them.

| # | Gap | Default decision |
|---|-----|------------------|
| D1 | `carts.user_id` is required, so guests cannot hold a cart | Guests are redirected to login when adding to cart (selection remembered via `intended`). Optional later: session cart merged on login |
| D2 | **Banners** are in PRD §24 but there is no `banners` table in `DB.md` | Add a `banners` migration (`title, subtitle, image, cta_label, cta_url, placement, sort_order, is_active, starts_at, ends_at`) or fall back to `config/storefront.php` |
| D3 | **Notifications** have no table in `DB.md` | Use Laravel's `notifications` table (`php artisan make:notifications-table`) |
| D4 | PRD §22 has **profile photo**, but `users` has no column | Add `profile_photo_path` (nullable) |
| D5 | Stock reduced at order creation or at payment? (PRD §9 says "Reserved / Reduced" on order creation) | Reserve at order creation; release on cancel/expiry (backend job). The UI shows live stock and blocks on conflict |
| D6 | **COD** is optional in PRD §15 but `payments` is Tripay-shaped | Treat COD as a channel with no Tripay reference (`reference` nullable) and order status `pending` → `processing` set by admin |
| D7 | Rating, popularity and best-seller counts are not stored | Compute with `withAvg`/`withCount`/`withSum`; cache for landing |
| D8 | Region data (province/city/district) source | `RegionService` abstraction; text inputs fallback |
| D9 | Discount breakdown (voucher vs automatic promotion) — `orders` has one `discount_amount` and only `voucher_code` | Show a single "Discount" line (with voucher code if any); optional `discount_breakdown` JSON later |
| D10 | Review uniqueness is not enforced in DB | Add unique `(user_id, product_id, order_id)` |
| D11 | Variant images are not modeled | Gallery stays product-level; selecting a color does not swap images in v1 |
| D12 | Customer-initiated cancel/return not in PRD | Cancel allowed for unpaid pending orders only; returns out of scope |
| D13 | Language of UI copy | English labels as in PRD; wrap strings in `__()` so Indonesian can be added without refactor |
