@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'Catalog',
        'title'   => 'Edit Category',
        'desc'    => 'Update the details for ' . $category->name,
        'icon'    => 'bi-pencil-square',
        'backUrl' => route('admin.categories.index'),
        'backLabel' => 'Back to categories',
    ])

    <form
        method="POST"
        action="{{ route('admin.categories.update', $category) }}"
        enctype="multipart/form-data"
        class="admin-form-modern"
        data-category-form
    >
        @csrf
        @method('PUT')

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Category Details" icon="bi-layers" desc="The name and slug customers will see in URLs.">
                    @include('admin.partials.text-field', [
                        'name'        => 'name',
                        'label'       => 'Category Name',
                        'value'       => old('name', $category->name),
                        'placeholder' => 'e.g. Outerwear',
                        'required'    => true,
                        'icon'        => 'bi-tag',
                    ])

                    @include('admin.partials.text-field', [
                        'name'        => 'slug',
                        'label'       => 'URL Slug',
                        'value'       => old('slug', $category->slug),
                        'placeholder' => 'auto-generated-from-name',
                        'icon'        => 'bi-link-45deg',
                        'hint'        => 'Auto-generated from the name if left blank.',
                    ])

                    @include('admin.partials.textarea-field', [
                        'name'        => 'description',
                        'label'       => 'Description',
                        'value'       => old('description', $category->description),
                        'rows'        => 4,
                        'placeholder' => 'A short description shown on the category page…',
                        'icon'        => 'bi-text-paragraph',
                    ])
                </x-admin-form-section>

                <x-admin-form-section title="Category Image" icon="bi-image" desc="Replace the cover image used on the homepage.">
                    @if($category->image)
                        <div class="admin-current-image">
                            <div class="admin-current-image-label">
                                <i class="bi bi-image"></i>
                                <span>Current cover</span>
                            </div>
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        </div>
                    @endif

                    @include('admin.partials.file-field', [
                        'name'    => 'image',
                        'label'   => $category->image ? 'Replace Cover Image' : 'Cover Image',
                        'icon'    => 'bi-cloud-arrow-up',
                        'hint'    => 'Recommended 600×800px. Leave empty to keep the current image.',
                    ])
                </x-admin-form-section>

                <div class="admin-form-card-footer">
                    <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn--lg">
                        <i class="bi bi-check2-circle"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>

            <aside class="admin-form-modern-side">

                <x-admin-form-section title="Visibility" icon="bi-eye" desc="Inactive categories are hidden from navigation.">
                    <div class="admin-toggles-stack">
                        @include('admin.partials.toggle-field', [
                            'name'    => 'is_active',
                            'label'   => 'Active',
                            'icon'    => 'bi-check2-circle',
                            'hint'    => 'Customers can browse and filter by this category.',
                            'checked' => old('is_active', $category->is_active),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-bar-chart"></i>
                        <span>Insights</span>
                    </div>
                    <ul class="admin-history">
                        <li>
                            <span>Products in this category</span>
                            <strong>{{ $category->products()->count() }}</strong>
                        </li>
                        <li>
                            <span>Created</span>
                            <strong>{{ $category->created_at->format('d M Y') }}</strong>
                        </li>
                        <li>
                            <span>Last updated</span>
                            <strong>{{ $category->updated_at->diffForHumans() }}</strong>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
