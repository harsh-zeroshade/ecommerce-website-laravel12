@extends('layouts.app')

@section('title', 'Shipping Information')

@section('content')

<!-- Page Header -->
<div class="support-header">
    <div class="container">
        <span class="eyebrow reveal">Support</span>
        <h1 class="display-lg reveal reveal-delay-1">Shipping Information</h1>
        <p class="text-muted reveal reveal-delay-2" style="max-width:600px; margin:1rem auto 0;">
            Learn about our shipping options, delivery times, and tracking information.
        </p>
    </div>
</div>

<!-- Shipping Content -->
<section class="section">
    <div class="container" style="max-width:800px;">
        
        <!-- Shipping Options -->
        <div class="shipping-options reveal">
            <h2 class="section-title">Shipping Options</h2>

            <div class="shipping-option-card">
                <div class="shipping-option-icon">
                    <i class="bi bi-box2"></i>
                </div>
                <div class="shipping-option-content">
                    <h3>Standard Shipping</h3>
                    <p class="text-muted">Delivery in 3-5 business days</p>
                    <div class="shipping-option-price">
                        <span class="price-label">Shipping Cost:</span>
                        <span class="price-value">₹99</span>
                    </div>
                    <p class="shipping-option-note">Free on orders over ₹999</p>
                </div>
            </div>

            <div class="shipping-option-card">
                <div class="shipping-option-icon">
                    <i class="bi bi-lightning-fill"></i>
                </div>
                <div class="shipping-option-content">
                    <h3>Express Shipping</h3>
                    <p class="text-muted">Delivery in 1-2 business days</p>
                    <div class="shipping-option-price">
                        <span class="price-label">Shipping Cost:</span>
                        <span class="price-value">₹249</span>
                    </div>
                    <p class="shipping-option-note">Available in select locations</p>
                </div>
            </div>
        </div>

        <!-- Delivery Timeline -->
        <div class="shipping-timeline reveal reveal-delay-1">
            <h2 class="section-title">Delivery Timeline</h2>

            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Order Confirmed</h4>
                        <p class="text-muted">Immediately after purchase</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker">
                        <i class="bi bi-box2-heart"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Packed & Ready</h4>
                        <p class="text-muted">Within 24 hours</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Shipped</h4>
                        <p class="text-muted">Tracking number sent via email</p>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker">
                        <i class="bi bi-gift"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Delivered</h4>
                        <p class="text-muted">3-5 business days (standard)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Coverage -->
        <div class="shipping-coverage reveal reveal-delay-2">
            <h2 class="section-title">Shipping Coverage</h2>

            <div class="coverage-grid">
                <div class="coverage-item">
                    <div class="coverage-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h4>Within India</h4>
                    <p class="text-muted">All states & union territories</p>
                </div>

                <div class="coverage-item">
                    <div class="coverage-icon">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h4>International</h4>
                    <p class="text-muted">Select countries available</p>
                </div>
            </div>

            <p class="shipping-note" style="margin-top:2rem;">
                <strong>Note:</strong> For international shipping inquiries, please contact our support team for a custom quote.
            </p>
        </div>

        <!-- Tracking -->
        <div class="shipping-tracking reveal reveal-delay-3">
            <h2 class="section-title">Track Your Order</h2>

            <div class="tracking-card">
                <div class="tracking-card-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="tracking-card-content">
                    <h4>Real-time Tracking</h4>
                    <p class="text-muted">You'll receive a tracking number via email once your order ships. You can also track your order in your account under "My Orders."</p>
                    @auth
                        <a href="{{ route('account.orders.index') }}" class="btn btn-primary btn-sm" style="margin-top:1rem;">
                            <span>View My Orders</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="margin-top:1rem;">
                            <span>Sign In to Track</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="shipping-address reveal reveal-delay-4">
            <h2 class="section-title">Shipping Address Requirements</h2>

            <div class="address-requirements">
                <div class="requirement-item">
                    <span class="requirement-icon">✓</span>
                    <div>
                        <h4>Full Name</h4>
                        <p class="text-muted">As it appears on ID</p>
                    </div>
                </div>

                <div class="requirement-item">
                    <span class="requirement-icon">✓</span>
                    <div>
                        <h4>Complete Address</h4>
                        <p class="text-muted">Street, city, state, and PIN code</p>
                    </div>
                </div>

                <div class="requirement-item">
                    <span class="requirement-icon">✓</span>
                    <div>
                        <h4>Contact Number</h4>
                        <p class="text-muted">10-digit mobile number</p>
                    </div>
                </div>

                <div class="requirement-item">
                    <span class="requirement-icon">✓</span>
                    <div>
                        <h4>Landmark (Optional)</h4>
                        <p class="text-muted">Helps with faster delivery</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ CTA -->
        <div class="faq-cta reveal" style="margin-top:4rem;">
            <h3>Need more help?</h3>
            <p class="text-muted" style="margin-bottom:1.5rem;">Check our FAQ or contact our support team.</p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                <a href="{{ route('support.faq') }}" class="btn btn-outline"><span>View FAQ</span></a>
                <a href="{{ route('support.contact') }}" class="btn btn-primary"><span>Contact Support</span></a>
            </div>
        </div>
    </div>
