# Database Design --- Hijab Single Brand E-Commerce

**Project:** Hijab Single Brand E-Commerce\
**Version:** 1.0\
**Database:** MySQL\
**Framework:** Laravel 13\
**ORM:** Eloquent\
**Admin Panel:** Filament 4

------------------------------------------------------------------------

## 1. Database Overview

Database ini dirancang untuk e-commerce **single brand hijab**. Sistem
tidak menggunakan konsep marketplace atau multi-vendor, sehingga tidak
membutuhkan tabel `brands`, `vendors`, atau `seller_stores`.

Total tabel utama: **20 tabel**.

    No Table                  Fungsi
  ---- ---------------------- -----------------------------
     1 `users`                Admin dan customer
     2 `categories`           Kategori produk
     3 `products`             Data produk hijab
     4 `product_variants`     Varian produk dan stok
     5 `product_images`       Foto produk
     6 `addresses`            Alamat customer
     7 `carts`                Keranjang customer
     8 `cart_items`           Item dalam keranjang
     9 `wishlists`            Wishlist customer
    10 `wishlist_items`       Item wishlist
    11 `orders`               Data pesanan
    12 `order_items`          Detail item pesanan
    13 `payments`             Data pembayaran
    14 `payment_webhooks`     Log webhook payment gateway
    15 `shipments`            Data pengiriman
    16 `vouchers`             Kode voucher
    17 `promotions`           Promo otomatis
    18 `reviews`              Review produk
    19 `chat_conversations`   Percakapan customer service
    20 `chat_messages`        Pesan customer service

------------------------------------------------------------------------

# 2. Entity Relationship Diagram

``` mermaid
erDiagram
    USERS ||--o{ ADDRESSES : has
    USERS ||--o| CARTS : owns
    USERS ||--o| WISHLISTS : owns
    USERS ||--o{ ORDERS : places
    USERS ||--o{ REVIEWS : writes
    USERS ||--o{ CHAT_CONVERSATIONS : starts

    CATEGORIES ||--o{ PRODUCTS : contains

    PRODUCTS ||--o{ PRODUCT_VARIANTS : has
    PRODUCTS ||--o{ PRODUCT_IMAGES : has
    PRODUCTS ||--o{ REVIEWS : receives

    CARTS ||--o{ CART_ITEMS : contains
    PRODUCT_VARIANTS ||--o{ CART_ITEMS : added_to

    WISHLISTS ||--o{ WISHLIST_ITEMS : contains
    PRODUCTS ||--o{ WISHLIST_ITEMS : saved

    ORDERS ||--o{ ORDER_ITEMS : contains
    PRODUCTS ||--o{ ORDER_ITEMS : references
    PRODUCT_VARIANTS ||--o{ ORDER_ITEMS : references

    ORDERS ||--o| PAYMENTS : has
    PAYMENTS ||--o{ PAYMENT_WEBHOOKS : receives

    ORDERS ||--o| SHIPMENTS : has

    CHAT_CONVERSATIONS ||--o{ CHAT_MESSAGES : contains
    USERS ||--o{ CHAT_MESSAGES : sends
```

------------------------------------------------------------------------

# 3. Database Relationship Map

``` text
USER
 ├── hasMany → ADDRESSES
 ├── hasOne  → CART
 │              └── hasMany → CART_ITEMS
 │                             └── belongsTo → PRODUCT_VARIANT
 │
 ├── hasOne  → WISHLIST
 │              └── hasMany → WISHLIST_ITEMS
 │                             └── belongsTo → PRODUCT
 │
 ├── hasMany → ORDERS
 │              ├── hasMany → ORDER_ITEMS
 │              │              ├── belongsTo → PRODUCT
 │              │              └── belongsTo → PRODUCT_VARIANT
 │              │
 │              ├── hasOne → PAYMENT
 │              │             └── hasMany → PAYMENT_WEBHOOKS
 │              │
 │              └── hasOne → SHIPMENT
 │
 ├── hasMany → REVIEWS
 │
 └── hasMany → CHAT_CONVERSATIONS
                └── hasMany → CHAT_MESSAGES


CATEGORY
 └── hasMany → PRODUCTS
                ├── hasMany → PRODUCT_VARIANTS
                ├── hasMany → PRODUCT_IMAGES
                ├── hasMany → ORDER_ITEMS
                └── hasMany → REVIEWS
```

