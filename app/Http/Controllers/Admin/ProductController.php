<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products',
            'brand' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $storedImagePaths = [];

        if ($request->hasFile('image')) {
            $primaryPath = $request->file('image')->store('products', 'public');
            $storedImagePaths[] = $primaryPath;
            $validated['image'] = $primaryPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $storedImagePaths[] = $file->store('products', 'public');
            }
        }

        if (!empty($storedImagePaths)) {
            // primary is handled by $validated['image']; products.images holds the full gallery
            $validated['images'] = array_values($storedImagePaths);
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0.01',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'brand' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $existingImages = $product->images ?? [];
        if (!is_array($existingImages)) {
            $existingImages = [];
        }

        $storedGalleryPaths = [];

        if ($request->hasFile('image')) {
            $primaryPath = $request->file('image')->store('products', 'public');
            $validated['image'] = $primaryPath;

            // replace primary in gallery (keep others)
            $storedGalleryPaths[] = $primaryPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $storedGalleryPaths[] = $file->store('products', 'public');
            }
        }

        // If we received any gallery changes, merge/replace accordingly
        if (!empty($storedGalleryPaths)) {
            if (isset($validated['image'])) {
                // if primary replaced, ensure it's first; keep previous gallery excluding old primary
                $oldPrimary = $product->image;
                $filteredExisting = array_values(array_filter($existingImages, fn ($p) => $p && $p !== $oldPrimary));
                $validated['images'] = array_values(array_unique(array_merge([$validated['image']], $filteredExisting, $storedGalleryPaths)));
            } else {
                // primary not changed; append new gallery images
                $validated['images'] = array_values(array_unique(array_merge($existingImages, $storedGalleryPaths)));
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
