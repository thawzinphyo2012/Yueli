<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index(): View
    {
        return view('storefront.cart', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'size' => ['nullable', 'string', 'max:20'],
            'color' => ['nullable', 'string', 'max:40'],
        ]);

        $product = Product::query()->where('is_published', true)->findOrFail($data['product_id']);

        $this->cart->add(
            $product,
            $data['quantity'] ?? 1,
            $data['size'] ?? null,
            $data['color'] ?? null
        );

        return redirect()->route('cart.index')->with('success', 'Added to bag.');
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $this->cart->update($key, $data['quantity']);

        return back()->with('success', 'Bag updated.');
    }

    public function destroy(string $key): RedirectResponse
    {
        $this->cart->remove($key);

        return back()->with('success', 'Item removed.');
    }
}