------------------------------------------------------------------------

# 4. Table: `users`

Menyimpan akun admin dan customer.

  Column                Type        Attribute            Description
  --------------------- ----------- -------------------- ----------------------
  `id`                  bigint      PK                   ID user
  `name`                varchar     NOT NULL             Nama user
  `email`               varchar     UNIQUE               Email
  `phone`               varchar     NULL                 Nomor telepon
  `password`            varchar     NOT NULL             Password ter-hash
  `role`                enum        DEFAULT `customer`   `admin` / `customer`
  `email_verified_at`   timestamp   NULL                 Waktu verifikasi
  `remember_token`      varchar     NULL                 Remember token
  `created_at`          timestamp                        Laravel timestamp
  `updated_at`          timestamp                        Laravel timestamp

### Relationship

``` text
User hasMany Address
User hasOne Cart
User hasOne Wishlist
User hasMany Order
User hasMany Review
User hasMany ChatConversation
User hasMany ChatMessage
```

------------------------------------------------------------------------

# 5. Table: `categories`

Menyimpan kategori produk.

  Column          Type        Attribute      Description
  --------------- ----------- -------------- -----------------
  `id`            bigint      PK             ID kategori
  `name`          varchar     NOT NULL       Nama kategori
  `slug`          varchar     UNIQUE         URL slug
  `description`   text        NULL           Deskripsi
  `image`         varchar     NULL           Gambar kategori
  `is_active`     boolean     DEFAULT true   Status aktif
  `created_at`    timestamp                  
  `updated_at`    timestamp                  

### Relationship

``` text
Category hasMany Product
```

------------------------------------------------------------------------

# 6. Table: `products`

Menyimpan data utama produk.

  Column            Type            Attribute       Description
  ----------------- --------------- --------------- ----------------------
  `id`              bigint          PK              ID produk
  `category_id`     bigint          FK              Relasi kategori
  `name`            varchar         NOT NULL        Nama produk
  `slug`            varchar         UNIQUE          URL slug
  `sku`             varchar         UNIQUE          SKU produk
  `description`     longText        NULL            Deskripsi produk
  `material`        varchar         NULL            Material hijab
  `price`           decimal(15,2)   NOT NULL        Harga jual
  `compare_price`   decimal(15,2)   NULL            Harga sebelum diskon
  `is_active`       boolean         DEFAULT true    Status produk
  `is_featured`     boolean         DEFAULT false   Produk unggulan
  `created_at`      timestamp                       
  `updated_at`      timestamp                       

### Foreign Key

``` text
products.category_id
        ↓
categories.id
```

### Relationship

``` text
Product belongsTo Category
Product hasMany ProductVariant
Product hasMany ProductImage
Product hasMany WishlistItem
Product hasMany OrderItem
Product hasMany Review
```

------------------------------------------------------------------------

# 7. Table: `product_variants`

Menyimpan varian produk sekaligus stok.

  Column         Type              Attribute      Description
  -------------- ----------------- -------------- ----------------------
  `id`           bigint            PK             ID variant
  `product_id`   bigint            FK             Produk
  `sku`          varchar           UNIQUE         SKU variant
  `name`         varchar           NOT NULL       Nama variant
  `color`        varchar           NULL           Warna
  `size`         varchar           NULL           Ukuran
  `price`        decimal(15,2)     NULL           Harga khusus variant
  `stock`        unsignedInteger   DEFAULT 0      Jumlah stok
  `is_active`    boolean           DEFAULT true   Status variant
  `created_at`   timestamp                        
  `updated_at`   timestamp                        

### Foreign Key

``` text
product_variants.product_id
        ↓
products.id
```

### Relationship

``` text
ProductVariant belongsTo Product
ProductVariant hasMany CartItem
ProductVariant hasMany OrderItem
```

> **Catatan:** stok berada di `product_variants`, bukan di `products`,
> karena setiap warna/ukuran dapat memiliki stok berbeda.

------------------------------------------------------------------------

# 8. Table: `product_images`

