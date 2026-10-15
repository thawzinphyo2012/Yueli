@extends('layouts.admin')

@section('title', $customer->name)
@section('heading', 'Customer')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">{{ $customer->name }}</h1>
            <p class="text-sm text-[var(--mist)] mt-1">{{ $customer->email }}</p>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4 text-sm grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div>
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Joined</p>
            <p class="mt-1">{{ $customer->created_at->format('M j, Y') }}</p>
        </div>
        <div>
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Orders</p>
            <p class="mt-1">{{ $customer->orders->count() }}</p>
        </div>
        <div>
            <p class="text-[0.6875rem] uppercase tracking-wider text-[var(--mist)] font-semibold">Email</p>
            <p class="mt-1 truncate">{{ $customer->email }}</p>
        </div>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-[var(--edge)]">
            <h2 class="font-display text-sm font-bold">Order history</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customer->orders as $order)
                        <tr>
                            <td class="font-semibold">{{ $order->order_number }}</td>
                            <td>${{ number_format((float) $order->total, 2) }}</td>
                            <td class="capitalize">{{ $order->status }}</td>
                            <td class="capitalize">{{ $order->payment_status }}</td>
                            <td class="text-[var(--mist)] whitespace-nowrap">{{ $order->created_at->format('M j, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-xs text-[var(--accent)] hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-[var(--mist)] py-8">No orders for this customer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
