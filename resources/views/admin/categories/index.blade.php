@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Catalog</span>
        <h1>Categories</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn-primary">
        <i class="bi bi-plus-lg"></i> Add Category
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Products</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td>{{ $category->products_count }}</td>
                        <td><span class="text-muted">{{ Str::limit($category->description, 50) }}</span></td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $category->is_active ? 'success' : 'muted' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="admin-btn-group">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">No categories found. <a href="{{ route('admin.categories.create') }}" style="color:var(--admin-gold);">Add your first category</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($categories->hasPages())
<div class="admin-pagination">
    {{ $categories->links() }}
</div>
@endif
@endsection