Menyimpan banyak gambar untuk satu produk.

  Column         Type              Attribute       Description
  -------------- ----------------- --------------- ---------------
  `id`           bigint            PK              ID gambar
  `product_id`   bigint            FK              Produk
  `image`        varchar           NOT NULL        Path gambar
  `alt_text`     varchar           NULL            Alt text
  `sort_order`   unsignedInteger   DEFAULT 0       Urutan gambar
  `is_primary`   boolean           DEFAULT false   Gambar utama
  `created_at`   timestamp                         
  `updated_at`   timestamp                         

### Relationship

``` text
ProductImage belongsTo Product
```

------------------------------------------------------------------------

# 9. Table: `addresses`

Menyimpan alamat customer.

  Column             Type        Attribute       Description
  ------------------ ----------- --------------- ------------------
  `id`               bigint      PK              ID alamat
  `user_id`          bigint      FK              Customer
  `recipient_name`   varchar     NOT NULL        Nama penerima
  `phone`            varchar     NOT NULL        Nomor penerima
  `label`            varchar     NULL            Rumah/Kantor/Kos
  `province`         varchar     NOT NULL        Provinsi
  `city`             varchar     NOT NULL        Kota
  `district`         varchar     NULL            Kecamatan
  `postal_code`      varchar     NULL            Kode pos
  `address`          text        NOT NULL        Alamat lengkap
  `is_default`       boolean     DEFAULT false   Alamat utama
  `created_at`       timestamp                   
  `updated_at`       timestamp                   

### Foreign Key

``` text
addresses.user_id
        ↓
users.id
```

------------------------------------------------------------------------

# 10. Table: `carts`

Menyimpan keranjang aktif customer.

  Column         Type        Attribute     Description
  -------------- ----------- ------------- --------------
  `id`           bigint      PK            ID cart
  `user_id`      bigint      FK + UNIQUE   Pemilik cart
  `created_at`   timestamp                 
  `updated_at`   timestamp                 

### Relationship

``` text
User hasOne Cart
Cart belongsTo User
Cart hasMany CartItem
```

------------------------------------------------------------------------

# 11. Table: `cart_items`

Menyimpan isi keranjang.

  Column                 Type              Attribute   Description
  ---------------------- ----------------- ----------- -------------
  `id`                   bigint            PK          ID item
  `cart_id`              bigint            FK          Cart
  `product_variant_id`   bigint            FK          Variant
  `quantity`             unsignedInteger   NOT NULL    Jumlah
  `created_at`           timestamp                     
  `updated_at`           timestamp                     

### Foreign Key

``` text
cart_items.cart_id
        ↓
carts.id

cart_items.product_variant_id
        ↓
product_variants.id
```

------------------------------------------------------------------------

# 12. Table: `wishlists`

Wishlist milik customer.

  Column         Type        Attribute
  -------------- ----------- -------------
  `id`           bigint      PK
  `user_id`      bigint      FK + UNIQUE
  `created_at`   timestamp   
  `updated_at`   timestamp   

### Relationship

``` text
User hasOne Wishlist
Wishlist belongsTo User
Wishlist hasMany WishlistItem
```

------------------------------------------------------------------------

# 13. Table: `wishlist_items`

Produk yang disimpan ke wishlist.

  Column          Type        Attribute
  --------------- ----------- -----------
  `id`            bigint      PK
  `wishlist_id`   bigint      FK
  `product_id`    bigint      FK
  `created_at`    timestamp   
  `updated_at`    timestamp   

### Foreign Key

``` text
wishlist_items.wishlist_id
        ↓
wishlists.id

wishlist_items.product_id
        ↓
products.id
```

### Constraint

Kombinasi berikut harus UNIQUE:

``` text
wishlist_id + product_id
```

------------------------------------------------------------------------

# 14. Table: `orders`

Menyimpan transaksi pesanan.

  Column               Type            Attribute           Description
  -------------------- --------------- ------------------- -----------------
  `id`                 bigint          PK                  ID order
  `user_id`            bigint          FK                  Customer
  `order_number`       varchar         UNIQUE              Nomor order
  `address_snapshot`   json            NOT NULL            Snapshot alamat
  `subtotal`           decimal(15,2)   DEFAULT 0           Subtotal
  `discount_amount`    decimal(15,2)   DEFAULT 0           Diskon
  `shipping_amount`    decimal(15,2)   DEFAULT 0           Ongkir
  `total_amount`       decimal(15,2)   DEFAULT 0           Total
  `voucher_code`       varchar         NULL                Voucher
  `status`             enum            DEFAULT `pending`   Status order
  `notes`              text            NULL                Catatan
  `placed_at`          timestamp       NULL                Waktu order
  `created_at`         timestamp                           
  `updated_at`         timestamp                           

