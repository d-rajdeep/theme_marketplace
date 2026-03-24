<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FrontendDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all orders for this user with their associated products
        $orders = Order::with('items.product')->where('user_id', $user->id)->latest()->get();

        // Calculate Stats
        $totalOrders = $orders->count();

        // Collect all downloadable items from completed orders
        $downloadableItems = collect();
        foreach ($orders as $order) {
            if ($order->payment_status === 'completed') {
                foreach ($order->items as $item) {
                    // Only add if the product hasn't been deleted
                    if ($item->product) {
                        $downloadableItems->push($item);
                    }
                }
            }
        }

        $totalDownloads = $downloadableItems->count();

        return view('frontend.dashboard', compact('user', 'orders', 'totalOrders', 'totalDownloads', 'downloadableItems'));
    }
}
