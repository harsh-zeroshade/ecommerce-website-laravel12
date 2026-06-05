@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<section class="order-success-page">
    <div class="container container-narrow">
        <div class="order-success-card reveal">
            <div class="order-success-icon">✓</div>
            <span class="eyebrow">Order Confirmed</span>
            <h1 class="display-md">Thank you, {{ auth()->user()->name }}</h1>
            <p class="text-muted">Your order <strong>#{{ $order->order_number }}</strong> has been placed successfully.</p>

            <div class="order-success-details">
                <div class="order-success-row">
                    <span>Total</span>
                    <strong>₹{{ number_format($order->total_amount, 2) }}</strong>
                </div>
                <div class="order-success-row">
                    <span>Payment</span>
                    <strong>
                        Cash on Delivery
                        — {{ ucfirst($order->payment_status) }}
                    </strong>
                </div>
                <div class="order-success-row">
                    <span>Status</span>
                    <strong>{{ ucfirst($order->order_status) }}</strong>
                </div>
            </div>

            <div class="hero-cta" style="margin-top:2.5rem;">
                <a href="{{ route('shop.index') }}" class="btn btn-primary"><span>Continue Shopping</span></a>
                <a href="{{ route('home') }}" class="btn btn-outline"><span>Back to Home</span></a>
            </div>
        </div>
    </div>
</section>
@endsection
