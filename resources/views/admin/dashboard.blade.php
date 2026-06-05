@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Overview</span>
        <h1>Dashboard</h1>
    </div>
</div>

<div class="admin-stats">
    <div class="admin-stat-card">
        <div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
        <i class="bi bi-people stat-icon"></i>
    </div>
    <div class="admin-stat-card">
        <div>
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
        <i class="bi bi-bag stat-icon"></i>
    </div>
    <div class="admin-stat-card">
        <div>
            <div class="stat-label">Total Categories</div>
            <div class="stat-value">{{ $totalCategories }}</div>
        </div>
        <i class="bi bi-list-ul stat-icon"></i>
    </div>
    <div class="admin-stat-card">
        <div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
        <i class="bi bi-receipt stat-icon"></i>
    </div>
    <div class="admin-stat-card">
        <div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
        </div>
        <i class="bi bi-currency-rupee stat-icon"></i>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Recent Orders</h3>
    </div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @php
                                $statusClass = match($order->order_status) {
                                    'delivered' => 'success',
                                    'pending' => 'warning',
                                    'cancelled' => 'danger',
                                    default => 'info',
                                };
                            @endphp
                            <span class="admin-badge admin-badge-{{ $statusClass }}">{{ ucfirst($order->order_status) }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="admin-btn admin-btn-outline admin-btn-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="6">No orders yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Top Products</h3>
    </div>
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Reviews</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->reviews_count }}</td>
                        <td style="color:var(--admin-gold);">
                            @for($i = 0; $i < floor($product->rating); $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">No products yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
