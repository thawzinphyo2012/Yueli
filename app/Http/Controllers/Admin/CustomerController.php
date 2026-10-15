<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = User::query()
            ->where('is_admin', false)
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        $guestOrders = Order::query()
            ->whereNull('user_id')
            ->selectRaw('customer_email, customer_name, COUNT(*) as orders_count, MAX(created_at) as last_order_at')
            ->groupBy('customer_email', 'customer_name')
            ->orderByDesc('last_order_at')
            ->limit(50)
            ->get();

        return view('admin.customers.index', compact('customers', 'guestOrders'));
    }

    public function show(User $customer): View
    {
        abort_if($customer->is_admin, 404);

        $customer->load(['orders' => fn ($q) => $q->latest()]);

        return view('admin.customers.show', compact('customer'));
    }
}
