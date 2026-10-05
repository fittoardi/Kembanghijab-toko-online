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
