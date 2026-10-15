<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PortfolioProject;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'customerCount' => User::where('is_admin', false)->count(),
            'projectCount' => PortfolioProject::count(),
            'recentOrders' => Order::latest()->take(6)->get(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total')
                ?: Order::whereIn('status', ['processing', 'shipped', 'completed'])->sum('total'),
        ]);
    }
}
