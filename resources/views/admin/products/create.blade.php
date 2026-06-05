@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Inventory</span>
        <h1>Create Product</h1>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body padded">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="admin-field">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="admin-field">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="admin-field">
                <label for="short_description">Short Description</label>
                <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}">
            </div>

            <div class="admin-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5">{{ old('description') }}</textarea>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="price">Price (₹)</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="discount_percentage">Discount %</label>
                    <input type="number" step="0.01" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', 0) }}">
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                </div>
                <div class="admin-field">
                    <label for="sku">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required>
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}">
                </div>

                <div class="admin-field">
                    <label for="image">Primary Product Image</label>
                    <input type="file" id="image" name="image" accept="image/*">

                    <div id="primaryImagePreview" style="margin-top:0.75rem; display:none;">
                        <div style="color:var(--admin-muted); margin-bottom:0.5rem;">Preview</div>
                        <img id="primaryImagePreviewImg" src="" alt="Primary image preview"
                             style="width:120px; height:90px; object-fit:cover; border-radius:10px;">
                    </div>
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field" style="grid-column: 1 / -1;">
                    <label for="images">Additional Product Images</label>
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>

                    <small style="color:var(--admin-muted); display:block; margin-top:0.5rem;">Upload multiple images for the product gallery.</small>

                    <div id="additionalImagesPreview" style="margin-top:1rem; display:none;">
                        <div style="color:var(--admin-muted); margin-bottom:0.5rem;">Preview</div>
                        <div id="additionalImagesPreviewGrid" style="display:flex; flex-wrap:wrap; gap:0.75rem;"></div>
                    </div>
                </div>
            </div>

            <label class="admin-checkbox">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                Featured Product
            </label>

            <div class="admin-form-actions">
                <button type="submit" class="admin-btn admin-btn-primary">Create Product</button>
                <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const primaryInput = document.getElementById('image');
        const primaryPreview = document.getElementById('primaryImagePreview');
        const primaryPreviewImg = document.getElementById('primaryImagePreviewImg');

        if (primaryInput && primaryPreview && primaryPreviewImg) {
            primaryInput.addEventListener('change', function () {
                const file = primaryInput.files && primaryInput.files[0];
                if (!file) {
                    primaryPreview.style.display = 'none';
                    primaryPreviewImg.src = '';
                    return;
                }
                primaryPreviewImg.src = URL.createObjectURL(file);
                primaryPreview.style.display = 'block';
            });
        }

        const galleryInput = document.getElementById('images');
        const additionalPreview = document.getElementById('additionalImagesPreview');
        const additionalGrid = document.getElementById('additionalImagesPreviewGrid');

        if (galleryInput && additionalPreview && additionalGrid) {
            galleryInput.addEventListener('change', function () {
                const files = galleryInput.files ? Array.from(galleryInput.files) : [];
                additionalGrid.innerHTML = '';

                if (files.length === 0) {
                    additionalPreview.style.display = 'none';
                    return;
                }

                files.forEach((file) => {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.alt = 'Additional image preview';
                    img.style.width = '110px';
                    img.style.height = '80px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '10px';
                    additionalGrid.appendChild(img);
                });

                additionalPreview.style.display = 'block';
            });
        }
    })();
</script>

@endsection
