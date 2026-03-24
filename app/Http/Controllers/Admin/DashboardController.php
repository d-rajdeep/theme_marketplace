<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'    => User::where('role', 'user')->count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            // FIXED: Changed 'status' to 'payment_status' and 'paid' to 'completed'
            'total_revenue'  => Order::where('payment_status', 'completed')->sum('total_amount'),
            'total_categories' => Category::count(),
            'recent_orders'  => Order::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
