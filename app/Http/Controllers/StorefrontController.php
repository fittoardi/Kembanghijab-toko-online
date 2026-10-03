<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function home()
    {
        return view('pages.home', ['products' => $this->products()]);
    }

    public function shop()
    {
        return view('pages.catalog.shop', ['products' => $this->products()]);
    }

    public function collection()
    {
        return view('pages.catalog.collection', ['products' => $this->products()]);
    }

    public function product(string $slug)
    {
        $products = collect($this->products());
        $product = $products->firstWhere('slug', $slug);

        abort_unless($product, 404);

        return view('pages.catalog.product-show', [
            'product' => $product,
            'relatedProducts' => $products->where('id', '!=', $product['id'])->take(3),
        ]);
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return to_route('contact')->with('status', 'Pesanmu sudah terkirim. Kami akan segera menghubungimu.');
    }

    private function products(): array
    {
        return config('storefront.products', []);
    }
}