### Order Status

``` text
pending
processing
packed
shipped
completed
cancelled
```

### Relationship

``` text
Order belongsTo User
Order hasMany OrderItem
Order hasOne Payment
Order hasOne Shipment
```

> `address_snapshot` digunakan agar alamat pada histori transaksi tetap
> sama walaupun customer mengubah alamat profile setelah checkout.

------------------------------------------------------------------------

# 15. Table: `order_items`

Menyimpan detail produk saat transaksi.

  Column                 Type              Attribute   Description
  ---------------------- ----------------- ----------- ----------------------
  `id`                   bigint            PK          ID item
  `order_id`             bigint            FK          Order
  `product_id`           bigint            FK          Produk
  `product_variant_id`   bigint            FK          Variant
  `product_name`         varchar           NOT NULL    Snapshot nama
  `variant_name`         varchar           NULL        Snapshot variant
  `sku`                  varchar           NULL        Snapshot SKU
  `price`                decimal(15,2)     NOT NULL    Harga saat transaksi
  `quantity`             unsignedInteger   NOT NULL    Jumlah
  `subtotal`             decimal(15,2)     NOT NULL    Total item
  `created_at`           timestamp                     
  `updated_at`           timestamp                     

### Foreign Key

``` text
order_items.order_id
        ↓
orders.id

order_items.product_id
        ↓
products.id

order_items.product_variant_id
        ↓
product_variants.id
```

> Harga, nama produk, variant, dan SKU disimpan sebagai snapshot agar
> histori transaksi tidak berubah ketika data produk diubah.

------------------------------------------------------------------------

# 16. Table: `payments`

Menyimpan transaksi pembayaran.

  Column              Type            Attribute          Description
  ------------------- --------------- ------------------ --------------------
  `id`                bigint          PK                 ID payment
  `order_id`          bigint          FK + UNIQUE        Order
  `reference`         varchar         UNIQUE             Reference Tripay
  `merchant_ref`      varchar         UNIQUE             Reference merchant
  `payment_method`    varchar         NULL               Metode
  `payment_channel`   varchar         NULL               Channel
  `amount`            decimal(15,2)   NOT NULL           Nominal
  `status`            enum            DEFAULT `unpaid`   Status
  `paid_at`           timestamp       NULL               Waktu bayar
  `expired_at`        timestamp       NULL               Expired
  `raw_response`      json            NULL               Response gateway
  `created_at`        timestamp                          
  `updated_at`        timestamp                          

### Payment Status

``` text
unpaid
pending
paid
failed
expired
refunded
```

### Relationship

``` text
Payment belongsTo Order
Payment hasMany PaymentWebhook
```

------------------------------------------------------------------------

# 17. Table: `payment_webhooks`

Menyimpan webhook dari Tripay.

  Column           Type        Attribute   Description
  ---------------- ----------- ----------- -----------------
  `id`             bigint      PK          ID webhook
  `payment_id`     bigint      FK          Payment
  `reference`      varchar     NULL        Reference
  `event`          varchar     NULL        Event
  `payload`        json        NOT NULL    Payload webhook
  `signature`      varchar     NULL        Signature
  `processed_at`   timestamp   NULL        Waktu proses
  `created_at`     timestamp               
  `updated_at`     timestamp               

### Relationship

``` text
PaymentWebhook belongsTo Payment
```

------------------------------------------------------------------------

# 18. Table: `shipments`

Menyimpan informasi pengiriman.

  Column                 Type            Attribute           Description
  ---------------------- --------------- ------------------- -------------
  `id`                   bigint          PK                  ID shipment
  `order_id`             bigint          FK + UNIQUE         Order
  `courier`              varchar         NULL                Kurir
  `service`              varchar         NULL                Service
  `tracking_number`      varchar         NULL                Resi
  `shipping_cost`        decimal(15,2)   DEFAULT 0           Ongkir
  `estimated_delivery`   varchar         NULL                Estimasi
  `status`               enum            DEFAULT `pending`   Status
  `shipped_at`           timestamp       NULL                Dikirim
  `delivered_at`         timestamp       NULL                Diterima
  `created_at`           timestamp                           
  `updated_at`           timestamp                           

