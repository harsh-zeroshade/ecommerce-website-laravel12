@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('styles')
<style>
    /* Order Detail Styles */
    .order-detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .order-title-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .order-number-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        color: #faf8f5;
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        border-radius: 8px;
    }
    
    .order-date {
        font-size: 0.85rem;
        color: var(--admin-muted);
    }
    
    .status-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.5rem 0.85rem;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 6px;
    }
    
    .order-status-badge::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .order-status-badge.pending {
        background: rgba(212, 160, 23, 0.15);
        color: var(--admin-warning);
    }
    
    .order-status-badge.processing {
        background: rgba(61, 107, 142, 0.15);
        color: var(--admin-info);
    }
    
    .order-status-badge.shipped {
        background: rgba(184, 149, 106, 0.15);
        color: var(--admin-gold);
    }
    
    .order-status-badge.delivered {
        background: rgba(45, 106, 79, 0.15);
        color: var(--admin-success);
    }
    
    .order-status-badge.cancelled {
        background: rgba(192, 57, 43, 0.15);
        color: var(--admin-danger);
    }
    
    .order-status-badge.completed {
        background: rgba(45, 106, 79, 0.15);
        color: var(--admin-success);
    }
    
    .order-status-badge.failed {
        background: rgba(192, 57, 43, 0.15);
        color: var(--admin-danger);
    }
    
    .order-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        align-items: start;
    }
    
    @media (max-width: 992px) {
        .order-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .order-card {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        overflow: hidden;
    }
    
    .order-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--admin-border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .order-card-header i {
        color: var(--admin-gold);
        font-size: 1.1rem;
    }
    
    .order-card-header h3 {
        font-family: var(--font-display);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin: 0;
    }
    
    .order-card-body {
        padding: 1.5rem;
    }
    
    /* Customer Info */
    .customer-info-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, rgba(184, 149, 106, 0.08) 0%, rgba(184, 149, 106, 0.02) 100%);
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .customer-avatar-large {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #faf8f5;
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .customer-details h4 {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }
    
    .customer-details p {
        font-size: 0.85rem;
        color: var(--admin-muted);
        margin: 0;
    }
    
    /* Order Items */
    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--admin-border);
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .order-item-thumb {
        width: 70px;
        height: 85px;
        border-radius: 8px;
        overflow: hidden;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    
    .order-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .order-item-thumb-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-muted);
        font-size: 1.5rem;
    }
    
    .order-item-details {
        flex: 1;
        min-width: 0;
    }
    
    .order-item-name {
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 0.25rem;
    }
    
    .order-item-meta {
        font-size: 0.8rem;
        color: var(--admin-muted);
    }
    
    .order-item-price {
        text-align: right;
        flex-shrink: 0;
    }
    
    .order-item-qty {
        font-size: 0.8rem;
        color: var(--admin-muted);
        margin-bottom: 0.25rem;
    }
    
    .order-item-total {
        font-family: var(--font-display);
        font-weight: 600;
        color: var(--admin-text);
    }
    
    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.65rem 0;
        font-size: 0.9rem;
    }
    
    .summary-row span:first-child {
        color: var(--admin-muted);
    }
    
    .summary-row.total {
        padding-top: 1rem;
        margin-top: 0.5rem;
        border-top: 2px solid var(--admin-border);
        font-family: var(--font-display);
        font-size: 1.1rem;
        font-weight: 700;
    }
    
    .summary-row.total span:last-child {
        color: var(--admin-success);
    }
    
    /* Status Update Form */
    .status-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-field {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    
    .form-field label {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--admin-muted);
    }
    
    .form-field select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        background: var(--admin-bg);
        font-size: 0.9rem;
        color: var(--admin-text);
        cursor: pointer;
        transition: border-color 0.2s;
    }
    
    .form-field select:focus {
        outline: none;
        border-color: var(--admin-gold);
    }
    
    .update-btn {
        width: 100%;
        padding: 0.85rem 1.5rem;
        background: linear-gradient(135deg, var(--admin-sidebar), #2c2825);
        color: #faf8f5;
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .update-btn:hover {
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        transform: translateY(-1px);
    }
    
    /* Shipping Address */
    .shipping-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .shipping-item {
        padding: 0.75rem;
        background: var(--admin-bg);
        border-radius: 6px;
    }
    
    .shipping-item-label {
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--admin-muted);
        margin-bottom: 0.25rem;
    }
    
    .shipping-item-value {
        font-weight: 500;
        color: var(--admin-text);
    }
    
    @media (max-width: 576px) {
        .order-detail-header {
            flex-direction: column;
        }
        
        .status-badges {
            width: 100%;
        }
        
        .shipping-grid {
            grid-template-columns: 1fr;
        }
        
        .order-item {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<!-- Order Header -->
<div class="order-detail-header">
    <div>
        <div class="order-title-section">
            <span class="order-number-badge">
                <i class="bi bi-receipt"></i>
                #{{ $order->order_number }}
            </span>
        </div>
        <p class="order-date" style="margin-top: 0.5rem;">
            Placed on {{ $order->created_at->format('d M Y') }} at {{ $order->created_at->format('g:i A') }}
        </p>
    </div>
    <div class="status-badges">
        <span class="order-status-badge {{ $order->payment_status }}">
            {{ ucfirst($order->payment_status) }} Payment
        </span>
        <span class="order-status-badge {{ $order->order_status }}">
            {{ ucfirst($order->order_status) }}
        </span>
    </div>
</div>

<!-- Order Grid -->
<div class="order-grid">
    <!-- Left Column -->
    <div>
        <!-- Customer Info -->
        <div class="order-card" style="margin-bottom: 1.5rem;">
            <div class="order-card-header">
                <i class="bi bi-person"></i>
                <h3>Customer Information</h3>
            </div>
            <div class="order-card-body">
                <div class="customer-info-card">
                    @include('partials.user-avatar', ['user' => $order->user, 'size' => 'lg'])
                    <div class="customer-details">
                        <h4>{{ $order->user->name }}</h4>
                        <p>{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="order-card" style="margin-bottom: 1.5rem;">
            <div class="order-card-header">
                <i class="bi bi-bag"></i>
                <h3>Order Items</h3>
            </div>
            <div class="order-card-body" style="padding: 0 1.5rem;">
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="order-item-thumb">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                            @else
                                <div class="order-item-thumb-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="order-item-details">
                            <div class="order-item-name">{{ $item->product->name }}</div>
                            <div class="order-item-meta">
                                @if(isset($item->size))
                                    Size: {{ $item->size }} · 
                                @endif
                                Unit Price: ₹{{ number_format($item->price, 2) }}
                            </div>
                        </div>
                        <div class="order-item-price">
                            <div class="order-item-qty">Qty: {{ $item->quantity }}</div>
                            <div class="order-item-total">₹{{ number_format($item->total, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Shipping Address -->
        @if($order->shipping_address)
        <div class="order-card">
            <div class="order-card-header">
                <i class="bi bi-geo-alt"></i>
                <h3>Shipping Address</h3>
            </div>
            <div class="order-card-body">
                <div class="shipping-grid">
                    @if(isset($order->shipping_address['first_name']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">First Name</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['first_name'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['last_name']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">Last Name</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['last_name'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['address']))
                        <div class="shipping-item" style="grid-column: 1 / -1;">
                            <div class="shipping-item-label">Address</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['address'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['city']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">City</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['city'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['state']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">State</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['state'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['zipcode']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">Postal Code</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['zipcode'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['country']))
                        <div class="shipping-item">
                            <div class="shipping-item-label">Country</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['country'] }}</div>
                        </div>
                    @endif
                    @if(isset($order->shipping_address['phone']))
                        <div class="shipping-item" style="grid-column: 1 / -1;">
                            <div class="shipping-item-label">Phone</div>
                            <div class="shipping-item-value">{{ $order->shipping_address['phone'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Right Column -->
    <div>
        <!-- Order Summary -->
        <div class="order-card" style="margin-bottom: 1.5rem;">
            <div class="order-card-header">
                <i class="bi bi-calculator"></i>
                <h3>Order Summary</h3>
            </div>
            <div class="order-card-body">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="summary-row">
                    <span>Discount</span>
                    <span style="color: var(--admin-success);">-₹{{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="summary-row">
                    <span>Tax (18%)</span>
                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_amount, 2) }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Update Status -->
        <div class="order-card">
            <div class="order-card-header">
                <i class="bi bi-arrow-repeat"></i>
                <h3>Update Status</h3>
            </div>
            <div class="order-card-body">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="status-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-field">
                        <label for="order_status">Order Status</label>
                        <select id="order_status" name="order_status">
                            @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-field">
                        <label for="payment_status">Payment Status</label>
                        <select id="payment_status" name="payment_status">
                            @foreach(['pending', 'completed', 'failed'] as $status)
                                <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="update-btn">
                        <i class="bi bi-check-circle"></i>
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection