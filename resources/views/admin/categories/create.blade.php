@extends('layouts.admin')

@section('title', 'Add Category')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Catalog Management</span>
        <h1>Add New Category</h1>
        <p style="margin-top:0.5rem; color:var(--text-muted); font-size:0.95rem;">
            Create a new product category for your store.
        </p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">
        <i class="bi bi-arrow-left" style="margin-right:0.35rem;"></i> Back
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header" style="padding:1.5rem; background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%); border-bottom:1px solid var(--border);">
        <h3 style="font-size:1rem; font-weight:600; color:var(--text);">Category Details</h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}" style="padding:0 1.5rem;">
            @csrf

            <div class="admin-field">
                <label for="name">Category Name <span style="color:#d97706;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                <small style="color:var(--text-muted);">Use clear, descriptive names (e.g., "Men's Clothing")</small>
                @error('name')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
            </div>

            <div class="admin-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>
                <small style="color:var(--text-muted);">Add details about what products belong in this category</small>
                @error('description')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
            </div>

            <div class="admin-field">
                <label for="slug">URL Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}">
                <small style="color:var(--text-muted);">Auto-generated if empty. Used for URLs (e.g., /shop/mens-clothing)</small>
                @error('slug')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:1.75rem 0;">

            <div class="admin-field">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                    <span>Active (Available for customers)</span>
                </label>
            </div>

            <div class="admin-form-actions" style="margin-top:2rem; padding-bottom:1.5rem;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="bi bi-plus-lg" style="margin-right:0.5rem;"></i>Create Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
