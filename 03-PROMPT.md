# Prompt Pack — Kembang Hijab Customer Storefront

Ready-to-paste prompts for an AI coding agent (Claude Code, Cursor, Copilot, etc.) to build the **customer-facing frontend** described in `PRD.md` and `DB.md`, following `Implementation.md`.

## How to use

1. Put `PRD.md`, `DB.md`, `DESIGN.md`, and `Implementation.md` in the repo root (or `/docs`) so the agent can read them.
2. Start a fresh session and paste **Prompt 0 — Master Context** once. Keep it as the project's system/rules file if your tool supports it (`AGENTS.md`, `.cursorrules`, etc.).
3. Run **Prompts 1 → 17 in order**, one per session or one per task. Each prompt lists what to read, what to build, and how to verify.
4. After each prompt, run the **Review prompt (R)** and fix findings before moving on.
5. If the agent drifts, use the **Fix prompt (F)**.

> Prompts say "read X" instead of pasting the docs, to save tokens. If your tool cannot read files, paste the referenced sections.

---

## Prompt 0 — Master Context (paste once)

````
You are a senior Laravel + Tailwind front-end engineer building the customer-facing storefront of "Kembang Hijab", a single-brand hijab e-commerce site.

SOURCES OF TRUTH
- PRD.md = product requirements. DB.md = database schema (source of truth for data). Implementation.md = detailed plan, page specs, routes, components, and decisions (§14 "Gaps & Decisions" are the default decisions to follow).
- If documents conflict, DB.md wins for data, PRD.md wins for behavior. If something is still unclear, pick the Implementation.md default, state your assumption in one line, and continue. Do not stop to ask unless blocked.

SCOPE
- Build ONLY the customer view. Do NOT build the Filament admin panel.
- Do NOT integrate real Tripay / shipping / WhatsApp. Code against interfaces (ShippingService, PaymentGateway, RegionService) and ship Fake* implementations plus seeders so every page works with realistic data.

STACK
- Laravel 13, PHP 8.3+, MySQL, Blade, Tailwind CSS, Vite, Alpine.js, Eloquent, Laravel Breeze (Blade) for auth.
- No React/Vue/Livewire/Inertia. No jQuery. Minimal JS: Alpine + fetch.

DESIGN
- "Premium + Minimal + Elegant Glassmorphism", mobile-first.
- Palette: cream #FBF7F0, ivory #FFFDFA, beige #EFE6D8, blush #F3D9D6, dusty #D9A8A5, lilac #D9CFEA, cocoa #5B4636 (text), cocoa-soft #8A7261, gold #C9A24D. Use at most two accents per viewport.
- Fonts: Cormorant Garamond (headings), Plus Jakarta Sans (body), self-hosted.
- Glass = translucent white, backdrop blur, 1px white/60 border, rounded-3xl, soft brown shadow. Always provide an opaque fallback and respect prefers-reduced-motion.
- Lots of whitespace, subtle motion only.

ENGINEERING RULES
1. Every UI atom is a Blade component under resources/views/components/{ui,shop,cart,account,chat,layout}. No copy-pasted markup.
2. Controllers are thin; business rules live in Services / Actions / Models. Validation in FormRequests. Authorization in Policies.
3. Never trust client data: recompute prices/totals/stock on the server. Never mark payment as paid from the frontend.
4. Escape all user content with {{ }}. @csrf on every form; send X-CSRF-TOKEN on fetch.
5. Every page needs loading (skeleton), empty, error, validation, and success states.
6. Accessibility: semantic HTML, labels, focus-visible, keyboard operable variant/star pickers, focus-trapped modals, aria-live for toasts.
7. Performance: eager-load relations (no N+1), paginate, lazy-load images with width/height, no heavy blur stacking.
8. Money via rupiah() helper ("Rp 1.250.000"); timezone Asia/Jakarta; UI copy English wrapped in __().
9. Stock lives on product_variants. Status: >10 In Stock, 1–10 Low Stock, 0 Out of Stock. Price = variant.price ?? product.price. Order status and payment status are separate and shown as two badges.
10. Write feature tests for business logic you touch (Pest or PHPUnit, whichever the project already uses).

