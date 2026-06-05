@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<section class="account-page" style="padding:6rem 0 3rem 0;">
    <div class="container">
        <!-- Header -->
        <div class="account-header reveal" style="margin-bottom:2.5rem;">
            <span class="eyebrow" style="color:var(--text-muted);">My Account</span>
            <h1 class="display-md">Order History</h1>
            <p class="text-muted" style="max-width:650px; margin-top:.75rem; font-size:1.05rem;">
                View and track all your past orders.
            </p>
        </div>

        <!-- Navigation Tabs -->
        <div style="
            display:flex;
            gap:0;
            border-bottom:2px solid var(--border);
            margin-bottom:2.5rem;
        ">
            <a href="{{ route('account.orders.index') }}" style="
                padding:1rem 1.5rem;
                font-weight:600;
                font-size:0.95rem;
                color:{{ request()->routeIs('account.orders.index') ? 'var(--text)' : 'var(--text-muted)' }};
                border-bottom:3px solid {{ request()->routeIs('account.orders.index') ? 'var(--accent)' : 'transparent' }};
                margin-bottom:-2px;
                text-decoration:none;
                transition:all var(--transition-fast);
                text-transform:uppercase;
                letter-spacing:0.08em;
            ">Orders</a>
            <a href="{{ route('account.tracking') }}" style="
                padding:1rem 1.5rem;
                font-weight:600;
                font-size:0.95rem;
                color:{{ request()->routeIs('account.tracking') ? 'var(--text)' : 'var(--text-muted)' }};
                border-bottom:3px solid {{ request()->routeIs('account.tracking') ? 'var(--accent)' : 'transparent' }};
                margin-bottom:-2px;
                text-decoration:none;
                transition:all var(--transition-fast);
                text-transform:uppercase;
                letter-spacing:0.08em;
            ">Tracking</a>
        </div>

        <!-- Orders List -->
        @forelse($orders as $order)
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-radius:var(--radius);
                padding:1.75rem;
                margin-bottom:1.5rem;
                transition:all var(--transition-fast);
                box-shadow:var(--shadow-sm);
            " onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='var(--shadow-sm)'">
                <!-- Order Header -->
                <div style="
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                    gap:1rem;
                    flex-wrap:wrap;
                    margin-bottom:1.5rem;
                ">
                    <div>
                        <div style="
                            font-family:var(--font-display);
                            font-size:1.2rem;
                            font-weight:600;
                            color:var(--text);
                            margin-bottom:0.35rem;
                        ">#{{ $order->order_number }}</div>
                        <div class="text-muted" style="font-size:0.9rem;">
                            Placed on {{ $order->created_at->format('d M Y, g:i A') }}
                        </div>
                    </div>

                    <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
                        <!-- Payment Badge -->
                        <span style="
                            display:inline-block;
                            padding:0.5rem 0.875rem;
                            border-radius:var(--radius-sm);
                            font-size:0.8rem;
                            font-weight:600;
                            text-transform:uppercase;
                            letter-spacing:0.05em;
                            {{ $order->payment_status === 'completed' ? 'background:rgba(75, 192, 116, 0.15); color:#2d6a3a;' : ($order->payment_status === 'failed' ? 'background:rgba(220, 38, 38, 0.15); color:#7f1d1d;' : 'background:rgba(217, 119, 6, 0.15); color:#92400e;') }}
                        ">{{ ucfirst($order->payment_status) }}</span>

                        <!-- Status Badge -->
                        <span style="
                            display:inline-block;
                            padding:0.5rem 0.875rem;
                            border-radius:var(--radius-sm);
                            font-size:0.8rem;
                            font-weight:600;
                            text-transform:uppercase;
                            letter-spacing:0.05em;
                            {{ $order->order_status === 'delivered' ? 'background:rgba(75, 192, 116, 0.15); color:#2d6a3a;' : ($order->order_status === 'pending' ? 'background:rgba(217, 119, 6, 0.15); color:#92400e;' : 'background:rgba(59, 130, 246, 0.15); color:#1e40af;') }}
                        ">{{ ucfirst($order->order_status) }}</span>
                    </div>
                </div>

                <!-- Order Details Grid -->
                <div style="
                    display:grid;
                    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
                    gap:1.5rem;
                    padding:1.5rem 0;
                    border-top:1px solid var(--border);
                    border-bottom:1px solid var(--border);
                    margin-bottom:1.5rem;
                ">
                    <div>
                        <div class="text-muted" style="
                            font-size:0.85rem;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            margin-bottom:0.5rem;
                        ">Total Amount</div>
                        <div style="
                            font-family:var(--font-display);
                            font-size:1.35rem;
                            font-weight:600;
                            color:var(--accent);
                        ">₹{{ number_format($order->total_amount, 2) }}</div>
                    </div>

                    <div>
                        <div class="text-muted" style="
                            font-size:0.85rem;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            margin-bottom:0.5rem;
                        ">Items</div>
                        <div style="
                            font-size:1.35rem;
                            font-weight:600;
                            color:var(--text);
                        ">{{ $order->items->sum('quantity') }}</div>
                    </div>

                    <div>
                        <div class="text-muted" style="
                            font-size:0.85rem;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            margin-bottom:0.5rem;
                        ">Payment Method</div>
                        <div style="
                            font-size:0.95rem;
                            font-weight:500;
                            color:var(--text);
                        ">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</div>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('account.orders.show', $order) }}" style="
                    display:inline-flex;
                    align-items:center;
                    gap:0.5rem;
                    padding:0.75rem 1.5rem;
                    background:var(--accent);
                    color:var(--surface);
                    border:none;
                    border-radius:var(--radius-sm);
                    font-weight:600;
                    font-size:0.9rem;
                    cursor:pointer;
                    text-decoration:none;
                    text-transform:uppercase;
                    letter-spacing:0.08em;
                    transition:all var(--transition-fast);
                ">
                    <span>View Details</span>
                    <i class="bi bi-arrow-right" style="font-size:0.8rem;"></i>
                </a>
            </div>
        @empty
            <!-- Empty State -->
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-radius:var(--radius);
                padding:3rem 2rem;
                text-align:center;
            ">
                <div style="display:flex; flex-direction:column; align-items:center; gap:1rem;">
                    <i class="bi bi-box-seam" style="font-size:3rem; color:var(--sand); opacity:0.6;"></i>
                    <div>
                        <h3 style="
                            font-size:1.15rem;
                            font-weight:600;
                            margin-bottom:0.5rem;
                            color:var(--text);
                        ">No Orders Yet</h3>
                        <p class="text-muted">Start shopping to see your orders here.</p>
                    </div>
                    <a href="{{ route('shop.index') }}" style="
                        display:inline-flex;
                        align-items:center;
                        gap:0.5rem;
                        padding:0.75rem 1.5rem;
                        background:var(--accent);
                        color:var(--surface);
                        border:none;
                        border-radius:var(--radius-sm);
                        font-weight:600;
                        font-size:0.9rem;
                        cursor:pointer;
                        text-decoration:none;
                        text-transform:uppercase;
                        letter-spacing:0.08em;
                        transition:all var(--transition-fast);
                        margin-top:0.5rem;
                    ">
                        <span>Continue Shopping</span>
                        <i class="bi bi-arrow-right" style="font-size:0.8rem;"></i>
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if($orders->hasPages())
            <div style="margin-top:2.5rem; display:flex; justify-content:center;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</section>

<style>
    [data-theme="dark"] .bi {
        color: inherit;
    }
</style>
@endsection
