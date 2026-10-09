<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the storefront product page returns a successful response', function () {
    $response = $this->get('/shop/pashmina-satin-moonlight');

    $response->assertStatus(200);
});

test('the category, review, and chat pages are available', function () {
    $this->get('/categories')->assertOk();
    $this->get('/categories/pashmina')->assertOk();
    $this->get('/reviews')->assertOk();
    $this->get('/chat')->assertOk();
});

test('a customer can add an item and reach checkout', function () {
    $this->post('/cart/items', [
        'slug' => 'pashmina-satin-moonlight',
        'quantity' => 2,
    ])->assertRedirect('/cart');

    $this->get('/cart')->assertOk()->assertSee('Pashmina Satin Moonlight');
    $this->get('/checkout')->assertOk()->assertSee('Secure checkout');
});

test('the home, about, and not found pages render their customer shell', function () {
    $this->get('/')->assertOk()->assertSee('Wear your own rhythm.');
    $this->get('/about')->assertOk()->assertSee('Make room for every version of you.');
    $this->get('/missing-page')->assertNotFound()->assertSee('This page took a different turn.');
});
