<?php

use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StorefrontController::class, 'home'])->name('home');

Route::get('/shop', [StorefrontController::class, 'shop'])->name('products.index');
Route::get('/collection', [StorefrontController::class, 'collection'])->name('collection.index');
Route::get('/categories', [StorefrontController::class, 'categories'])->name('categories.index');
Route::get('/categories/{slug}', [StorefrontController::class, 'category'])->name('categories.show');
Route::view('/about', 'pages.catalog.about')->name('about');
Route::view('/contact', 'pages.catalog.contact')->name('contact');
Route::post('/contact', [StorefrontController::class, 'submitContact'])->name('contact.submit');
Route::get('/shop/{slug}', [StorefrontController::class, 'product'])->name('products.show');
Route::get('/reviews', [StorefrontController::class, 'reviews'])->name('reviews.index');
Route::get('/chat', [StorefrontController::class, 'chat'])->name('chat.index');
Route::post('/chat', [StorefrontController::class, 'submitChat'])->name('chat.submit');

Route::view('/cart', 'pages.customer.cart')->name('cart.index');
Route::view('/checkout', 'pages.customer.checkout')->name('checkout.index');
Route::view('/wishlist', 'pages.customer.wishlist')->name('wishlist.index');
Route::view('/profile', 'pages.customer.profile')->name('profile.index');
Route::view('/orders', 'pages.customer.orders')->name('orders.index');
Route::view('/addresses', 'pages.customer.addresses')->name('addresses.index');
Route::view('/help', 'pages.customer.help')->name('help.index');
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