WORKING STYLE
- Work in small, verifiable steps. After each task: run the app/tests, list files created/changed, list anything deferred, and give a 3-line manual test script.
- Prefer boring, readable code. No unrequested features, no dead code, no TODO placeholders in finished work.
- Do not rewrite files unrelated to the current task.

Reply "Ready" and wait for the next prompt.
````

---

## Prompt 1 — Foundation (F0)

````
TASK: Project foundation.

READ: Implementation.md §2, §3, §4, §9, §12 (F0); DB.md §4–§23, §26–§30.

DO:
1. Install/configure Laravel Breeze (Blade), Tailwind, Alpine, Vite, and self-hosted fonts (@fontsource/cormorant-garamond, @fontsource/plus-jakarta-sans).
2. Put the design tokens and .glass / .glass-strong utilities from Implementation.md §3.3 into resources/css/app.css. Add the gradient page background.
3. Create migrations, models, relationships, casts, fillables, indexes, and unique constraints for the tables the customer app needs: users (+ role, + profile_photo_path), categories, products, product_variants, product_images, addresses, carts, cart_items, wishlists, wishlist_items, orders, order_items, payments, payment_webhooks, shipments, vouchers, promotions, reviews (+ unique user_id/product_id/order_id), chat_conversations, chat_messages, and Laravel's notifications table. Follow DB.md §26 order. Use enums (PHP backed enums) for order/payment/shipment status and user role.
4. Add model helpers: ProductVariant::stockStatus(), Product::minPrice(), Product::effectivePrice logic, Product scopes (active, featured, search, priceBetween, inStock, sortBy), approvedReviews relation, Order/Payment status label+badge maps.
5. Add app/Support/helpers.php (rupiah(), status label helpers), config/swatches.php (color name → hex), config/brand.php (name, tagline, social handles/URLs, 8 social tiles), config/storefront.php (COD enabled flag, promo copy).
6. Create contracts + fakes: ShippingService/FakeShippingService, PaymentGateway/FakePaymentGateway (VA number, QR url, expiry +24h, dev-only route to simulate "paid"), RegionService/FakeRegionService. Bind via config('services.*.driver').
7. Factories + DatabaseSeeder: 1 admin, 2 customers (with addresses, cart, wishlist), 5 hijab categories, 24+ products with 1–6 variants (include stock 0 and ≤10 cases), 3–5 images each (placeholder images stored locally), orders in every status with payments/shipments, approved and pending reviews, vouchers (valid, expired, limit reached, min-purchase), 2 promotions.
8. Set timezone Asia/Jakarta.

ACCEPTANCE:
- php artisan migrate:fresh --seed succeeds.
- Model tests: stock status thresholds, price fallback, relationships, unique constraints.
- npm run build succeeds.
````

---

## Prompt 2 — Layouts & UI component library (F1)

````
TASK: Layouts and shared Blade components.

READ: Implementation.md §3, §5, §7, §10; PRD.md §4.

DO:
1. Layouts: layouts/app, layouts/account, layouts/checkout, layouts/auth (see §5). app layout includes: SEO partial (<x-seo>), skip-to-content link, sticky glass navbar, mobile menu drawer, footer, toast host, mini-cart drawer slot, floating chat button.
2. Navbar: logo, Shop, Categories (mega-menu desktop / accordion mobile), search overlay (live suggestions from search.suggest), wishlist + cart counters (Alpine stores), account menu or Login/Register, notification bell (logged in).
3. Components (all with props, slots, and variants): ui/button (primary, secondary, ghost, gold; sizes; loading state), input, select, textarea, checkbox, radio-card, badge, modal, drawer, toast, skeleton, empty-state, breadcrumb, pagination (custom glass styling), icon (Lucide inline SVG), qty-stepper, countdown, tabs, accordion, section-heading, glass-card; shop/product-card, price, rating-stars, rating-input, stock-badge, wishlist-button, category-tile, variant-selector; account/order-status-badge, payment-badge.
4. Alpine stores: toast, cart (count/subtotal), wishlist (set of product ids), ui (drawers/modals). lib/http.js wrapper around fetch with CSRF, JSON handling, and 422 error normalization.
5. Local-only route /_styleguide that renders every component in all variants/states on both light backgrounds and over the gradient, for visual review.

