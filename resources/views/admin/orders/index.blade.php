@extends('layouts.admin')

@section('title', 'Orders')
@section('heading', 'Orders')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Orders</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Fulfillment queue</p>
        </div>
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2">
            <select name="status" class="admin-input w-auto" onchange="this.form.submit()">
                <option value="">All statuses</option>
                @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="font-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td class="text-[var(--mist)]">{{ $order->customer_email }}</td>
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
                            <td colspan="8" class="text-center text-[var(--mist)] py-8">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $orders->links() }}</div>
</div>
@endsection
