@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'Catalog',
        'title'   => 'Add Category',
        'desc'    => 'Create a new category to organize your products.',
        'icon'    => 'bi-layers',
        'backUrl' => route('admin.categories.index'),
        'backLabel' => 'Back to categories',
    ])

    <form
        method="POST"
        action="{{ route('admin.categories.store') }}"
        enctype="multipart/form-data"
        class="admin-form-modern"
        data-category-form
    >
        @csrf

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Category Details" icon="bi-layers" desc="The name and slug customers will see in URLs.">
                    @include('admin.partials.text-field', [
                        'name'        => 'name',
                        'label'       => 'Category Name',
                        'placeholder' => 'e.g. Outerwear',
                        'required'    => true,
                        'icon'        => 'bi-tag',
                    ])

                    @include('admin.partials.text-field', [
                        'name'        => 'slug',
                        'label'       => 'URL Slug',
                        'placeholder' => 'auto-generated-from-name',
                        'icon'        => 'bi-link-45deg',
                        'hint'        => 'Auto-generated from the name if left blank. Use lowercase letters, numbers and hyphens.',
                    ])

                    @include('admin.partials.textarea-field', [
                        'name'        => 'description',
                        'label'       => 'Description',
                        'rows'        => 4,
                        'placeholder' => 'A short description shown on the category page…',
                        'icon'        => 'bi-text-paragraph',
                    ])
                </x-admin-form-section>

                <x-admin-form-section title="Category Image" icon="bi-image" desc='Shown on the homepage "Shop by category" section.'>
                    @include('admin.partials.file-field', [
                        'name'  => 'image',
                        'label' => 'Cover Image',
                        'icon'  => 'bi-cloud-arrow-up',
                        'hint'  => 'Recommended 600×800px. JPG, PNG or WebP.',
                    ])
                </x-admin-form-section>

                <div class="admin-form-card-footer">
                    <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn--lg">
                        <i class="bi bi-check2-circle"></i>
                        <span>Create Category</span>
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
                            'checked' => old('is_active', true),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-lightbulb"></i>
                        <span>Tips</span>
                    </div>
                    <ul class="admin-tips">
                        <li><i class="bi bi-check2"></i> Keep names short and shoppable</li>
                        <li><i class="bi bi-check2"></i> Use a clear hero image (600×800)</li>
                        <li><i class="bi bi-check2"></i> Slug changes may break existing links</li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