ACCEPTANCE:
- Styleguide renders with no console errors at 360px and 1280px.
- All interactive components are keyboard operable; modal/drawer trap focus and close on Esc.
- No component uses hard-coded colors outside the tokens.
````

---

## Prompt 3 — Authentication pages (F2)

````
TASK: Customer authentication UI.

READ: PRD.md §6, §31; Implementation.md §8.2.

DO:
1. Restyle Breeze views: register (name, email, phone, password, confirmation), login (email, password, remember me), forgot-password, reset-password, verify-email. Use layouts/auth (split layout; brand image hidden below lg) and the ui components.
2. Add phone to registration (validation + normalization) and to the user model/factory.
3. Features: show/hide password, password strength hint, inline errors with aria-describedby, resend-verification cooldown (60s), neutral message on forgot-password.
4. Redirects: honor the "intended" URL (e.g., back to the product/checkout); after register go back to where the user came from else "/". Role handling: admin → /admin, customer → storefront; customers must never reach the Filament panel.
5. Rate-limit login/register/forgot-password.
6. Feature tests: register, login, logout, intended redirect, role redirect, throttling.

ACCEPTANCE: PRD §36 customer items "register" and "login" pass; pages look correct at 360px and 1280px.
````

---

## Prompt 4 — Landing page (F3)

````
TASK: Landing page (home).

READ: PRD.md §5.1, §29; Implementation.md §8.1, §8.16; DB.md §5, §6, §21.

DO:
Build pages/home.blade.php with these sections in order: hero (headline, subcopy, CTAs "Shop Now" and "Explore Collection", hero image with floating glass mini-cards), category tiles, featured products, promotional banner (active promotion/voucher teaser from DB or config), new arrivals, best sellers, brand story (CTA "Discover More"), customer reviews carousel (approved reviews, rating ≥ 4), Instagram/TikTok section (from config/brand.php, with Follow CTAs), optional newsletter strip (UI only), footer.

Rules:
- A section with no data is not rendered.
- Use a HomeController + query class; eager-load, cache best sellers/new arrivals for 10 minutes.
- Horizontal snap-scroll carousels on mobile, grids on desktop; scroll-reveal animation (respect reduced motion).
- Hero image is the LCP element: fetchpriority="high", not lazy.

ACCEPTANCE: Lighthouse mobile ≥ 85 performance on seeded data; no layout shift; all CTAs link to real routes.
````

---

## Prompt 5 — Product listing, search, filters (F4a)

````
TASK: Product listing + category pages + search.

READ: PRD.md §7, §9; Implementation.md §7.1–7.3, §8.3, §9.1; DB.md §6, §7, §29.

DO:
1. Routes products.index, categories.show, search.suggest.
2. Query: active products only; withMin variant price, stock sum, withAvg/withCount approved reviews, popularity (sum of order_items.quantity), wishlist state for the current user (single query, no N+1).
3. Filters via GET params: q, category, min_price, max_price, availability=in_stock, sort ∈ {newest, oldest, price_asc, price_desc, popular, rating}, page. Validate with a FormRequest; ignore invalid values safely.
4. UI: heading + result count, search field, sort select, filter panel (sidebar on lg+, bottom-sheet drawer on mobile) with category checkboxes, price min/max + quick chips, in-stock switch, active-filter chips, Clear all, product grid (2/3/4 cols), custom pagination preserving the query string.
5. Product card per PRD §7: image, name, category, price (+ strikethrough + discount %), rating, stock badge, wishlist heart. Hover reveals the second image on desktop. Out-of-stock cards are dimmed.
6. Wishlist heart: optimistic toggle; guests are sent to login and returned.
7. Skeleton + empty state ("No products match your filters").
8. SEO: filtered/sorted/paginated URLs get noindex,follow and canonical to the base URL.
9. Tests: each filter and sort, availability, inactive products hidden, N+1 guard (assert query count).
````

---

## Prompt 6 — Product detail (F4b)

````
TASK: Product detail page.

READ: PRD.md §8, §9; Implementation.md §7.1–7.3, §8.4, §8.17; DB.md §6–§8, §21.

