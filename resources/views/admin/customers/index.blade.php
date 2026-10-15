@extends('layouts.admin')

@section('title', 'Customers')
@section('heading', 'Customers')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold tracking-tight">Customers</h1>
        <p class="text-sm text-[var(--mist)] mt-1">Registered accounts & guest checkouts</p>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-[var(--edge)]">
            <h2 class="font-display text-sm font-bold">Registered</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="font-semibold">{{ $customer->name }}</td>
                            <td class="text-[var(--mist)]">{{ $customer->email }}</td>
                            <td>{{ $customer->orders_count }}</td>
                            <td class="text-[var(--mist)] whitespace-nowrap">{{ $customer->created_at->format('M j, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="text-xs text-[var(--accent)] hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-[var(--mist)] py-8">No registered customers.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $customers->links() }}</div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="px-4 py-3 border-b border-[var(--edge)]">
            <h2 class="font-display text-sm font-bold">Guest checkouts</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Orders</th>
                        <th>Last order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guestOrders as $guest)
                        <tr>
                            <td class="font-semibold">{{ $guest->customer_name }}</td>
                            <td class="text-[var(--mist)]">{{ $guest->customer_email }}</td>
                            <td>{{ $guest->orders_count }}</td>
                            <td class="text-[var(--mist)] whitespace-nowrap">
                                {{ $guest->last_order_at ? \Illuminate\Support\Carbon::parse($guest->last_order_at)->format('M j, Y') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-[var(--mist)] py-8">No guest orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
