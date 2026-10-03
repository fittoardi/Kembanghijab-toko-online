<?php

use Illuminate\Support\Facades\Route;

$products = [
    [
        'id' => 1,
        'slug' => 'pashmina-satin-moonlight',
        'name' => 'Pashmina Satin Moonlight',
        'category' => 'Pashmina',
        'price' => 149000,
        'old_price' => 179000,
        'rating' => 4.9,
        'reviews' => 128,
        'tag' => 'Best seller',
        'color' => 'from-[#d8c4bd] via-[#efe3d9] to-[#b99a62]',
        'image' => 'https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?auto=format&fit=crop&w=900&q=85',
        'description' => 'Pashmina satin dengan kilau lembut yang jatuh cantik untuk menemani momen spesial maupun gaya sehari-hari.',
    ],
    [
        'id' => 2,
        'slug' => 'voal-paris-rose',
        'name' => 'Voal Paris Rose',
        'category' => 'Voal',
        'price' => 119000,
        'old_price' => null,
        'rating' => 4.8,
        'reviews' => 96,
        'tag' => 'New arrival',
        'color' => 'from-[#e8cfcf] via-[#f4e7e2] to-[#c58f9d]',
        'image' => 'https://images.unsplash.com/photo-1584184924103-e310d9dc82fc?auto=format&fit=crop&w=900&q=85',
        'description' => 'Voal premium bertekstur ringan dengan warna rose yang manis dan mudah dipadukan.',
    ],
    [
        'id' => 3,
        'slug' => 'square-silk-earth',
        'name' => 'Square Silk Earth',
        'category' => 'Square',
        'price' => 159000,
        'old_price' => 189000,
        'rating' => 4.9,
        'reviews' => 74,
        'tag' => 'Limited',
        'color' => 'from-[#b99a62] via-[#d2b99b] to-[#6f5146]',
        'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=85',
        'description' => 'Square silk dengan motif earthy yang elegan, lembut, dan nyaman dipakai sepanjang hari.',
    ],
    [
        'id' => 4,
        'slug' => 'inner-jersey-nude',
        'name' => 'Inner Jersey Nude',
        'category' => 'Inner',
        'price' => 59000,
        'old_price' => null,
        'rating' => 4.7,
        'reviews' => 52,
        'tag' => null,
        'color' => 'from-[#d7c1b4] via-[#f4e9dd] to-[#a88b7b]',
        'image' => 'https://images.unsplash.com/photo-1610652492500-ded49ceeb378?auto=format&fit=crop&w=900&q=85',
        'description' => 'Inner jersey yang adem dan elastis untuk membuat hijab tetap rapi dari pagi hingga malam.',
    ],
    [
        'id' => 5,
        'slug' => 'pashmina-cloud-cream',
        'name' => 'Pashmina Cloud Cream',
        'category' => 'Pashmina',
        'price' => 129000,
        'old_price' => null,
        'rating' => 4.8,
        'reviews' => 41,
        'tag' => 'New arrival',
        'color' => 'from-[#f5eadc] via-[#fffaf4] to-[#d8c8b7]',
        'image' => 'https://images.unsplash.com/photo-1605763240000-7e93b172d754?auto=format&fit=crop&w=900&q=85',
        'description' => 'Warna cream yang timeless dengan material flowy untuk tampilan effortless dan bersih.',
    ],
    [
        'id' => 6,
        'slug' => 'voal-mauve-dream',
        'name' => 'Voal Mauve Dream',
        'category' => 'Voal',
        'price' => 109000,
        'old_price' => null,
        'rating' => 4.8,
        'reviews' => 63,
        'tag' => null,
        'color' => 'from-[#c6b3c6] via-[#eee2ec] to-[#8f7895]',
        'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?auto=format&fit=crop&w=900&q=85',
        'description' => 'Voal ringan berwarna mauve yang memberi sentuhan lembut dan modern pada setiap outfit.',
    ],
];

Route::get('/', fn () => view('pages.home', ['products' => $products]))->name('home');

Route::get('/shop', fn () => view('pages.catalog.shop', ['products' => $products]))->name('products.index');
Route::get('/collection', fn () => view('pages.catalog.collection', ['products' => $products]))->name('collection.index');
Route::view('/about', 'pages.catalog.about')->name('about');
Route::view('/contact', 'pages.catalog.contact')->name('contact');
Route::post('/contact', function () {
    request()->validate([
        'name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', 'max:255'],
        'subject' => ['required', 'string', 'max:150'],
        'message' => ['required', 'string', 'max:2000'],
    ]);

    return to_route('contact')->with('status', 'Pesanmu sudah terkirim. Kami akan segera menghubungimu.');
})->name('contact.submit');
Route::get('/shop/{slug}', function (string $slug) use ($products) {
    $product = collect($products)->firstWhere('slug', $slug);

    abort_unless($product, 404);

    return view('pages.catalog.product-show', [
        'product' => $product,
        'relatedProducts' => collect($products)->where('id', '!=', $product['id'])->take(3),
    ]);
})->name('products.show');

Route::view('/cart', 'pages.customer.cart')->name('cart.index');
Route::view('/checkout', 'pages.customer.checkout')->name('checkout.index');
Route::view('/wishlist', 'pages.customer.wishlist')->name('wishlist.index');
Route::view('/profile', 'pages.customer.profile')->name('profile.index');
Route::view('/orders', 'pages.customer.orders')->name('orders.index');
Route::view('/addresses', 'pages.customer.addresses')->name('addresses.index');
Route::view('/help', 'pages.customer.help')->name('help.index');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