DO:
1. Route products.show (slug). 404 for inactive products.
2. Gallery: ordered by sort_order with primary first; main image + thumbnails, hover zoom (desktop), swipe (mobile), lightbox with keyboard navigation.
3. Purchase panel: breadcrumb, name, category, rating (links to reviews), price block (compare_price strikethrough + discount %), short description, Color swatches (config/swatches.php), Size pills, stock badge, quantity stepper, Add to Cart, Buy Now, Wishlist toggle.
4. Variant logic in Alpine using a JSON map of active variants: selecting color/size enables only valid combos; out-of-stock combos disabled and struck through; price, stock label, and stepper max update live; buttons disabled until a valid in-stock combo is chosen; a single-variant product is auto-selected; stepper clamps to min(stock, remaining capacity vs. quantity already in cart).
5. Add to Cart → POST cart.items.store; toast + counter bump + open mini-cart. Buy Now → POST buy-now. Guests → login with intended URL.
6. Below the fold: tabs/accordion (Description, Material & Care, Reviews). Reviews: approved only, summary bars (5→1), paginated list, photo thumbnails → lightbox. Related products (same category).
7. Mobile sticky bottom bar (price + Add to Cart).
8. SEO: title, meta description, canonical, Open Graph, JSON-LD Product (+ offers + aggregateRating when reviews exist) and BreadcrumbList.
9. Tests: variant availability payload, 404 for inactive, approved-only reviews, rating math.
````

---

## Prompt 7 — Cart + mini-cart (F5a)

````
TASK: Shopping cart.

READ: PRD.md §11, §9, §13 (automatic promotions); Implementation.md §8.6, §9.1; DB.md §10, §11, §28.

DO:
1. CartService: getOrCreate(user), add(variant, qty) (merge existing item, never duplicate a variant, clamp/422 when exceeding stock), update(item, qty), remove(item), summary() including subtotal, total items, and the best applicable automatic Promotion (percentage/fixed with minimum purchase) plus a "spend X more" hint.
2. Routes/controllers: cart.index, cart.summary (JSON), cart.items.store/update/destroy (JSON), buy-now. Policy: users can only touch their own cart items.
3. cart/index page: item rows (image, name link, "Color · Size", unit price, qty stepper, subtotal, remove), sticky glass summary (items, subtotal, promo hint, Proceed to Checkout, Continue Shopping). Debounced (400ms) optimistic quantity update with rollback on error; remove with Undo toast.
4. Flags: "Only n left" when qty = stock; "No longer available" for inactive/out-of-stock variants (blocks checkout); "Updated price" chip when price changed.
5. Mini-cart drawer in the layout: last items, subtotal, View Cart / Checkout; opens from navbar and after Add to Cart. Navbar counter driven by the cart store.
6. Empty state with CTA.
7. Tests: add/merge, stock clamp, ownership, promotion calculation, unavailable variant handling.
````

---

## Prompt 8 — Wishlist (F5b)

````
TASK: Wishlist.

READ: PRD.md §10; Implementation.md §8.5; DB.md §12, §13.

DO:
1. WishlistService: toggle(product) idempotent (unique wishlist_id + product_id), list(), remove().
2. Routes: wishlist.index, wishlist.toggle (JSON), wishlist.move.
3. Wishlist page: grid of product cards with Remove (×) and "Move to Cart". If the product has exactly one in-stock variant → add directly; otherwise open a quick-select modal (color/size/qty) then add. After a successful move, remove from the wishlist with an Undo toast. Out-of-stock products show a disabled "Out of stock" button.
4. Hydrate the wishlist Alpine store on page load so hearts render correctly everywhere (listing, detail, home).
5. Empty state: "Your wishlist is empty" + Shop Now.
6. Tests: toggle idempotency, ownership, move-to-cart stock rules.
````

---

## Prompt 9 — Address management (F6a)

````
TASK: Address management (account page + reusable modal).

READ: PRD.md §12; Implementation.md §8.7; DB.md §9.

DO:
1. AddressController CRUD + PATCH default. FormRequest: recipient_name, phone (^(\+62|62|0)8[1-9][0-9]{6,11}$), label, province, city, district, postal_code (5 digits), address, is_default.
2. account/addresses page: address cards (label badge, Default badge, Edit, Delete w/ confirm, Set as default) + Add address.
3. <x-account.address-form> used in a full page AND a modal (for checkout). Label chips: Rumah / Kantor / Kos / custom. Province → City → District dependent selects through RegionService, with text-input fallback.
4. Rules: first address becomes default; only one default per user (transaction); deleting the default promotes the most recent remaining address.
5. layouts/account with sidebar (desktop) / scrollable tabs (mobile).
6. Policy + tests for ownership and the default-address rule.
````

