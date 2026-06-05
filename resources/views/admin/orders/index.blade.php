@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Sales</span>
        <h1>Orders</h1>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->user->name }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $order->payment_status === 'completed' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'pending' ? 'warning' : 'info') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="admin-btn admin-btn-outline admin-btn-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">No orders found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($orders->hasPages())
<div class="admin-pagination">
    {{ $orders->links() }}
</div>
@endif
@endsection
