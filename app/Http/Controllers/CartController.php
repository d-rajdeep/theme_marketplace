<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 1. Show the Cart Page
    public function index()
    {
        $cart = session()->get('cart', []);

        // Calculate Total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('frontend.cart', compact('cart', 'total'));
    }

    // 2. Add Item to Cart via AJAX
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // If item already exists in cart, update the quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            // Otherwise, add the new item to the cart array
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $request->quantity,
                "price" => $product->price,
                "thumbnail" => $product->thumbnail,
                "type" => $product->type
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cartCount' => count(session('cart'))
        ]);
    }

    // 3. Remove Item from Cart
    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        }
    }
}
