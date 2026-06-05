@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="checkout-page">
    <div class="container">
        <div class="checkout-header reveal">
            <span class="eyebrow">Checkout</span>
            <h1 class="display-md">Complete your order</h1>
        </div>

        <div class="checkout-grid">
            <div class="checkout-form-wrap reveal">
                <form method="POST" action="{{ route('checkout.store') }}" class="checkout-form">
                    @csrf

                    <h3>Shipping Details</h3>

                    <div class="auth-field">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address', auth()->user()->address) }}" required>
                    </div>

                    <div class="checkout-row">
                        <div class="auth-field">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city', auth()->user()->city) }}" required>
                        </div>
                        <div class="auth-field">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" value="{{ old('state', auth()->user()->state) }}" required>
                        </div>
                    </div>

                    <div class="checkout-row">
                        <div class="auth-field">
                            <label for="zipcode">Zip Code</label>
                            <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode', auth()->user()->zipcode) }}" required>
                        </div>
                        <div class="auth-field">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                        </div>
                    </div>

                    <h3 style="margin-top:2rem;">Payment Method</h3>
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span>Cash on Delivery</span>
                        </label>

                        <div class="text-muted" style="margin-top:.75rem; font-size:.9rem;">
                            UPI/Card payment will be available in future updates.
                        </div>
                    </div>

                    <div class="auth-field" style="margin-top:1.5rem;">
                        <label for="notes">Order Notes (optional)</label>
                        <textarea id="notes" name="notes" rows="3" style="width:100%; padding:0.85rem 1rem; border:1px solid var(--border); background:var(--bg); font-size:0.95rem; outline:none; resize:vertical;">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%; margin-top:2rem;">
                        <span>Place Order — ₹{{ number_format($subtotal + $shipping + $tax, 2) }}</span>
                    </button>
                </form>
            </div>

            <div class="checkout-summary reveal reveal-delay-1">
                <h3>Order Summary</h3>
                <div class="checkout-items">
                    @foreach($cartItems as $item)
                    <div class="checkout-item">
                        <div class="checkout-item-info">
                            <strong>{{ $item['name'] }}</strong>
                            @if($item['size'])
                                <span>Size {{ $item['size'] }}</span>
                            @endif
                            <span>Qty {{ $item['quantity'] }}</span>
                        </div>
                        <span>₹{{ number_format($item['line_total'], 2) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="checkout-totals">
                    <div class="checkout-total-row">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="checkout-total-row">
                        <span>Shipping</span>
                        <span>{{ $shipping === 0 ? 'Free' : '₹' . number_format($shipping, 2) }}</span>
                    </div>
                    <div class="checkout-total-row">
                        <span>Tax (5%)</span>
                        <span>₹{{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="checkout-total-row checkout-total-final">
                        <span>Total</span>
                        <span>₹{{ number_format($subtotal + $shipping + $tax, 2) }}</span>
                    </div>
                </div>
                @if($shipping > 0)
                    <p class="checkout-shipping-note">Free shipping on orders over ₹999</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