---

## Prompt 10 — Checkout (F6b)

````
TASK: Checkout and order placement.

READ: PRD.md §13, §14, §16, §17; Implementation.md §8.8, §9, §9.1; DB.md §14, §15, §18, §28, §31.

DO:
1. CheckoutService: build(cart or buy-now item) → totals {subtotal, promotion discount, voucher discount, shipping, total}; VoucherService.validate(code, user, subtotal) covering active window, is_active, minimum_purchase, usage_limit, usage_limit_per_user, maximum_discount, percentage vs fixed; PromotionService picks the best active promotion. All computed on the server on every change.
2. Routes: checkout.index, checkout.voucher.apply/remove (JSON), checkout.shipping (JSON), checkout.store.
3. checkout/index (layouts/checkout): accordion steps — Address (radio cards + add-address modal), Shipping (options from ShippingService after address selection, with skeleton/error+retry), Voucher (apply/remove chip, server error messages), Payment (channels from PaymentGateway grouped by type; COD only if enabled in config/storefront.php), Review (recap + optional note ≤200 chars). Sticky Order Summary on desktop; collapsed summary on mobile showing the total.
4. Place Order: disabled until address, shipping, and payment are valid; double-submit guard with an idempotency token. In one DB transaction: create order (order_number, address_snapshot JSON, totals, voucher_code, notes, placed_at, status pending), order_items with snapshots (product_name, variant_name, sku, price, quantity, subtotal), shipment (courier, service, estimated_delivery, shipping_cost, status pending), payment via PaymentGateway::createTransaction, decrement/reserve variant stock with row locks, increment voucher used_count, clear purchased cart items (not in Buy Now mode).
5. Stock conflict → rollback, return to checkout with per-item error ("Only 2 left for Cream / 115×115") and recomputed totals.
6. Redirect to payments.show (or orders.show for COD).
7. Tests: totals math; each voucher rule; stock conflict rollback; snapshots persisted; idempotency; Buy Now leaves the cart untouched; users cannot check out other users' addresses.
````

---

## Prompt 11 — Payment page (F7a)

````
TASK: Payment page and status polling.

READ: PRD.md §15, §16; Implementation.md §8.9; DB.md §16, §17.

DO:
1. Routes payments.show and payments.status (JSON) with an owner policy.
2. Page (layouts/checkout): order number, large amount (copy button), countdown to payments.expired_at, then a method block that adapts to the channel using payments.raw_response from the fake gateway: Virtual Account (bank logo, VA number + Copy), QRIS (QR image + Download), Redirect/e-wallet ("Pay Now" button), plus an instructions accordion (ATM / m-banking / internet banking).
3. Alpine poller: GET payments.status every 5s; pause when the tab is hidden; stop on terminal state. Transitions: paid → success state + "View Order"; expired/failed → message + "Buy Again" (re-add items to cart); unpaid/pending → stay.
4. The UI must never set "paid" locally; it reflects only the server response.
5. Dev-only route/button (local env) to simulate the fake gateway marking payment paid and order processing.
6. Tests: owner-only access, status endpoint payload, expired countdown rendering.
````

---

## Prompt 12 — Order history & tracking (F7b)

````
TASK: Order history, order detail, and tracking.

READ: PRD.md §16, §17, §18; Implementation.md §7.4, §8.10, §8.11; DB.md §14–§18.

DO:
1. orders.index with status tabs (All, To Pay, Processing, Shipped, Completed, Cancelled), paginated order cards: order number, date, item thumbnails (+n), total, payment badge AND order badge, quick actions.
2. orders.show: header with both badges; status stepper (Pending → Processing → Packed → Shipped → Completed; Cancelled variant); items from snapshots; shipping block (courier, service, ETA, tracking number + Copy, shipped/delivered times); address from address_snapshot; payment block; totals (subtotal, discount + voucher_code, shipping, grand total).
3. Conditional actions (policy-checked server-side too): Pay Now, Cancel Order (pending + not paid; confirm modal; releases stock), Confirm Received (shipped → completed), Write Review (completed + not yet reviewed), Buy Again (re-add available variants to cart and report skipped ones), Contact CS (opens chat with the order number prefilled).
4. Empty states per tab; skeletons.
5. Tests: tab filtering, ownership, each action's allowed/denied conditions, stock release on cancel, Buy Again with an unavailable variant.
````

