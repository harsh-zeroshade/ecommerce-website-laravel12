@extends('layouts.admin')

@section('title', 'Categories')

@section('styles')
<style>
    .categories-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .categories-table th {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--admin-muted);
        text-align: left;
        padding: 0.85rem 1.25rem;
        background: var(--admin-bg);
        border-bottom: 2px solid var(--admin-border);
    }
    
    .categories-table td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .categories-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .categories-table tbody tr:hover {
        background: rgba(184, 149, 106, 0.04);
    }
    
    .category-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .category-thumb {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        overflow: hidden;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    
    .category-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .category-thumb-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-muted);
        font-size: 1.25rem;
    }
    
    .category-name {
        font-weight: 600;
        color: var(--admin-text);
    }
    
    .category-desc {
        font-size: 0.75rem;
        color: var(--admin-muted);
        margin-top: 0.15rem;
    }
    
    .products-count {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        background: var(--admin-bg);
        border-radius: 4px;
        color: var(--admin-text);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .status-badge.active {
        background: rgba(45, 106, 79, 0.12);
        color: var(--admin-success);
    }
    
    .status-badge.inactive {
        background: rgba(107, 101, 96, 0.12);
        color: var(--admin-muted);
    }
    
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        padding: 0.35rem 0.7rem;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .action-btn:hover {
        background: var(--admin-sidebar);
        color: #faf8f5;
        border-color: var(--admin-sidebar);
    }
    
    .action-btn.danger {
        color: var(--admin-danger);
        border-color: rgba(192, 57, 43, 0.3);
    }
    
    .action-btn.danger:hover {
        background: var(--admin-danger);
        color: white;
        border-color: var(--admin-danger);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--admin-muted);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        display: block;
    }
    
    .empty-state h4 {
        font-family: var(--font-display);
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .categories-table th,
        .categories-table td {
            padding: 0.65rem 0.85rem;
            font-size: 0.8rem;
        }
        
        .category-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .category-thumb {
            width: 100%;
            height: 80px;
        }
        
        .action-btns {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

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
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrap">
            @if($categories->count() > 0)
                <table class="categories-table datatable-list">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <div class="category-cell">
                                    <div class="category-thumb">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                        @else
                                            <div class="category-thumb-placeholder">
                                                <i class="bi bi-layers"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="category-name">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="category-desc">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="products-count">
                                    <i class="bi bi-bag"></i>
                                    {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $category->is_active ? 'active' : 'inactive' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Delete this category?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-layers"></i>
                    <h4>No categories found</h4>
                    <p>Get started by adding your first category.</p>
                    <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection