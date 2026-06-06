@extends('layouts.admin')

@section('title', 'Orders')

@section('styles')
<style>
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table th {
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
    
    .orders-table td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .orders-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .orders-table tbody tr:hover {
        background: rgba(184, 149, 106, 0.04);
    }
    
    .order-number {
        font-family: var(--font-display);
        font-weight: 600;
    }
    
    .customer-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .customer-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #faf8f5;
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .customer-name {
        font-weight: 500;
    }
    
    .amount-cell {
        font-family: var(--font-display);
        font-weight: 600;
    }
    
    .payment-badge {
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
    
    .payment-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .payment-badge.completed {
        background: rgba(45, 106, 79, 0.12);
        color: var(--admin-success);
    }
    
    .payment-badge.pending {
        background: rgba(212, 160, 23, 0.12);
        color: var(--admin-warning);
    }
    
    .payment-badge.failed {
        background: rgba(192, 57, 43, 0.12);
        color: var(--admin-danger);
    }
    
    .order-status-badge {
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
    
    .order-status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .order-status-badge.pending {
        background: rgba(212, 160, 23, 0.12);
        color: var(--admin-warning);
    }
    
    .order-status-badge.processing {
        background: rgba(61, 107, 142, 0.12);
        color: var(--admin-info);
    }
    
    .order-status-badge.shipped {
        background: rgba(184, 149, 106, 0.12);
        color: var(--admin-gold);
    }
    
    .order-status-badge.delivered {
        background: rgba(45, 106, 79, 0.12);
        color: var(--admin-success);
    }
    
    .order-status-badge.cancelled {
        background: rgba(192, 57, 43, 0.12);
        color: var(--admin-danger);
    }
    
    .date-cell {
        color: var(--admin-muted);
        font-size: 0.8rem;
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
        .orders-table th,
        .orders-table td {
            padding: 0.65rem 0.85rem;
            font-size: 0.8rem;
        }
        
        .customer-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Sales</span>
        <h1>Orders</h1>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrap">
            @if($orders->count() > 0)
                <table class="orders-table datatable-list">
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
                        @foreach($orders as $order)
                        <tr>
                            <td class="order-number">#{{ $order->order_number }}</td>
                            <td>
                                <div class="customer-cell">
                                    @include('partials.user-avatar', ['user' => $order->user, 'size' => 'sm'])
                                    <div class="customer-name">{{ $order->user->name }}</div>
                                </div>
                            </td>
                            <td class="amount-cell">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="payment-badge {{ $order->payment_status }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="order-status-badge {{ $order->order_status }}">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td class="date-cell">{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="action-btn">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-receipt-cutoff"></i>
                    <h4>No orders found</h4>
                    <p>Orders will appear here once customers start making purchases.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection