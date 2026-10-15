@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold tracking-tight">Dashboard</h1>
        <p class="text-sm text-[var(--mist)] mt-1">Studio overview</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4">
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Products</p>
            <p class="font-display text-2xl font-bold mt-1">{{ number_format($productCount) }}</p>
        </div>
        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4">
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Orders</p>
            <p class="font-display text-2xl font-bold mt-1">{{ number_format($orderCount) }}</p>
        </div>
        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4">
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Customers</p>
            <p class="font-display text-2xl font-bold mt-1">{{ number_format($customerCount) }}</p>
        </div>
        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4">
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Projects</p>
            <p class="font-display text-2xl font-bold mt-1">{{ number_format($projectCount) }}</p>
        </div>
        <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4 col-span-2 lg:col-span-1">
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Revenue</p>
            <p class="font-display text-2xl font-bold mt-1">${{ number_format((float) $revenue, 2) }}</p>
        </div>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-[var(--edge)] flex items-center justify-between">
            <h2 class="font-display text-sm font-bold">Recent orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-[var(--accent)] hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-[var(--accent)] hover:underline font-semibold">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ number_format((float) $order->total, 2) }}</td>
                            <td class="capitalize">{{ $order->status }}</td>
                            <td class="capitalize">{{ $order->payment_status }}</td>
                            <td class="text-[var(--mist)] whitespace-nowrap">{{ $order->created_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-[var(--mist)] text-center py-8">No orders yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
