Siap bro. Aku buatkan **PRD (Product Requirements Document)** yang bisa langsung kamu jadikan acuan development untuk **toko online hijab single brand**. Aku sesuaikan dengan stack dan scope project yang sudah kamu tentukan: **Laravel 13 + Blade + Tailwind CSS + Filament 4 + MySQL**, dengan UI **premium, minimal, elegant Glassmorphism**.

# PRD — Hijab Single Brand E-Commerce

**Nama Project:** Hijab E-Commerce
**Nama E-commerce** Kembang Hijab
**Tipe:** Single Brand Online Store
**Platform:** Web Application
**Versi PRD:** 1.0
**Target:** Customer & Admin
**Tech Stack:** Laravel 13, PHP 8.3+, MySQL, Blade, Tailwind CSS, Vite, Eloquent ORM, Filament 4

---

## 1. Product Overview

### 1.1 Deskripsi

Aplikasi merupakan platform **e-commerce khusus satu brand hijab** yang memungkinkan customer membeli produk hijab secara online mulai dari melihat katalog, memilih varian, memasukkan produk ke keranjang, melakukan checkout, pembayaran, hingga memantau status pesanan.

Berbeda dengan marketplace, platform ini hanya menjual **produk milik satu brand**.

### 1.2 Tujuan Produk

Sistem dibuat untuk:

* Menjual produk hijab secara online.
* Mempermudah customer mencari dan membeli produk.
* Mengelola produk, kategori, varian, dan stok.
* Mengelola pesanan dan pembayaran.
* Menyediakan pengalaman belanja yang modern.
* Membantu admin mengontrol seluruh aktivitas toko.
* Menyediakan informasi pesanan secara real-time/terbarui.
* Membangun identitas digital untuk brand hijab.

---

# 2. Target User

## 2.1 Customer

Customer adalah pengguna yang membeli produk hijab melalui website.

Customer dapat:

* Register/login.
* Melihat produk.
* Mencari produk.
* Filter produk.
* Melihat detail produk.
* Memilih varian.
* Menambahkan wishlist.
* Menambahkan produk ke cart.
* Mengatur alamat.
* Checkout.
* Memilih metode pembayaran.
* Melihat status pembayaran.
* Melihat status pesanan.
* Melihat riwayat pesanan.
* Memberikan review.
* Menghubungi customer service.
* Mengelola profile.

## 2.2 Admin

Admin merupakan pengelola toko.

Admin dapat:

* Mengelola produk.
* Mengelola kategori.
* Mengelola varian.
* Mengelola stok.
* Mengelola customer.
* Mengelola admin.
* Mengelola pesanan.
* Mengelola pembayaran.
* Mengelola voucher.
* Mengelola promo.
* Mengelola pengiriman.
* Mengelola review.
* Mengelola customer service.
* Mengelola banner.
* Melihat dashboard dan laporan.

---

# 3. Product Goals

### Business Goals

1. Meningkatkan penjualan produk hijab secara online.
2. Mengurangi proses administrasi manual.
3. Mempermudah pengelolaan inventory.
4. Meningkatkan pengalaman customer.
5. Menyediakan data transaksi yang terstruktur.

### User Goals

Customer harus dapat:

> **Discover → Select → Cart → Checkout → Pay → Track → Review**

dengan proses yang sederhana.

---

# 4. UI/UX Requirements

## 4.1 Design Style

Website menggunakan:

**Premium + Minimal + Elegant Glassmorphism**

Karakteristik:

* Glassmorphism cards.
* Background soft gradient.
* Translucent elements.
* Backdrop blur.
* Thin borders.
* Rounded corners.
* Banyak whitespace.
* Clean typography.
* Soft shadows.
* Subtle animation.
* Mobile-first responsive.

### Color Direction

Palet utama:

* Cream
* White
* Beige
* Soft Pink
* Brown
* Gold
* Soft Purple

Penggunaan warna harus tetap elegan dan tidak terlalu ramai.

---

# 5. Customer Application

## 5.1 Landing Page

Landing page menjadi halaman pertama customer.

### Components

* Navbar.
* Brand logo.
* Hero section.
* CTA.
* Featured products.
* New arrivals.
* Best sellers.
* Categories.
* Promotional banner.
* Brand story.
* Customer reviews.
* Instagram/TikTok section.
* Footer.

### CTA

Contoh:

* Shop Now
* Explore Collection
* View Product
* Discover More

---

