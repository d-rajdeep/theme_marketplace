<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:theme,plugin,template',
            'status'      => 'required|in:active,inactive',
            'demo_url'    => 'nullable|url',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file'        => 'nullable|file|mimes:zip|max:51200',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle thumbnail upload
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('products/thumbnails', 'public');
        }

        // Handle downloadable file upload
        $filePath = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filePath = $request->file('file')
                ->store('products/files', 'private');
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'type'        => $request->type,
            'status'      => $request->status,
            'demo_url'    => $request->demo_url,
            'thumbnail'   => $thumbnailPath,
            'file_path'   => $filePath,
        ]);

        // Handle extra product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products/images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'type'        => 'required|in:theme,plugin,template',
            'status'      => 'required|in:active,inactive',
            'demo_url'    => 'nullable|url',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file'        => 'nullable|file|mimes:zip|max:51200',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'type'        => $request->type,
            'status'      => $request->status,
            'demo_url'    => $request->demo_url,
        ];

        // Handle new thumbnail safely
        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            $oldThumbnail = trim((string) $product->thumbnail);
            if ($oldThumbnail !== '') {
                Storage::disk('public')->delete($oldThumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        // Handle new downloadable file safely
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $oldFile = trim((string) $product->file_path);
            if ($oldFile !== '') {
                Storage::disk('private')->delete($oldFile);
            }
            $data['file_path'] = $request->file('file')->store('products/files', 'private');
        }

        $product->update($data);

        // Handle new extra images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image && $image->isValid()) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $image->store('products/images', 'public'),
                        'is_primary' => false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // 1. Safely delete thumbnail
        $thumbnail = trim((string) $product->thumbnail);
        if ($thumbnail !== '') {
            Storage::disk('public')->delete($thumbnail);
        }

        // 2. Safely delete downloadable file
        $filePath = trim((string) $product->file_path);
        if ($filePath !== '') {
            Storage::disk('private')->delete($filePath);
        }

        // 3. Safely delete associated gallery images
        foreach ($product->images as $image) {
            $imagePath = trim((string) $image->image_path);
            if ($imagePath !== '') {
                Storage::disk('public')->delete($imagePath);
            }
            $image->delete();
        }

        // 4. Finally, delete the product record
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
