<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop.index')->with('error', 'Your bag is empty.');
        }

        $shippingFee = (float) (\App\Models\Setting::get('shipping_fee', 5));

        return view('storefront.checkout', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'shippingFee' => $shippingFee,
            'total' => $this->cart->subtotal() + $shippingFee,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop.index');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:40'],
            'shipping_address' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:120'],
            'shipping_country' => ['required', 'string', 'max:120'],
            'shipping_postal' => ['nullable', 'string', 'max:40'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash_on_delivery,bank_transfer'],
        ]);

        $shippingFee = (float) (\App\Models\Setting::get('shipping_fee', 5));
        $items = $this->cart->items();
        $subtotal = $this->cart->subtotal();

        $order = DB::transaction(function () use ($data, $items, $subtotal, $shippingFee, $request) {
            $order = Order::create([
                ...$data,
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $request->user()?->id,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $subtotal + $shippingFee,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);

                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        $this->cart->clear();

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully.');
    }

    public function success(Order $order): View
    {
        $order->load('items');

        return view('storefront.checkout-success', compact('order'));
    }
}