---

## Prompt 13 — Review & rating (F8a)

````
TASK: Reviews.

READ: PRD.md §19; Implementation.md §8.12, §8.4 (display); DB.md §21, §28.

DO:
1. Routes reviews.create/store, nested under the owned order and product.
2. Form: product header (image, name, variant), accessible star input (radiogroup, keyboard 1–5), comment (10–1000 chars, live counter), optional photo (jpg/png/webp ≤ 2MB, client preview + remove). Server validation mirrors client rules; store the image on the public disk with a safe generated name.
3. Rules: only the buyer; only when the order is completed and contains the product; one review per user+product+order; saved with is_approved = false. After submit show "Thanks! Your review will appear after moderation."
4. Wire the display on product detail and landing: approved reviews only, summary bars, photo lightbox.
5. Tests: eligibility rules, duplicate prevention, upload validation, unapproved hidden, rating aggregate.
````

---

## Prompt 14 — Profile & account hub (F8b)

````
TASK: Customer profile.

READ: PRD.md §22; Implementation.md §8.15; DB.md §4.

DO:
1. account.profile: avatar upload/preview/remove (profile_photo_path), name, email (show re-verification notice when changed), phone; account.password: current/new/confirmation.
2. Overview cards at the top: recent orders, default address, wishlist count, quick links.
3. Complete layouts/account navigation: Profile, Orders, Wishlist, Addresses, Chat, Notifications, Logout.
4. Tests: update profile, change password (wrong current password rejected), avatar validation, email change resets verification.
````

---

## Prompt 15 — Customer service chat (F9a)

````
TASK: Customer service chat UI.

READ: PRD.md §20; Implementation.md §8.13, §9.1; DB.md §22, §23.

DO:
1. ChatController: index (page), messages GET (after_id polling) and POST (multipart). One open conversation per customer (create on first message). Policy: only own conversation. Validate message (required without attachment, ≤2000 chars) and attachment (jpg/png/webp ≤ 2MB). Rate-limit sending (20/min).
2. Page: header with expectation text, message list (customer right / admin left, timestamps, read ticks from read_at), composer (autosize textarea, attach image with preview, send), topic chips (Product / Order / Payment / Shipping) that prefill the first message. Support ?order={order_number} to prefill an order reference.
3. Behavior: poll every 5s while the tab is visible; Enter sends, Shift+Enter newline; optimistic bubble with sending/failed-retry; auto-scroll unless the user scrolled up; mark admin messages as read when the customer views them.
4. Floating chat button on every page (hidden on the chat page); closed conversation → "Start a new conversation".
5. Tests: ownership, validation, polling returns only newer messages, read receipts.
````

---

## Prompt 16 — Notifications, social section, system pages (F9b)

````
TASK: Notifications UI, social section polish, and error pages.

READ: PRD.md §21, §29; Implementation.md §8.14, §8.16, §8.18.

DO:
1. Database notifications for: registration, order created, payment successful, order processing, order shipped, order completed (create Notification classes with the database channel; mail channel stubs are fine). Fire them from the relevant events/listeners (queue-ready).
2. Navbar bell dropdown (latest 5, unread dot, Mark all read, View all) and notifications.index page grouped by day; each item links to its order. JSON mark-as-read endpoint.
3. Social section: finalize the Instagram/TikTok tiles and CTAs on landing and footer from config/brand.php; no third-party embeds.
4. On-brand error pages: 404 (search box + popular categories), 403, 419 (reload hint), 429, 500, 503.
5. Tests: notification created per event, mark-as-read ownership, error pages render.
````

---

## Prompt 17 — SEO, performance, accessibility hardening (F10)

````
TASK: Hardening pass.

READ: Implementation.md §8.17, §10, §11, §13.