# 6. Authentication

Customer dapat:

### Register

Field:

```text
Name
Email
Phone
Password
Password Confirmation
```

### Login

```text
Email
Password
Remember Me
```

### Additional

* Logout.
* Forgot password.
* Reset password.
* Email verification jika diperlukan.

Authentication menggunakan Laravel authentication/Breeze.

---

# 7. Product Catalog

Customer dapat melihat seluruh produk.

### Product Card

Menampilkan:

```text
Product Image
Product Name
Category
Price
Discount Price
Rating
Stock Status
Wishlist Button
```

### Product Listing

Fitur:

* Search.
* Filter category.
* Filter price.
* Filter availability.
* Sorting.
* Pagination.

### Sorting

```text
Newest
Oldest
Price Low → High
Price High → Low
Most Popular
Highest Rated
```

---

# 8. Product Detail

Halaman detail produk menampilkan:

```text
Product Images
Product Name
Category
Price
Discount
Description
Material
Color
Variant
Stock
Rating
Reviews
```

Customer dapat:

* Memilih varian.
* Menentukan quantity.
* Add to Cart.
* Add to Wishlist.
* Buy Now.

### Contoh Variant

```text
Color:
- Black
- Cream
- Brown
- Dusty Pink

Size:
- 110 x 110
- 115 x 115
```

Setiap kombinasi variant memiliki stok sendiri.

---

# 9. Inventory / Stock

Stock harus berada pada level **product variant**, bukan hanya product.

### Stock Status

| Stock | Status       |
| ----: | ------------ |
|  > 10 | In Stock     |
|  1–10 | Low Stock    |
|     0 | Out of Stock |

Admin dapat:

* Menambah stok.
* Mengurangi stok.
* Melihat stok.
* Melihat low stock.
* Melihat produk out of stock.

### Stock Rule

Saat order berhasil:

```text
Available Stock
        ↓
Order Created
        ↓
Stock Reserved / Reduced
```

Sistem harus mencegah customer membeli variant yang stoknya sudah habis.

---

# 10. Wishlist

Customer dapat menyimpan produk favorit.

Fitur:

* Add wishlist.
* Remove wishlist.
* View wishlist.
* Move wishlist → cart.

Wishlist hanya dimiliki oleh customer yang login.

---

# 11. Shopping Cart

Cart berisi produk yang ingin dibeli.

### Cart Item

```text
Product
Variant
Quantity
Unit Price
Subtotal
```

Customer dapat:

* Menambah quantity.
* Mengurangi quantity.
* Menghapus item.
* Melihat subtotal.
* Melihat total item.

### Business Rule

Quantity tidak boleh melebihi stok variant.

---

# 12. Address Management

Customer dapat menyimpan beberapa alamat.

Field:

```text
Recipient Name
Phone
Province
City
District
Postal Code
Full Address
Address Label
```

Contoh label:

```text
Rumah
Kantor
Kos
```

Customer dapat menentukan:

**Default Address**

---

# 13. Voucher & Promotion

Admin dapat membuat voucher.

Contoh:

```text
WELCOME10
HIJAB50K
RAMADAN2026
```

Jenis promo:

* Percentage discount.
* Fixed discount.
* Minimum purchase.
* Maximum discount.
* Expiry date.
* Usage limit.
* Per customer limit.

### Automatic Promotion

Sistem dapat menjalankan promo otomatis tanpa customer memasukkan kode.

Contoh:

```text
Buy 2 → Discount 10%
Minimum purchase Rp300.000 → Discount Rp25.000
```

---

# 14. Checkout

Flow:

```text
Cart
 ↓
Checkout
 ↓
Select Address
 ↓
Select Shipping
 ↓
Apply Voucher
 ↓
Select Payment
 ↓
Review Order
 ↓
Place Order
 ↓
Payment
```

Checkout menampilkan:

```text
Products
Subtotal
Discount
Shipping Cost
Voucher
Grand Total
```

---

# 15. Payment

Payment gateway utama:

**Tripay**

Metode pembayaran dapat mencakup:

* Bank Transfer.
* E-Wallet.
* Payment Channel lain yang tersedia melalui Tripay.
* COD jika diaktifkan sebagai metode internal toko.

### Payment Flow

```text
Customer Checkout
       ↓
Create Order
       ↓
Create Tripay Transaction
       ↓
Customer Payment
       ↓
Tripay
       ↓
Webhook
       ↓
Laravel Backend
       ↓
Validate Webhook
       ↓
Update Payment Status
       ↓
Update Order Status
```