### Shipment Status

``` text
pending
processing
shipped
delivered
returned
```

------------------------------------------------------------------------

# 19. Table: `vouchers`

Menyimpan voucher yang menggunakan kode.

  Column                   Type              Attribute
  ------------------------ ----------------- ------------------------
  `id`                     bigint            PK
  `code`                   varchar           UNIQUE
  `name`                   varchar           NOT NULL
  `type`                   enum              `percentage` / `fixed`
  `value`                  decimal(15,2)     NOT NULL
  `minimum_purchase`       decimal(15,2)     DEFAULT 0
  `maximum_discount`       decimal(15,2)     NULL
  `usage_limit`            unsignedInteger   NULL
  `usage_limit_per_user`   unsignedInteger   NULL
  `used_count`             unsignedInteger   DEFAULT 0
  `starts_at`              timestamp         NULL
  `expires_at`             timestamp         NULL
  `is_active`              boolean           DEFAULT true
  `created_at`             timestamp         
  `updated_at`             timestamp         

------------------------------------------------------------------------

# 20. Table: `promotions`

Promo otomatis tanpa kode voucher.

  Column               Type            Attribute
  -------------------- --------------- ------------------------
  `id`                 bigint          PK
  `name`               varchar         NOT NULL
  `type`               enum            `percentage` / `fixed`
  `value`              decimal(15,2)   NOT NULL
  `minimum_purchase`   decimal(15,2)   DEFAULT 0
  `starts_at`          timestamp       NULL
  `expires_at`         timestamp       NULL
  `is_active`          boolean         DEFAULT true
  `created_at`         timestamp       
  `updated_at`         timestamp       

> Untuk promo yang lebih kompleks seperti `buy_x_get_y`,
> `product_discount`, atau `category_discount`, struktur ini dapat
> dikembangkan pada fase berikutnya.

------------------------------------------------------------------------

# 21. Table: `reviews`

Review dan rating produk.

  Column          Type                  Attribute
  --------------- --------------------- ---------------
  `id`            bigint                PK
  `user_id`       bigint                FK
  `product_id`    bigint                FK
  `order_id`      bigint                FK
  `rating`        unsignedTinyInteger   1--5
  `comment`       text                  NULL
  `image`         varchar               NULL
  `is_approved`   boolean               DEFAULT false
  `created_at`    timestamp             
  `updated_at`    timestamp             

### Foreign Key

``` text
reviews.user_id
        ↓
users.id

reviews.product_id
        ↓
products.id

reviews.order_id
        ↓
orders.id
```

### Business Rule

Review hanya boleh dibuat customer yang telah membeli produk dan
order-nya sudah selesai.

------------------------------------------------------------------------

# 22. Table: `chat_conversations`

Percakapan customer dengan customer service.

  Column              Type        Attribute
  ------------------- ----------- -------------------
  `id`                bigint      PK
  `user_id`           bigint      FK
  `status`            enum        `open` / `closed`
  `last_message_at`   timestamp   NULL
  `created_at`        timestamp   
  `updated_at`        timestamp   

### Relationship

``` text
User hasMany ChatConversation
ChatConversation belongsTo User
ChatConversation hasMany ChatMessage
```

------------------------------------------------------------------------

# 23. Table: `chat_messages`

Pesan dalam percakapan.

  Column              Type        Attribute
  ------------------- ----------- -----------
  `id`                bigint      PK
  `conversation_id`   bigint      FK
  `sender_id`         bigint      FK
  `message`           text        NOT NULL
  `attachment`        varchar     NULL
  `read_at`           timestamp   NULL
  `created_at`        timestamp   
  `updated_at`        timestamp   

### Foreign Key

``` text
chat_messages.conversation_id
        ↓
chat_conversations.id

chat_messages.sender_id
        ↓
users.id
```

------------------------------------------------------------------------

# 24. Complete Foreign Key Map

