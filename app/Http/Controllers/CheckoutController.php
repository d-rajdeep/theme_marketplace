<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // If cart is empty, send them back to products
        if (empty($cart)) {
            return redirect()->route('products.all')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('frontend.checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('products.all');

        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            // Only require custom_country if they selected 'Other'
            'custom_country' => 'required_if:billing_country,Other|nullable|string|max:100',
        ]);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Logic: Use the custom country if 'Other' is selected
        $final_country = $request->billing_country === 'Other' ? $request->custom_country : $request->billing_country;

        // 1. Create the Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => $total,
            'payment_method' => 'Credit Card / Razorpay',
            'payment_status' => 'completed',
            'billing_name' => $request->billing_name,
            'billing_email' => auth()->user()->email,
            'billing_phone' => $request->billing_phone, // Save the new phone number
            'billing_country' => $final_country, // Save the dynamically chosen country
        ]);

        // 2. Add Items to Order
        foreach ($cart as $id => $details) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
            ]);
        }

        // 3. Clear the Cart
        session()->forget('cart');

        // 4. Redirect to Success Page
        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Payment successful! Your digital products are ready for download.');
    }

    public function success($order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->where('user_id', auth()->id())->firstOrFail();
        return view('frontend.success', compact('order'));
    }

    public function download($itemId)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($itemId);

        if ($orderItem->order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action. You do not own this product.');
        }

        if ($orderItem->order->payment_status !== 'completed') {
            abort(403, 'Payment has not been completed for this order.');
        }

        $product = $orderItem->product;

        if (empty($product->file_path) || !\Illuminate\Support\Facades\Storage::disk('private')->exists($product->file_path)) {
            return back()->with('error', 'File not found. Please contact support.');
        }

        return \Illuminate\Support\Facades\Storage::disk('private')->download(
            $product->file_path,
            $product->slug . '.zip'
        );
    }
}