**Webhook harus divalidasi oleh backend**, bukan mempercayai status yang dikirim dari frontend.

---

# 16. Order Management

Order memiliki status terpisah dari payment.

### Order Status

```text
Pending
Processing
Packed
Shipped
Completed
Cancelled
```

### Payment Status

```text
Unpaid
Pending
Paid
Failed
Expired
Refunded
```

Contoh:

```text
Order:
Processing

Payment:
Paid
```

---

# 17. Shipping

Sistem pengiriman menggunakan service/API layer agar integrasi dengan provider ongkir dapat dikembangkan tanpa mengubah business logic utama.

Customer dapat melihat:

```text
Courier
Service
Estimated Delivery
Shipping Cost
Tracking Number
```

### Shipping Flow

```text
Order Paid
 ↓
Admin Process
 ↓
Packed
 ↓
Shipment Created
 ↓
Tracking Number
 ↓
Shipped
 ↓
Customer Receives
 ↓
Completed
```

---

# 18. Order History

Customer dapat melihat:

```text
Order Number
Order Date
Total
Payment Status
Order Status
```

Customer dapat membuka detail:

```text
Products
Variants
Quantity
Price
Shipping
Payment
Address
Tracking
```

---

# 19. Review & Rating

Customer dapat memberikan review setelah order selesai.

Field:

```text
Rating: 1–5
Comment
Photo (optional)
```

Admin dapat:

* Melihat review.
* Moderasi review.
* Menghapus review yang tidak sesuai.

---

# 20. Customer Service / Chat

Customer dapat menghubungi customer service.

Fitur:

```text
Customer
   ↓
Chat
   ↓
Admin
```

Chat dapat digunakan untuk:

* Pertanyaan produk.
* Pertanyaan order.
* Pertanyaan pembayaran.
* Pertanyaan pengiriman.

---

# 21. Notification System

Sistem menyediakan notifikasi melalui:

### Email

Contoh:

```text
Registration
Order Created
Payment Successful
Order Processing
Order Shipped
Order Completed
```

### WhatsApp

Untuk event penting seperti:

```text
Order confirmation
Payment confirmation
Shipping notification
```

Laravel Events + Notifications digunakan sebagai fondasi notification system, dengan queue bila diperlukan.

---

# 22. Customer Profile

Customer dapat mengelola:

```text
Name
Email
Phone
Profile Photo
Password
Addresses
Orders
Wishlist
```

---

# 23. Admin Panel

Admin panel menggunakan:

**Filament 4**

Dashboard menampilkan:

```text
Total Revenue
Total Orders
Total Customers
Total Products
Low Stock Products
Pending Orders
Pending Payments
```

---

# 24. Admin Resources

### Core Resources

| Resource         | Fungsi                  |
| ---------------- | ----------------------- |
| Users            | Admin & customer        |
| Products         | CRUD produk             |
| Categories       | CRUD kategori           |
| Product Variants | CRUD variant            |
| Inventory        | Management stock        |
| Orders           | Management order        |
| Payments         | Management payment      |
| Shipments        | Management shipping     |
| Vouchers         | Management voucher      |
| Promotions       | Management promotion    |
| Reviews          | Management review       |
| Customers        | Customer management     |
| Chat             | Customer service        |
| Banners          | Homepage/banner         |
| Notifications    | Notification management |

---

# 25. Admin Product Management

Admin dapat:

* Create product.
* Edit product.
* Delete product.
* Upload image.
* Assign category.
* Add variant.
* Set price.
* Set discount.
* Set stock.
* Set description.
* Publish/unpublish.

### Product Structure

```text
Product
 ├── Category
 ├── Images
 ├── Variants
 │    ├── Color
 │    ├── Size
 │    ├── Price
 │    └── Stock
 ├── Reviews
 └── Order Items
```

---

# 26. Admin Order Management

Admin dapat melihat:

```text
Order Number
Customer
Date
Total
Payment Status
Order Status
```

Admin dapat:

* Update order status.
* Verify order.
* Process order.
* Packing.
* Input tracking number.
* Mark shipped.
* Complete order.

---

# 27. Dashboard Analytics

Dashboard dapat menyediakan:

### Sales

```text
Today's Sales
Weekly Sales
Monthly Sales
Yearly Sales
```

### Orders

```text
Pending
Processing
Shipped
Completed
Cancelled
```

