@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'Inventory',
        'title'   => 'Edit Product',
        'desc'    => 'Update the details for ' . $product->name,
        'icon'    => 'bi-pencil-square',
        'backUrl' => route('admin.products.index'),
        'backLabel' => 'Back to products',
    ])

    <form
        method="POST"
        action="{{ route('admin.products.update', $product) }}"
        enctype="multipart/form-data"
        class="admin-form-modern"
        data-product-form
    >
        @csrf
        @method('PUT')

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Basic Information" icon="bi-info-circle" desc="The name and category shown to customers.">
                    @include('admin.partials.text-field', [
                        'name'        => 'name',
                        'label'       => 'Product Name',
                        'value'       => old('name', $product->name),
                        'placeholder' => 'e.g. Heritage Linen Overshirt',
                        'required'    => true,
                        'icon'        => 'bi-tag',
                    ])

                    @include('admin.partials.select-field', [
                        'name'        => 'category_id',
                        'label'       => 'Category',
                        'options'     => $categories->pluck('name', 'id'),
                        'value'       => old('category_id', $product->category_id),
                        'placeholder' => 'Select a category…',
                        'required'    => true,
                        'icon'        => 'bi-grid-3x3-gap',
                    ])
                </x-admin-form-section>

                <x-admin-form-section title="Descriptions" icon="bi-text-paragraph" desc="Tell the story behind the product.">
                    @include('admin.partials.text-field', [
                        'name'        => 'short_description',
                        'label'       => 'Short Description',
                        'value'       => old('short_description', $product->short_description),
                        'placeholder' => 'A one-liner that appears on product cards',
                        'icon'        => 'bi-card-text',
                        'hint'        => 'Up to 160 characters. Shown on product tiles and search results.',
                    ])

                    @include('admin.partials.textarea-field', [
                        'name'        => 'description',
                        'label'       => 'Full Description',
                        'value'       => old('description', $product->description),
                        'rows'        => 7,
                        'placeholder' => 'Describe the fabric, fit, story, and any care instructions…',
                        'icon'        => 'bi-journal-text',
                        'counter'     => 2000,
                    ])
                </x-admin-form-section>

                <x-admin-form-section title="Pricing & Stock" icon="bi-currency-rupee" desc="How much it costs and how much you have on hand.">
                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'        => 'price',
                            'type'        => 'number',
                            'label'       => 'Price',
                            'value'       => old('price', $product->price),
                            'prefix'      => '₹',
                            'placeholder' => '0.00',
                            'required'    => true,
                            'icon'        => 'bi-cash',
                            'step'        => '0.01',
                            'min'         => '0',
                        ])

                        @include('admin.partials.text-field', [
                            'name'        => 'discount_percentage',
                            'type'        => 'number',
                            'label'       => 'Discount',
                            'value'       => old('discount_percentage', $product->discount_percentage),
                            'suffix'      => '%',
                            'placeholder' => '0',
                            'icon'        => 'bi-percent',
                            'step'        => '0.01',
                            'min'         => '0',
                            'max'         => '100',
                            'hint'        => 'Optional. Sale price = price × (1 − discount/100).',
                        ])
                    </div>

                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'        => 'stock',
                            'type'        => 'number',
                            'label'       => 'Stock Quantity',
                            'value'       => old('stock', $product->stock),
                            'placeholder' => '0',
                            'required'    => true,
                            'icon'        => 'bi-box-seam',
                            'min'         => '0',
                        ])

                        @include('admin.partials.text-field', [
                            'name'        => 'sku',
                            'label'       => 'SKU',
                            'value'       => old('sku', $product->sku),
                            'placeholder' => 'e.g. ADG-LIN-001',
                            'required'    => true,
                            'icon'        => 'bi-upc-scan',
                            'hint'        => 'Unique stock-keeping unit for inventory tracking.',
                        ])
                    </div>

                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'        => 'brand',
                            'label'       => 'Brand',
                            'value'       => old('brand', $product->brand),
                            'placeholder' => 'e.g. Adgon',
                            'icon'        => 'bi-bookmark-star',
                        ])
                    </div>
                </x-admin-form-section>

                <x-admin-form-section title="Imagery" icon="bi-image" desc="Replace the primary image or add to the gallery.">
                    @include('admin.partials.file-field', [
                        'name'    => 'image',
                        'label'   => 'Replace Primary Image',
                        'icon'    => 'bi-cloud-arrow-up',
                        'preview' => $product->image ?? null,
                        'hint'    => 'Leave empty to keep the current image. Recommended 1200×1500px.',
                    ])

                    @php
                        $galleryImages = is_array($product->images) ? $product->images : (is_string($product->images) ? json_decode($product->images, true) : []);
                        $galleryImages = is_array($galleryImages) ? array_values(array_filter($galleryImages)) : [];
                    @endphp
                    @include('admin.partials.file-field', [
                        'name'     => 'images',
                        'label'    => 'Add to Gallery',
                        'icon'     => 'bi-images',
                        'multiple' => true,
                        'hint'     => 'Uploading here will add to the existing gallery. Delete individual images from the product page.',
                    ])

                    @if(! empty($galleryImages))
                        <div class="admin-gallery-current">
                            <div class="admin-gallery-current-label">
                                <i class="bi bi-images"></i>
                                <span>Current gallery ({{ count($galleryImages) }})</span>
                            </div>
                            <div class="admin-gallery-current-grid">
                                @foreach($galleryImages as $img)
                                    <div class="admin-gallery-current-item">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Gallery image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </x-admin-form-section>

                <div class="admin-form-card-footer">
                    <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn--lg">
                        <i class="bi bi-check2-circle"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>

            <aside class="admin-form-modern-side">

                <x-admin-form-section title="Visibility" icon="bi-eye" desc="Control how this product appears on the storefront.">
                    <div class="admin-toggles-stack">
                        @include('admin.partials.toggle-field', [
                            'name'    => 'is_featured',
                            'label'   => 'Featured Product',
                            'icon'    => 'bi-star-fill',
                            'hint'    => 'Highlights this on the homepage and category tops.',
                            'checked' => old('is_featured', $product->is_featured),
                        ])

                        @include('admin.partials.toggle-field', [
                            'name'    => 'is_active',
                            'label'   => 'Active',
                            'icon'    => 'bi-check2-circle',
                            'hint'    => 'Inactive products are hidden from the storefront.',
                            'checked' => old('is_active', $product->is_active),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-clock-history"></i>
                        <span>History</span>
                    </div>
                    <ul class="admin-history">
                        <li>
                            <span>Created</span>
                            <strong>{{ $product->created_at->format('d M Y, H:i') }}</strong>
                        </li>
                        <li>
                            <span>Last updated</span>
                            <strong>{{ $product->updated_at->diffForHumans() }}</strong>
                        </li>
                        <li>
                            <span>Reviews</span>
                            <strong>{{ $product->reviews()->count() }} {{ \Illuminate\Support\Str::plural('review', $product->reviews()->count()) }}</strong>
                        </li>
                        <li>
                            <span>Avg. rating</span>
                            <strong>
                                @php
                                    $rc = $product->reviews()->count();
                                    $avg = $rc > 0 ? round($product->reviews()->avg('rating'), 1) : '—';
                                @endphp
                                {{ $avg }}{{ $rc > 0 ? ' / 5' : '' }}
                            </strong>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
