@extends('layouts.admin')

@section('title', 'Order '.$order->order_number)
@section('heading', 'Order detail')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">{{ $order->order_number }}</h1>
            <p class="text-sm text-[var(--mist)] mt-1">{{ $order->created_at->format('F j, Y · g:i A') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-[var(--edge)]">
                    <h2 class="font-display text-sm font-bold">Line items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="font-semibold">{{ $item->product_name }}</td>
                                    <td>{{ $item->size ?: '—' }}</td>
                                    <td>{{ $item->color ?: '—' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                                    <td>${{ number_format((float) $item->line_total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-[var(--edge)] text-sm space-y-1">
                    <div class="flex justify-between text-[var(--mist)]">
                        <span>Subtotal</span>
                        <span>${{ number_format((float) $order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[var(--mist)]">
                        <span>Shipping</span>
                        <span>${{ number_format((float) $order->shipping_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-[var(--paper)] pt-1">
                        <span>Total</span>
                        <span>${{ number_format((float) $order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4 space-y-2 text-sm">
                <h2 class="font-display text-sm font-bold mb-3">Customer & shipping</h2>
                <p><span class="text-[var(--mist)]">Name:</span> {{ $order->customer_name }}</p>
                <p><span class="text-[var(--mist)]">Email:</span> {{ $order->customer_email }}</p>
                <p><span class="text-[var(--mist)]">Phone:</span> {{ $order->customer_phone ?: '—' }}</p>
                <p><span class="text-[var(--mist)]">Address:</span> {{ $order->shipping_address }}</p>
                <p><span class="text-[var(--mist)]">City:</span> {{ $order->shipping_city }} · {{ $order->shipping_country }} {{ $order->shipping_postal }}</p>
                @if ($order->notes)
                    <p class="pt-2 border-t border-[var(--edge)]"><span class="text-[var(--mist)]">Notes:</span> {{ $order->notes }}</p>
                @endif
                <p><span class="text-[var(--mist)]">Payment method:</span> {{ $order->payment_method ?: '—' }}</p>
            </div>
        </div>

        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4 h-fit">
            <h2 class="font-display text-sm font-bold mb-4">Update status</h2>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="admin-label" for="status">Order status</label>
                    <select id="status" name="status" class="admin-input" required>
                        @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="admin-label" for="payment_status">Payment status</label>
                    <select id="payment_status" name="payment_status" class="admin-input" required>
                        @foreach (['pending', 'paid', 'failed', 'refunded'] as $paymentStatus)
                            <option value="{{ $paymentStatus }}" @selected(old('payment_status', $order->payment_status) === $paymentStatus)>{{ ucfirst($paymentStatus) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="admin-btn w-full justify-center">Save changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
