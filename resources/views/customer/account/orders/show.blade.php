@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
<section class="account-page" style="padding:6rem 0 3rem 0;">
    <div class="container">
        <!-- Header -->
        <div style="margin-bottom:3rem;">
            <a href="{{ route('account.orders.index') }}" style="
                display:inline-flex;
                align-items:center;
                gap:0.5rem;
                color:var(--text-muted);
                text-decoration:none;
                font-size:0.9rem;
                margin-bottom:1.5rem;
                transition:all var(--transition-fast);
            " onmouseover="this.style.color='var(--text)'" onmouseout="this.style.color='var(--text-muted)'">
                <i class="bi bi-arrow-left" style="font-size:0.85rem;"></i>
                <span>Back to Orders</span>
            </a>

            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:1.5rem; flex-wrap:wrap;">
                <div>
                    <span class="eyebrow" style="color:var(--text-muted);">Order Details</span>
                    <h1 class="display-md" style="margin-top:0.5rem;">#{{ $order->order_number }}</h1>
                    <p class="text-muted" style="margin-top:0.75rem; font-size:1rem;">
                        Placed on {{ $order->created_at->format('d M Y') }} at {{ $order->created_at->format('g:i A') }}
                    </p>
                </div>

                <!-- Status Badges -->
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    <span style="
                        display:inline-block;
                        padding:0.6rem 1rem;
                        border-radius:var(--radius-sm);
                        font-size:0.8rem;
                        font-weight:600;
                        text-transform:uppercase;
                        letter-spacing:0.05em;
                        {{ $order->payment_status === 'completed' ? 'background:rgba(75, 192, 116, 0.15); color:#2d6a3a;' : ($order->payment_status === 'failed' ? 'background:rgba(220, 38, 38, 0.15); color:#7f1d1d;' : 'background:rgba(217, 119, 6, 0.15); color:#92400e;') }}
                        width:fit-content;
                    ">{{ ucfirst($order->payment_status) }} Payment</span>
                    <span style="
                        display:inline-block;
                        padding:0.6rem 1rem;
                        border-radius:var(--radius-sm);
                        font-size:0.8rem;
                        font-weight:600;
                        text-transform:uppercase;
                        letter-spacing:0.05em;
                        {{ $order->order_status === 'delivered' ? 'background:rgba(75, 192, 116, 0.15); color:#2d6a3a;' : ($order->order_status === 'pending' ? 'background:rgba(217, 119, 6, 0.15); color:#92400e;' : 'background:rgba(59, 130, 246, 0.15); color:#1e40af;') }}
                        width:fit-content;
                    ">{{ ucfirst($order->order_status) }} Status</span>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div style="display:grid; grid-template-columns:1fr 360px; gap:2rem; align-items:start;">
            <!-- Left Column - Items & Address -->
            <div style="display:flex; flex-direction:column; gap:2rem;">
                <!-- Order Items -->
                <div style="
                    background:var(--surface);
                    border:1px solid var(--border);
                    border-radius:var(--radius);
                    overflow:hidden;
                    box-shadow:var(--shadow-sm);
                ">
                    <!-- Header -->
                    <div style="
                        padding:1.75rem;
                        background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                        border-bottom:1px solid var(--border);
                    ">
                        <h3 style="
                            font-family:var(--font-display);
                            font-size:1.1rem;
                            font-weight:600;
                            color:var(--text);
                        ">Order Items</h3>
                    </div>

                    <!-- Items -->
                    <div style="padding:1.75rem; display:flex; flex-direction:column; gap:1.25rem;">
                        @foreach($order->items as $item)
                            <div style="
                                display:flex;
                                gap:1.25rem;
                                padding-bottom:1.25rem;
                                border-bottom:1px solid var(--border);
                            " @if($loop->last)style="border-bottom:none; padding-bottom:0;"@endif>
                                <!-- Product Image -->
                                <div style="
                                    width:100px;
                                    height:100px;
                                    flex-shrink:0;
                                    border-radius:var(--radius-sm);
                                    overflow:hidden;
                                    background:var(--bg-warm);
                                    border:1px solid var(--border);
                                ">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                                            <i class="bi bi-image" style="font-size:2rem; color:var(--text-muted);"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div style="flex:1; display:flex; flex-direction:column; justify-content:space-between;">
                                    <div>
                                        <h4 style="
                                            font-weight:600;
                                            color:var(--text);
                                            margin-bottom:0.35rem;
                                            font-size:0.95rem;
                                        ">{{ $item->product->name }}</h4>
                                        <p class="text-muted" style="font-size:0.85rem;">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div style="
                                        font-family:var(--font-display);
                                        font-size:1rem;
                                        font-weight:600;
                                        color:var(--accent);
                                    ">₹{{ number_format($item->total, 2) }}</div>
                                </div>

                                <!-- Price per unit -->
                                <div style="text-align:right; flex-shrink:0;">
                                    <div class="text-muted" style="font-size:0.8rem; margin-bottom:0.25rem;">Unit Price</div>
                                    <div style="font-size:0.9rem; color:var(--text);">₹{{ number_format($item->price, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                @if($order->shipping_address)
                    <div style="
                        background:var(--surface);
                        border:1px solid var(--border);
                        border-radius:var(--radius);
                        overflow:hidden;
                        box-shadow:var(--shadow-sm);
                    ">
                        <!-- Header -->
                        <div style="
                            padding:1.75rem;
                            background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                            border-bottom:1px solid var(--border);
                        ">
                            <h3 style="
                                font-family:var(--font-display);
                                font-size:1.1rem;
                                font-weight:600;
                                color:var(--text);
                            ">
                                <i class="bi bi-geo-alt" style="margin-right:0.5rem;"></i>
                                Shipping Address
                            </h3>
                        </div>

                        <!-- Content -->
                        <div style="padding:1.75rem;">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                                @if($order->shipping_address)
                                    @if(isset($order->shipping_address['first_name']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">First Name</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['first_name'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['last_name']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">Last Name</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['last_name'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['address']))
                                        <div style="grid-column:1 / -1;">
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">Street Address</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['address'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['city']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">City</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['city'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['state']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">State</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['state'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['zipcode']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">Postal Code</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['zipcode'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['country']))
                                        <div>
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">Country</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['country'] }}</div>
                                        </div>
                                    @endif
                                    @if(isset($order->shipping_address['phone']))
                                        <div style="grid-column:1 / -1;">
                                            <div class="text-muted" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.35rem;">Phone</div>
                                            <div style="color:var(--text); font-weight:500;">{{ $order->shipping_address['phone'] }}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Notes -->
                @if($order->notes)
                    <div style="
                        background:var(--surface);
                        border:1px solid var(--border);
                        border-radius:var(--radius);
                        padding:1.75rem;
                        box-shadow:var(--shadow-sm);
                    ">
                        <h4 style="
                            font-family:var(--font-display);
                            font-size:0.95rem;
                            font-weight:600;
                            margin-bottom:0.75rem;
                            color:var(--text);
                        ">Order Notes</h4>
                        <p class="text-muted" style="line-height:1.6;">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Right Column - Summary -->
            <div>
                <div style="
                    background:var(--surface);
                    border:1px solid var(--border);
                    border-radius:var(--radius);
                    overflow:hidden;
                    box-shadow:var(--shadow-md);
                    position:sticky;
                    top:100px;
                ">
                    <!-- Header -->
                    <div style="
                        padding:1.5rem;
                        background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                        border-bottom:1px solid var(--border);
                    ">
                        <h3 style="
                            font-family:var(--font-display);
                            font-size:1rem;
                            font-weight:600;
                            color:var(--text);
                        ">Order Summary</h3>
                    </div>

                    <!-- Content -->
                    <div style="padding:1.5rem;">
                        <!-- Breakdown -->
                        <div style="display:flex; flex-direction:column; gap:0.75rem; margin-bottom:1.5rem;">
                            <div style="display:flex; justify-content:space-between; font-size:0.9rem;">
                                <span class="text-muted">Subtotal</span>
                                <span style="color:var(--text); font-weight:500;">₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.9rem;">
                                <span class="text-muted">Tax (18%)</span>
                                <span style="color:var(--text); font-weight:500;">₹{{ number_format($order->tax_amount, 2) }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:0.9rem;">
                                <span class="text-muted">Shipping</span>
                                <span style="color:var(--text); font-weight:500;">₹{{ number_format($order->shipping_amount, 2) }}</span>
                            </div>
                        </div>

                        <!-- Total -->
                        <div style="
                            padding:1.25rem;
                            background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                            border-radius:var(--radius-sm);
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                        ">
                            <span style="
                                font-weight:600;
                                text-transform:uppercase;
                                letter-spacing:0.05em;
                                font-size:0.85rem;
                                color:var(--text-muted);
                            ">Order Total</span>
                            <span style="
                                font-family:var(--font-display);
                                font-size:1.5rem;
                                font-weight:600;
                                color:var(--accent);
                            ">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <!-- Order Timeline -->
                        <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--border);">
                            <h4 style="
                                font-size:0.85rem;
                                font-weight:600;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:1.25rem;
                            ">Status Timeline</h4>

                            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                                <!-- Pending -->
                                <div style="display:flex; gap:0.75rem;">
                                    <div style="
                                        width:20px;
                                        height:20px;
                                        border-radius:50%;
                                        background:{{ $order->order_status !== 'pending' ? 'var(--accent)' : 'var(--border-strong)' }};
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        flex-shrink:0;
                                        color:white;
                                        font-size:0.7rem;
                                    ">{{ $order->order_status !== 'pending' ? '✓' : '' }}</div>
                                    <div style="flex:1;">
                                        <div style="
                                            font-size:0.85rem;
                                            font-weight:500;
                                            color:{{ $order->order_status !== 'pending' ? 'var(--text)' : 'var(--text-muted)' }};
                                        ">Pending</div>
                                    </div>
                                </div>

                                <!-- Processing -->
                                <div style="display:flex; gap:0.75rem;">
                                    <div style="
                                        width:20px;
                                        height:20px;
                                        border-radius:50%;
                                        background:{{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'var(--accent)' : 'var(--border-strong)' }};
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        flex-shrink:0;
                                        color:white;
                                        font-size:0.7rem;
                                    ">{{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? '✓' : '' }}</div>
                                    <div style="flex:1;">
                                        <div style="
                                            font-size:0.85rem;
                                            font-weight:500;
                                            color:{{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'var(--text)' : 'var(--text-muted)' }};
                                        ">Processing</div>
                                    </div>
                                </div>

                                <!-- Shipped -->
                                <div style="display:flex; gap:0.75rem;">
                                    <div style="
                                        width:20px;
                                        height:20px;
                                        border-radius:50%;
                                        background:{{ in_array($order->order_status, ['shipped', 'delivered']) ? 'var(--accent)' : 'var(--border-strong)' }};
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        flex-shrink:0;
                                        color:white;
                                        font-size:0.7rem;
                                    ">{{ in_array($order->order_status, ['shipped', 'delivered']) ? '✓' : '' }}</div>
                                    <div style="flex:1;">
                                        <div style="
                                            font-size:0.85rem;
                                            font-weight:500;
                                            color:{{ in_array($order->order_status, ['shipped', 'delivered']) ? 'var(--text)' : 'var(--text-muted)' }};
                                        ">Shipped</div>
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div style="display:flex; gap:0.75rem;">
                                    <div style="
                                        width:20px;
                                        height:20px;
                                        border-radius:50%;
                                        background:{{ $order->order_status === 'delivered' ? 'var(--accent)' : 'var(--border-strong)' }};
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        flex-shrink:0;
                                        color:white;
                                        font-size:0.7rem;
                                    ">{{ $order->order_status === 'delivered' ? '✓' : '' }}</div>
                                    <div style="flex:1;">
                                        <div style="
                                            font-size:0.85rem;
                                            font-weight:500;
                                            color:{{ $order->order_status === 'delivered' ? 'var(--text)' : 'var(--text-muted)' }};
                                        ">Delivered</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Next Steps -->
                        <div style="margin-top:1.75rem; padding:1.25rem; background:var(--bg-warm); border-radius:var(--radius-sm); border:1px solid var(--border);">
                            <h4 style="
                                font-size:0.8rem;
                                font-weight:600;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.75rem;
                            ">What's Next</h4>
                            <p style="
                                font-size:0.85rem;
                                line-height:1.6;
                                color:var(--text);
                            ">
                                @if($order->order_status === 'pending')
                                    We're processing your order. You'll receive a confirmation email soon.
                                @elseif($order->order_status === 'processing')
                                    Your order is being prepared. We'll notify you when it ships.
                                @elseif($order->order_status === 'shipped')
                                    Your package is on the way! Check the tracking details above.
                                @elseif($order->order_status === 'delivered')
                                    Thank you for your purchase! We hope you love your order. Please consider leaving a review.
                                @else
                                    Thank you for shopping with ADGON.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media (max-width: 768px) {
        .order-detail-grid {
            grid-template-columns: 1fr !important;
        }
    }

    [data-theme="dark"] .bi {
        color: inherit;
    }
</style>
@endsection
