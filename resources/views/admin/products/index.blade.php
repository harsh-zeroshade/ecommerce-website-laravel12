@extends('layouts.admin')

@section('title', 'Products')

@section('styles')
<style>
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table th {
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
    
    .products-table td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .products-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .products-table tbody tr:hover {
        background: rgba(184, 149, 106, 0.04);
    }
    
    .product-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .product-thumb {
        width: 48px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    
    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-thumb-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-muted);
        font-size: 1.25rem;
    }
    
    .product-name {
        font-weight: 600;
        color: var(--admin-text);
    }
    
    .product-sku {
        font-size: 0.7rem;
        color: var(--admin-muted);
    }
    
    .price-cell {
        font-family: var(--font-display);
        font-weight: 600;
    }
    
    .stock-badge {
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
    
    .stock-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .stock-badge.in-stock {
        background: rgba(45, 106, 79, 0.12);
        color: var(--admin-success);
    }
    
    .stock-badge.out-of-stock {
        background: rgba(192, 57, 43, 0.12);
        color: var(--admin-danger);
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
    
    .featured-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.65rem;
        color: var(--admin-gold);
    }
    
    .featured-badge i {
        font-size: 0.75rem;
    }
    
    @media (max-width: 768px) {
        .products-table th,
        .products-table td {
            padding: 0.65rem 0.85rem;
            font-size: 0.8rem;
        }
        
        .product-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .product-thumb {
            width: 100%;
            height: 120px;
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
        <span class="eyebrow">Inventory</span>
        <h1>Products</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrap">
            @if($products->count() > 0)
                <table class="products-table datatable-list">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-thumb">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="product-thumb-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-sku">SKU: {{ $product->sku }}</div>
                                        @if($product->is_featured)
                                            <span class="featured-badge"><i class="bi bi-star-fill"></i> Featured</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? '—' }}</td>
                            <td class="price-cell">₹{{ number_format($product->price, 2) }}</td>
                            <td>
                                <span class="stock-badge {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                                    {{ $product->stock }} in stock
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="action-btn">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('Delete this product?')">
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
                    <i class="bi bi-bag"></i>
                    <h4>No products found</h4>
                    <p>Get started by adding your first product.</p>
                    <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection