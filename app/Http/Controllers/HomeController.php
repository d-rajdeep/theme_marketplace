<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.home', compact('featuredProducts'));
    }

    public function allProducts(Request $request)
    {
        $query = Product::with('category')
            ->where('status', 'active');

        // Filter by category
        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by type
        if ($request->type && in_array($request->type, ['theme', 'plugin', 'template'])) {
            $query->where('type', $request->type);
        }

        // Filter by price
        if ($request->min) {
            $query->where('price', '>=', $request->min);
        }
        if ($request->max) {
            $query->where('price', '<=', $request->max);
        }

        // Sort by
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('downloads_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        $categories = Category::withCount(['products' => function ($query) {
            $query->where('status', 'active');
        }])->having('products_count', '>', 0)->get();

        return view('frontend.products.all', compact('products', 'categories'));
    }

    public function show($category_slug, $product_slug)
    {
        $product = Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where('slug', $product_slug)
            ->whereHas('category', function ($query) use ($category_slug) {
                $query->where('slug', $category_slug);
            })
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('status', 'active')
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.products.product', compact('product', 'relatedProducts'));
    }
}