### Products

```text
Best Seller
Low Stock
Out of Stock
```

### Customers

```text
Total Customers
New Customers
Returning Customers
```

---

# 28. SEO

Storefront harus mendukung basic SEO:

* SEO-friendly URL.
* Meta title.
* Meta description.
* Product slug.
* Category slug.
* Open Graph metadata.
* Sitemap.
* Semantic HTML.

Contoh:

```text
/products/pashmina-silk
/categories/pashmina
```

---

# 29. Social Media Integration

Website menyediakan area untuk social media brand:

* Instagram.
* TikTok.

Contohnya:

```text
Instagram Feed
TikTok Content
Social Media CTA
```

Tujuannya untuk menghubungkan aktivitas social media dengan storefront.

---

# 30. Database Core Entities

Struktur entity utama:

```text
User
Category
Product
ProductVariant
ProductImage
Wishlist
WishlistItem
Cart
CartItem
Address
Order
OrderItem
Payment
PaymentWebhook
Shipment
ShipmentItem
Voucher
Promotion
Review
Chat
ChatMessage
Notification
Banner
```

### Relationship Utama

```text
User
 ├── Addresses
 ├── Cart
 ├── Wishlist
 ├── Orders
 ├── Reviews
 └── Chats

Category
 └── Products

Product
 ├── Variants
 ├── Images
 ├── Reviews
 └── OrderItems

ProductVariant
 ├── CartItems
 └── OrderItems

Order
 ├── OrderItems
 ├── Payment
 └── Shipment
```

---

# 31. Security Requirements

Sistem harus memiliki:

* Authentication.
* Authorization.
* Role-based access.
* CSRF protection.
* Validation.
* Password hashing.
* Secure payment webhook.
* Rate limiting untuk endpoint tertentu.
* Secure file upload.
* SQL injection protection melalui Eloquent/query builder.
* XSS protection.
* Admin route protection.

### Role

```text
Admin
Customer
```

Customer tidak boleh mengakses Filament admin panel.

---

# 32. Non-Functional Requirements

### Performance

Target:

* Fast page loading.
* Optimized images.
* Lazy loading.
* Pagination.
* Database indexing.
* Queue untuk proses asynchronous.

### Responsive

Website harus berjalan pada:

```text
Mobile
Tablet
Desktop
```

Prioritas:

**Mobile-first.**

### Scalability

Architecture harus memungkinkan:

* Penambahan produk.
* Penambahan kategori.
* Penambahan variant.
* Penambahan payment channel.
* Penambahan shipping provider.
* Penambahan notification channel.

---

# 33. Main Customer Flow

```text
                    ┌───────────────┐
                    │    Landing    │
                    └───────┬───────┘
                            ↓
                    ┌───────────────┐
                    │ Product List  │
                    └───────┬───────┘
                            ↓
                    ┌───────────────┐
                    │ Product Detail│
                    └───────┬───────┘
                            ↓
                  ┌─────────┴─────────┐
                  ↓                   ↓
             Wishlist             Add Cart
                                      ↓
                                  Checkout
                                      ↓
                              Select Address
                                      ↓
                              Select Shipping
                                      ↓
                              Apply Voucher
                                      ↓
                              Select Payment
                                      ↓
                               Create Order
                                      ↓
                               Tripay Payment
                                      ↓
                                Webhook
                                      ↓
                              Payment Paid
                                      ↓
                              Order Process
                                      ↓
                                  Shipping
                                      ↓
                                  Delivered
                                      ↓
                                Completed
                                      ↓
                                  Review
```

---

# 34. Admin Flow

```text
Login
  ↓
Admin Dashboard
  ↓
┌──────────────┬──────────────┬──────────────┐
│ Catalog      │ Transactions │ Customers    │
│              │              │              │
│ Products     │ Orders       │ Users        │
│ Categories   │ Payments     │ Customers    │
│ Variants     │ Shipments    │ Reviews      │
│ Inventory    │              │ Chat         │
└──────────────┴──────────────┴──────────────┘
```

---

# 35. MVP Scope

Untuk tahap pertama, jangan langsung mengerjakan seluruh fitur.

### Phase 1 — Core

* Authentication.
* User.
* Category.
* Product.
* Product Variant.
* Product Image.
* Inventory.
* Product listing.
* Product detail.
* Cart.
* Checkout.
* Address.
* Order.
* Admin Filament.

### Phase 2 — Transaction

