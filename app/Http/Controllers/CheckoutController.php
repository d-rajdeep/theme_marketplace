<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api; // <-- REQUIRED FOR RAZORPAY

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.all')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // 1. Initialize Razorpay API
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // 2. Create a Razorpay Order
        $razorpayOrder = $api->order->create([
            'receipt'         => 'rcptid_' . Str::random(10),
            'amount'          => $total * 100, // Razorpay uses paise (multiply by 100)
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto capture
        ]);

        $razorpayOrderId = $razorpayOrder['id'];

        return view('frontend.checkout', compact('cart', 'total', 'razorpayOrderId'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('products.all');

        // 1. Validate incoming data (including hidden Razorpay fields)
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_country' => 'required|string|max:100',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        // 2. Verify the Signature to prevent fraud
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $attributes = array(
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            );
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return back()->with('error', 'Payment verification failed. Please try again.');
        }

        // 3. Signature is valid! Create the Order
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        $final_country = $request->billing_country === 'Other' ? $request->custom_country : $request->billing_country;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => $total,
            'payment_method' => 'Razorpay',
            'payment_status' => 'completed',
            'transaction_id' => $request->razorpay_payment_id, // Save the Razorpay ID
            'billing_name' => $request->billing_name,
            'billing_email' => auth()->user()->email,
            'billing_phone' => $request->billing_phone,
            'billing_country' => $final_country,
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'price' => $details['price'],
                'quantity' => $details['quantity'],
            ]);
        }

        session()->forget('cart');

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
