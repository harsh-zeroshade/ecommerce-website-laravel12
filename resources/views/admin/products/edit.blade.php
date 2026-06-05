@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Inventory</span>
        <h1>Edit Product</h1>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body padded">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="admin-form">
            @csrf
            @method('PUT')

            <div class="admin-field">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="admin-field">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="short_description">Short Description</label>
                <input type="text" id="short_description" name="short_description" value="{{ old('short_description', $product->short_description) }}">
            </div>

            <div class="admin-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="price">Price (₹)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="admin-field">
                    <label for="discount_percentage">Discount %</label>
                    <input type="number" step="0.01" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', $product->discount_percentage) }}">
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="admin-field">
                    <label for="sku">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                </div>
                <div class="admin-field">
                    <label for="image">Primary Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*">

                    @if($product->image)
                        <small style="color:var(--admin-muted); display:block; margin-top:0.5rem;">Current primary image</small>
                        <div style="margin-top:0.75rem;">
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="Current primary image"
                                style="width:120px; height:90px; object-fit:cover; border-radius:10px;"
                            >
                        </div>
                    @endif
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field" style="grid-column: 1 / -1;">
                    <label for="images">Additional Product Images (Gallery)</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>

                    @php
                        $galleryImages = is_array($product->images) ? $product->images : (is_string($product->images) ? json_decode($product->images, true) : []);
                        $galleryImages = is_array($galleryImages) ? $galleryImages : [];
                    @endphp

                    @if(!empty($galleryImages))
                        <div style="margin-top:1rem;">
                            <div style="color:var(--admin-muted); margin-bottom:0.5rem;">Current gallery</div>
                            <div style="display:flex; flex-wrap:wrap; gap:0.75rem;">
                                @foreach($galleryImages as $img)
                                    <div>
                                        <img
                                            src="{{ asset('storage/' . $img) }}"
                                            alt="Gallery image"
                                            style="width:110px; height:80px; object-fit:cover; border-radius:10px;"
                                        >
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <label class="admin-checkbox">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                Featured Product
            </label>

            <label class="admin-checkbox">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                Active
            </label>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