* Tripay.
* Payment webhook.
* Payment status.
* Shipping.
* Tracking.
* Order notification.

### Phase 3 — Marketing

* Wishlist.
* Voucher.
* Promotion.
* Banner.
* Review.
* Social media integration.

### Phase 4 — Customer Experience

* Customer service chat.
* WhatsApp notification.
* Advanced dashboard.
* Analytics.
* Additional optimization.

---

# 36. Acceptance Criteria

Project dianggap memenuhi requirement apabila:

### Customer

* [ ] Customer dapat register.
* [ ] Customer dapat login.
* [ ] Customer dapat melihat produk.
* [ ] Customer dapat mencari produk.
* [ ] Customer dapat filter produk.
* [ ] Customer dapat memilih variant.
* [ ] Customer dapat melihat stok.
* [ ] Customer dapat memasukkan produk ke cart.
* [ ] Customer dapat checkout.
* [ ] Customer dapat memilih alamat.
* [ ] Customer dapat memilih shipping.
* [ ] Customer dapat melakukan pembayaran.
* [ ] Customer dapat melihat status order.
* [ ] Customer dapat melihat history order.
* [ ] Customer dapat memberikan review.

### Admin

* [ ] Admin dapat login ke Filament.
* [ ] Admin dapat CRUD category.
* [ ] Admin dapat CRUD product.
* [ ] Admin dapat CRUD variant.
* [ ] Admin dapat mengatur stock.
* [ ] Admin dapat melihat customer.
* [ ] Admin dapat melihat order.
* [ ] Admin dapat mengelola payment.
* [ ] Admin dapat mengelola shipment.
* [ ] Admin dapat mengelola voucher.
* [ ] Admin dapat mengelola promotion.
* [ ] Admin dapat mengelola review.
* [ ] Admin dapat melihat dashboard.

### Payment

* [ ] Order menghasilkan transaksi payment.
* [ ] Customer diarahkan ke payment process.
* [ ] Tripay webhook dapat diterima.
* [ ] Webhook diverifikasi.
* [ ] Payment status diperbarui.
* [ ] Order status diperbarui sesuai payment.

---

# 37. Recommended Development Order

Supaya development-nya nggak berantakan, urutannya:

```text
1. Laravel Setup
       ↓
2. Authentication
       ↓
3. Database & Migration
       ↓
4. Models & Relationships
       ↓
5. Filament Admin
       ↓
6. Category
       ↓
7. Product
       ↓
8. Product Variant
       ↓
9. Inventory
       ↓
10. Storefront
       ↓
11. Cart
       ↓
12. Address
       ↓
13. Checkout
       ↓
14. Order
       ↓
15. Tripay
       ↓
16. Payment Webhook
       ↓
17. Shipping
       ↓
18. Notification
       ↓
19. Wishlist
       ↓
20. Voucher & Promotion
       ↓
21. Review
       ↓
22. Chat
       ↓
23. Dashboard Analytics
       ↓
24. Testing
       ↓
25. Deployment
```

## 38. Definition of Done

Fitur dianggap selesai apabila:

1. Database/migration sudah tersedia.
2. Model dan relationship sudah benar.
3. Validation sudah dibuat.
4. Authorization sudah diterapkan.
5. UI sudah responsive.
6. Error handling sudah tersedia.
7. Admin dapat mengelola data terkait.
8. Customer dapat menggunakan fitur dari storefront.
9. Test untuk business logic penting tersedia.
10. Tidak terdapat error pada flow utama.

---

### Ringkasan Arsitektur

```text
                    HIJAB BRAND STORE
                           │
          ┌────────────────┴────────────────┐
          │                                 │
      STOREFRONT                         ADMIN
          │                                 │
   Blade + Tailwind                    Filament 4
          │                                 │
          └──────────────┬──────────────────┘
                         │
                    Laravel 13
                         │
       ┌─────────────────┼─────────────────┐
       │                 │                 │
    Eloquent          Services          Events
       │                 │                 │
       └─────────────────┼─────────────────┘
                         │
                       MySQL
                         │
          ┌──────────────┼──────────────┐
          │              │              │
        Tripay        Shipping       Notification
       Payment API       API          Email/WA
```

Dengan PRD ini, **MVP-nya sudah cukup jelas untuk langsung diturunkan menjadi ERD → migration → model & relationship → Filament Resource → storefront → checkout → payment Tripay** tanpa perlu mengubah konsep single-brand di tengah development.
