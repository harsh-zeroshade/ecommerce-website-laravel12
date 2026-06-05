@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Sales</span>
        <h1>Order #{{ $order->order_number }}</h1>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn-outline admin-btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="admin-detail-grid">
    <div>
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Order Details</h3>
            </div>
            <div class="admin-card-body padded">
                <div class="admin-info-grid">
                    <div class="admin-info-block">
                        <div class="label">Customer</div>
                        <strong>{{ $order->user->name }}</strong>
                        <div style="font-size:0.85rem; color:var(--admin-muted); margin-top:0.25rem;">{{ $order->user->email }}</div>
                    </div>
                    <div class="admin-info-block">
                        <div class="label">Order Date</div>
                        <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                        <div class="label" style="margin-top:1rem;">Total</div>
                        <strong style="color:var(--admin-success);">₹{{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                </div>

                <h4 style="font-size:0.75rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:var(--admin-muted); margin-bottom:1rem;">Items</h4>
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($order->shipping_address)
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Shipping Address</h3>
            </div>
            <div class="admin-card-body padded">
                @foreach($order->shipping_address as $key => $value)
                    <p style="margin-bottom:0.35rem;"><strong style="text-transform:capitalize;">{{ $key }}:</strong> {{ $value }}</p>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div>
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Summary</h3>
            </div>
            <div class="admin-card-body padded">
                <div class="admin-summary-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="admin-summary-row">
                    <span>Discount</span>
                    <span style="color:var(--admin-success);">-₹{{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                <div class="admin-summary-row">
                    <span>Tax</span>
                    <span>₹{{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="admin-summary-row">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_amount, 2) }}</span>
                </div>
                <div class="admin-summary-row total">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Update Status</h3>
            </div>
            <div class="admin-card-body padded">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PUT')

                    <div class="admin-field">
                        <label for="order_status">Order Status</label>
                        <select id="order_status" name="order_status">
                            @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'] as $status)
                                <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label for="payment_status">Payment Status</label>
                        <select id="payment_status" name="payment_status">
                            @foreach(['pending', 'completed', 'failed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="admin-btn admin-btn-primary" style="width:100%;">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