``` text
products.category_id
    → categories.id

product_variants.product_id
    → products.id

product_images.product_id
    → products.id

addresses.user_id
    → users.id

carts.user_id
    → users.id

cart_items.cart_id
    → carts.id

cart_items.product_variant_id
    → product_variants.id

wishlists.user_id
    → users.id

wishlist_items.wishlist_id
    → wishlists.id

wishlist_items.product_id
    → products.id

orders.user_id
    → users.id

order_items.order_id
    → orders.id

order_items.product_id
    → products.id

order_items.product_variant_id
    → product_variants.id

payments.order_id
    → orders.id

payment_webhooks.payment_id
    → payments.id

shipments.order_id
    → orders.id

reviews.user_id
    → users.id

reviews.product_id
    → products.id

reviews.order_id
    → orders.id

chat_conversations.user_id
    → users.id

chat_messages.conversation_id
    → chat_conversations.id

chat_messages.sender_id
    → users.id
```

------------------------------------------------------------------------

# 25. Delete / Update Strategy

Untuk data transaksi, hindari `cascade delete` yang dapat menghapus
histori transaksi secara tidak sengaja.

### Recommended

``` text
categories
 └── products
      └── product_variants
```

Untuk data katalog yang masih aman dihapus, gunakan cascade sesuai
kebutuhan.

Untuk transaksi:

``` text
users
 └── orders
      ├── order_items
      ├── payments
      └── shipments
```

Order yang sudah memiliki transaksi **sebaiknya tidak dihapus secara
fisik**. Gunakan status `cancelled` atau soft delete bila memang
diperlukan.

------------------------------------------------------------------------

# 26. Migration Order

Urutan migration Laravel yang direkomendasikan:

``` text
01_create_users_table
02_create_categories_table
03_create_products_table
04_create_product_variants_table
05_create_product_images_table
06_create_addresses_table

07_create_carts_table
08_create_cart_items_table

09_create_wishlists_table
10_create_wishlist_items_table

11_create_orders_table
12_create_order_items_table

13_create_payments_table
14_create_payment_webhooks_table

15_create_shipments_table

16_create_vouchers_table
17_create_promotions_table

18_create_reviews_table

19_create_chat_conversations_table
20_create_chat_messages_table
```

------------------------------------------------------------------------

# 27. Laravel Model Structure

``` text
app/
└── Models/
    ├── User.php
    ├── Category.php
    ├── Product.php
    ├── ProductVariant.php
    ├── ProductImage.php
    ├── Address.php
    ├── Cart.php
    ├── CartItem.php
    ├── Wishlist.php
    ├── WishlistItem.php
    ├── Order.php
    ├── OrderItem.php
    ├── Payment.php
    ├── PaymentWebhook.php
    ├── Shipment.php
    ├── Voucher.php
    ├── Promotion.php
    ├── Review.php
    ├── ChatConversation.php
    └── ChatMessage.php
```

------------------------------------------------------------------------

# 28. Important Business Rules

### Product & Variant

1.  Satu category memiliki banyak product.
2.  Satu product memiliki banyak variant.
3.  Stok disimpan pada variant.
4.  SKU product dan variant harus unik.
5.  Variant yang stoknya `0` tidak dapat dibeli.

### Cart

1.  Satu customer memiliki satu cart aktif.
2.  Satu variant tidak boleh muncul dua kali dalam cart yang sama.
3.  Quantity tidak boleh melebihi stock.

### Order

1.  Setiap order memiliki `order_number` unik.
2.  Order menyimpan snapshot alamat.
3.  Order item menyimpan snapshot data produk.
4.  Harga transaksi tidak boleh bergantung pada harga produk saat ini.

### Payment

1.  Satu order memiliki maksimal satu payment aktif.
2.  Payment menggunakan reference unik.
3.  Webhook harus divalidasi.
4.  Webhook yang sama tidak boleh diproses dua kali.

### Review

1.  Rating hanya 1--5.
2.  Customer harus pernah membeli produk.
3.  Review idealnya hanya dapat dibuat setelah order `completed`.
4.  Admin dapat melakukan moderasi.

### Voucher

1.  Voucher harus berada dalam periode aktif.
2.  Minimum purchase harus terpenuhi.
3.  Usage limit harus diperiksa.
4.  Limit per customer harus diperiksa.