</section>

<style>
.support-header {
    padding: 4rem 0 3rem;
    text-align: center;
    background: linear-gradient(135deg, #f4f1ec 0%, #fbfaf7 100%);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 2rem;
    color: var(--text);
}

.shipping-option-card {
    display: flex;
    gap: 1.5rem;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    transition: all 0.3s;
}

.shipping-option-card:hover {
    border-color: rgba(26, 26, 26, 0.12);
    box-shadow: 0 8px 24px rgba(26, 26, 26, 0.06);
}

.shipping-option-icon {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f4f1ec 0%, #fbfaf7 100%);
    border-radius: 12px;
    font-size: 1.5rem;
    color: var(--primary);
}

.shipping-option-content h3 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.shipping-option-price {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0.75rem 0;
    font-size: 0.9rem;
}

.price-label {
    color: var(--text-muted);
}

.price-value {
    font-weight: 700;
    color: var(--text);
    font-size: 1.1rem;
}

.shipping-option-note {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
}

.timeline {
    position: relative;
    padding: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 27px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--primary), transparent);
}

.timeline-item {
    display: flex;
    gap: 2rem;
    margin-bottom: 2.5rem;
    position: relative;
}

.timeline-marker {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 2px solid var(--primary);
    border-radius: 50%;
    color: var(--primary);
    font-size: 1.25rem;
}

.timeline-content h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.coverage-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.coverage-item {
    text-align: center;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
}

.coverage-icon {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.coverage-item h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.shipping-note {
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(255, 250, 240, 0.5) 0%, rgba(245, 240, 235, 0.5) 100%);
    border-left: 4px solid var(--primary);
    border-radius: 8px;
    font-size: 0.9rem;
}

.tracking-card {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
    align-items: center;
}

.tracking-card-icon {
    flex-shrink: 0;
    font-size: 2.5rem;
    color: var(--primary);
}

.tracking-card-content h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.address-requirements {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.requirement-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
}

.requirement-icon {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    font-weight: 700;
}

.requirement-item h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0;
}

.requirement-item p {
    margin: 0.25rem 0 0;
}

.faq-cta {
    text-align: center;
    padding: 3rem;
    background: linear-gradient(135deg, #f4f1ec 0%, #fbfaf7 100%);
    border-radius: 16px;
}

.faq-cta h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .support-header {
        padding: 3rem 0 2rem;
    }

    .shipping-option-card {
        flex-direction: column;
        gap: 1rem;
    }

    .tracking-card {
        flex-direction: column;
        text-align: center;
    }

    .timeline::before {
        left: 20px;
    }

    .timeline-item {
        gap: 1.5rem;
    }

    .timeline-marker {
        width: 48px;
        height: 48px;
        font-size: 1rem;
    }
}
</style>

@endsection
