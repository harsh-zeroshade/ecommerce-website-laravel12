@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'Inventory',
        'title'   => 'Create Product',
        'desc'    => 'Add a new piece to your catalog. Fill in the essentials, then layer in pricing, stock, and imagery.',
        'icon'    => 'bi-plus-square',
        'backUrl' => route('admin.products.index'),
        'backLabel' => 'Back to products',
    ])

    <form
        method="POST"
        action="{{ route('admin.products.store') }}"
        enctype="multipart/form-data"
        class="admin-form-modern"
        data-product-form
    >
        @csrf

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Basic Information" icon="bi-info-circle" desc="The name and category shown to customers.">
                    @include('admin.partials.text-field', [
                        'name'        => 'name',
                        'label'       => 'Product Name',
                        'placeholder' => 'e.g. Heritage Linen Overshirt',
                        'required'    => true,
                        'icon'        => 'bi-tag',
                    ])

                    @include('admin.partials.select-field', [
                        'name'        => 'category_id',
                        'label'       => 'Category',
                        'options'     => $categories->pluck('name', 'id'),
                        'placeholder' => 'Select a category…',
                        'required'    => true,
                        'icon'        => 'bi-grid-3x3-gap',
                    ])
                </x-admin-form-section>

                <x-admin-form-section title="Descriptions" icon="bi-text-paragraph" desc="Tell the story behind the product.">
                    @include('admin.partials.text-field', [
                        'name'        => 'short_description',
                        'label'       => 'Short Description',
                        'placeholder' => 'A one-liner that appears on product cards',
                        'icon'        => 'bi-card-text',
                        'hint'        => 'Up to 160 characters. Shown on product tiles and search results.',
                    ])

                    @include('admin.partials.textarea-field', [
                        'name'        => 'description',
                        'label'       => 'Full Description',
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
                            'placeholder' => '0',
                            'required'    => true,
                            'icon'        => 'bi-box-seam',
                            'min'         => '0',
                        ])

                        @include('admin.partials.text-field', [
                            'name'        => 'sku',
                            'label'       => 'SKU',
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
                            'placeholder' => 'e.g. Adgon',
                            'icon'        => 'bi-bookmark-star',
                        ])
                    </div>
                </x-admin-form-section>

                <x-admin-form-section title="Imagery" icon="bi-image" desc="Drop in a primary image and any extra gallery shots.">
                    @include('admin.partials.file-field', [
                        'name'   => 'image',
                        'label'  => 'Primary Product Image',
                        'icon'   => 'bi-cloud-arrow-up',
                        'hint'   => 'Recommended 1200×1500px (4:5). JPG, PNG or WebP. Max 5MB.',
                    ])

                    @include('admin.partials.file-field', [
                        'name'     => 'images',
                        'label'    => 'Gallery Images',
                        'icon'     => 'bi-images',
                        'multiple' => true,
                        'hint'     => 'Upload multiple images for the product gallery. Drag to reorder on the storefront.',
                    ])
                </x-admin-form-section>

                <div class="admin-form-card-footer">
                    <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-outline">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn--lg">
                        <i class="bi bi-check2-circle"></i>
                        <span>Create Product</span>
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
                            'checked' => old('is_featured', false),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-lightbulb"></i>
                        <span>Tips for great listings</span>
                    </div>
                    <ul class="admin-tips">
                        <li><i class="bi bi-check2"></i> Use a clear, descriptive product name</li>
                        <li><i class="bi bi-check2"></i> Add 3–5 high-quality gallery images</li>
                        <li><i class="bi bi-check2"></i> Keep the short description under 160 chars</li>
                        <li><i class="bi bi-check2"></i> Set stock to <code>0</code> to hide without deleting</li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