------------------------------------------------------------------------

# 29. Recommended Indexes

Index yang penting:

``` text
users.email
users.role

categories.slug

products.slug
products.sku
products.category_id

product_variants.sku
product_variants.product_id

addresses.user_id

carts.user_id

cart_items.cart_id
cart_items.product_variant_id

orders.user_id
orders.order_number
orders.status

order_items.order_id
order_items.product_id
order_items.product_variant_id

payments.order_id
payments.reference
payments.merchant_ref
payments.status

payment_webhooks.payment_id
payment_webhooks.reference

shipments.order_id
shipments.tracking_number

vouchers.code
vouchers.is_active

promotions.is_active

reviews.product_id
reviews.user_id
reviews.order_id

chat_conversations.user_id
chat_messages.conversation_id
chat_messages.sender_id
```

------------------------------------------------------------------------

# 30. Recommended Unique Constraints

``` text
users.email

categories.slug

products.slug
products.sku

product_variants.sku

carts.user_id

wishlists.user_id

wishlist_items
    (wishlist_id, product_id)

orders.order_number

payments.order_id
payments.reference
payments.merchant_ref

shipments.order_id

vouchers.code
```

------------------------------------------------------------------------

# 31. High-Level Transaction Flow

``` text
CUSTOMER
   │
   ▼
PRODUCT
   │
   ▼
PRODUCT VARIANT
   │
   ▼
CART
   │
   ▼
CHECKOUT
   │
   ├── ADDRESS SNAPSHOT
   ├── VOUCHER
   ├── SHIPPING
   │
   ▼
ORDER
   │
   ├── ORDER ITEMS
   │
   ▼
PAYMENT
   │
   ▼
TRIPAY
   │
   ▼
WEBHOOK
   │
   ▼
PAYMENT = PAID
   │
   ▼
ORDER = PROCESSING
   │
   ▼
SHIPMENT
   │
   ▼
ORDER = SHIPPED
   │
   ▼
ORDER = COMPLETED
   │
   ▼
REVIEW
```

------------------------------------------------------------------------

# 32. Database Scope

### MVP

``` text
users
categories
products
product_variants
product_images
addresses
carts
cart_items
orders
order_items
payments
payment_webhooks
shipments
```

### Phase 2

``` text
wishlists
wishlist_items
vouchers
promotions
reviews
```

### Phase 3

``` text
chat_conversations
chat_messages
```

------------------------------------------------------------------------

# 33. Final Architecture

``` text
                         ┌───────────────┐
                         │     USERS     │
                         └───────┬───────┘
                                 │
          ┌──────────────────────┼──────────────────────┐
          │                      │                      │
          ▼                      ▼                      ▼
      ADDRESSES               CARTS                 ORDERS
                                  │                      │
                                  ▼                      ├── ORDER_ITEMS
                             CART_ITEMS                  │
                                  │                      ├── PAYMENT
                                  ▼                      │      │
                         PRODUCT_VARIANTS               │      └── WEBHOOKS
                                  ▲                      │
                                  │                      └── SHIPMENT
                                  │
                              PRODUCTS
                                  │
                       ┌──────────┴──────────┐
                       ▼                     ▼
                  CATEGORIES             IMAGES
                       │
                       └────────────── PRODUCTS

      USERS ─── WISHLIST ─── WISHLIST_ITEMS ─── PRODUCTS

      USERS ─── REVIEWS ─── PRODUCTS

      USERS ─── CHAT_CONVERSATIONS ─── CHAT_MESSAGES
```

------------------------------------------------------------------------

## 34. Development Notes

Database ini menjadi source of truth untuk tahap development berikutnya:

1.  Generate migration.
2.  Generate Eloquent model.
3.  Definisikan relationship.
4.  Buat factory dan seeder.
5.  Buat Filament Resource.
6.  Buat storefront.
7.  Buat cart dan checkout.
8.  Integrasikan payment gateway.
9.  Buat shipping.
10. Tambahkan testing.

**Catatan:** tabel `brands` sengaja tidak dibuat karena project
merupakan **single-brand store**. Jika di masa depan project berubah
menjadi marketplace/multi-brand, struktur brand/vendor dapat ditambahkan
melalui migration baru.