DO:
1. SEO: finish <x-seo>, canonical/OG/Twitter tags, JSON-LD (Product, BreadcrumbList, Organization), /sitemap.xml (home, categories, active products), robots.txt (disallow /cart, /checkout, /account, /admin), one h1 per page, semantic landmarks.
2. Performance: add missing eager loads; assert max query counts on home, listing, detail, cart, orders; image dimensions + lazy loading + srcset where thumbnails exist; split page scripts with dynamic imports; verify total first-load JS ≤ 90KB gz; limit backdrop-blur layers.
3. Accessibility: keyboard-only walkthrough of the full purchase flow, focus management in modals/drawers, aria-live regions, contrast check on glass surfaces, touch targets ≥ 44px; fix everything found.
4. Responsive QA at 360, 390, 768, 1024, 1440px; fix overflow and spacing issues.
5. Produce QA.md: a checklist mapping every PRD §36 customer acceptance item to the route/page that satisfies it, plus Lighthouse scores for home, listing, detail, cart, checkout.

ACCEPTANCE: Lighthouse mobile — Performance ≥ 85, Accessibility ≥ 95, Best Practices ≥ 95, SEO ≥ 95 on public pages; the full flow Landing → Detail → Cart → Checkout → Pay → Track → Review works on seeded data.
````

---

## Prompt R — Review after each step

````
Review the work you just completed for the previous prompt. Do not add features. Check and report, then fix:

1. Requirements: list each requirement from the prompt and mark Done / Partial / Missing with file references.
2. Data & rules: stock thresholds, price fallback, snapshots, ownership checks, server-side recomputation.
3. States: loading, empty, error, validation, success exist on every new page.
4. Security: @csrf, escaped output, upload validation, policies, rate limits.
5. UI quality: uses only design tokens and shared components; no duplicated markup; looks right at 360px and 1280px; reduced-motion respected.
6. Accessibility: labels, focus order, keyboard use, aria-live.
7. Performance: N+1 queries, image sizes, JS added.
8. Tests: which ones were added, and do they pass?

Output: a short findings list ordered by severity, then fix all High and Medium items and re-run tests.
````

---

## Prompt F — Fix / course-correct

````
Stop adding new work. The current implementation has this problem:

<describe the problem, paste the error / URL / screenshot description>

Do this:
1. State the root cause in one or two sentences (read the code first; do not guess).
2. Make the smallest change that fixes it, without altering unrelated files.
3. Add or update a test that would have caught it.
4. Re-run the affected tests and the build, and report the results.
5. Check whether the same mistake exists elsewhere and list those spots (fix them only if trivial).
````

---

## Prompt D — Design polish (optional, run after Prompt 4 and again after Prompt 17)

````
Do a visual polish pass on <page/section> without changing behavior.

Goals: more breathing room (spacing scale 4/8/12/16/24/32/48/64/96), consistent radii and shadows, clear typographic hierarchy (display for H1/H2, sans for UI), gold used sparingly for primary CTA/ratings/focus accents, no more than two accent colors in view, subtle hover/enter motion, glass surfaces that stay legible over the gradient (text contrast ≥ 4.5:1).

Rules: change tokens/components first and let pages inherit; no inline styles; keep reduced-motion support; verify at 360px and 1280px and report before/after notes.
````

---

## Quick reference: prompt → deliverable

| Prompt | Delivers | PRD § |
|-------:|----------|-------|
| 0 | Master context / rules | – |
| 1 | DB, models, seeders, service seams | 30, 31 |
| 2 | Layouts + component library | 4 |
| 3 | Auth UI | 6 |
| 4 | Landing page | 5.1, 29 |
| 5 | Listing, search, filters | 7 |
| 6 | Product detail + variants | 8, 9 |
| 7 | Cart + mini-cart | 11 |
| 8 | Wishlist | 10 |
| 9 | Address management | 12 |
| 10 | Checkout + order placement + vouchers/promos | 13, 14 |
| 11 | Payment page | 15 |
| 12 | Order history + tracking | 16, 17, 18 |
| 13 | Reviews | 19 |
| 14 | Profile | 22 |
| 15 | Chat | 20 |
| 16 | Notifications, social, error pages | 21, 29 |
| 17 | SEO, performance, accessibility, QA | 28, 32, 36 |
