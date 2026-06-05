@extends('layouts.app')

@section('title', 'Active Order Tracking')

@section('content')
<section class="account-page" style="padding:6rem 0 3rem 0;">
    <div class="container">
        <!-- Header -->
        <div class="account-header reveal" style="margin-bottom:2.5rem;">
            <span class="eyebrow" style="color:var(--text-muted);">My Account</span>
            <h1 class="display-md">Track Orders</h1>
            <p class="text-muted" style="max-width:650px; margin-top:.75rem; font-size:1.05rem;">
                Monitor your active shipments in real-time.
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

        @if($orders->count() === 0)
            <!-- Empty State -->
            <div style="
                background:var(--surface);
                border:1px solid var(--border);
                border-radius:var(--radius);
                padding:3rem 2rem;
                text-align:center;
            ">
                <div style="display:flex; flex-direction:column; align-items:center; gap:1rem;">
                    <i class="bi bi-hourglass-split" style="font-size:3rem; color:var(--sand); opacity:0.6;"></i>
                    <div>
                        <h3 style="
                            font-size:1.15rem;
                            font-weight:600;
                            margin-bottom:0.5rem;
                            color:var(--text);
                        ">No Active Orders</h3>
                        <p class="text-muted">All your orders have been delivered. View your order history to see past shipments.</p>
                    </div>
                    <a href="{{ route('account.orders.index') }}" style="
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
                        <span>View Order History</span>
                        <i class="bi bi-arrow-right" style="font-size:0.8rem;"></i>
                    </a>
                </div>
            </div>
        @else
            <!-- Active Orders List -->
            <div style="display:flex; flex-direction:column; gap:1.75rem;">
                @foreach($orders as $order)
                    <div style="
                        background:var(--surface);
                        border:1px solid var(--border);
                        border-radius:var(--radius);
                        overflow:hidden;
                        box-shadow:var(--shadow-sm);
                        transition:all var(--transition-fast);
                    " onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='var(--shadow-sm)'">
                        
                        <!-- Order Header -->
                        <div style="
                            padding:1.75rem;
                            background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                            border-bottom:1px solid var(--border);
                            display:flex;
                            align-items:center;
                            justify-content:space-between;
                            gap:1rem;
                            flex-wrap:wrap;
                        ">
                            <div>
                                <div style="
                                    font-family:var(--font-display);
                                    font-size:1.15rem;
                                    font-weight:600;
                                    color:var(--text);
                                    margin-bottom:0.35rem;
                                ">#{{ $order->order_number }}</div>
                                <div class="text-muted" style="font-size:0.9rem;">
                                    Placed on {{ $order->created_at->format('d M Y, g:i A') }}
                                </div>
                            </div>

                            <div style="display:flex; gap:0.75rem; align-items:center;">
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

                        <!-- Items Table -->
                        <div style="padding:1.75rem;">
                            <h4 style="
                                font-size:0.9rem;
                                font-weight:600;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:1.25rem;
                            ">Order Items</h4>

                            <div style="display:flex; flex-direction:column; gap:1rem;">
                                @foreach($order->items as $item)
                                    @php
                                        $p = $item->product;
                                        $img = $p?->image ? asset('storage/' . $p->image) : null;
                                    @endphp
                                    <div style="
                                        display:flex;
                                        align-items:center;
                                        gap:1rem;
                                        padding:1rem;
                                        background:var(--bg-warm);
                                        border-radius:var(--radius-sm);
                                    ">
                                        <!-- Product Image -->
                                        <div style="
                                            width:80px;
                                            height:80px;
                                            flex-shrink:0;
                                            border-radius:var(--radius-sm);
                                            overflow:hidden;
                                            background:var(--surface);
                                            border:1px solid var(--border);
                                        ">
                                            @if($img)
                                                <img src="{{ $img }}" alt="{{ $p?->name }}" style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-image" style="font-size:1.8rem; color:var(--text-muted);"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div style="flex:1;">
                                            <div style="
                                                font-weight:600;
                                                color:var(--text);
                                                margin-bottom:0.35rem;
                                            ">{{ $p?->name ?? 'Deleted product' }}</div>
                                            <div class="text-muted" style="font-size:0.9rem;">
                                                Quantity: <strong>{{ $item->quantity }}</strong>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div style="
                                            text-align:right;
                                            font-family:var(--font-display);
                                            font-size:1.1rem;
                                            font-weight:600;
                                            color:var(--accent);
                                        ">₹{{ number_format($item->total, 2) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Order Total -->
                            <div style="
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                padding:1rem;
                                margin-top:1rem;
                                border-top:1px solid var(--border);
                            ">
                                <span style="
                                    font-weight:600;
                                    text-transform:uppercase;
                                    letter-spacing:0.08em;
                                    color:var(--text-muted);
                                    font-size:0.9rem;
                                ">Order Total</span>
                                <span style="
                                    font-family:var(--font-display);
                                    font-size:1.3rem;
                                    font-weight:600;
                                    color:var(--accent);
                                ">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div style="
                            padding:1.5rem 1.75rem;
                            border-top:1px solid var(--border);
                            background:var(--bg-warm);
                        ">
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
                                <span>View Full Details</span>
                                <i class="bi bi-arrow-right" style="font-size:0.8rem;"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
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
