@extends('layouts.admin')

@section('title', 'Products')

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
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
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
                    @forelse($products as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $product->is_active ? 'success' : 'muted' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="admin-btn-group">
                                <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="6">No products found. <a href="{{ route('admin.products.create') }}" style="color:var(--admin-gold);">Add your first product</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($products->hasPages())
<div class="admin-pagination">
    {{ $products->links() }}
</div>
@endif
@endsection
