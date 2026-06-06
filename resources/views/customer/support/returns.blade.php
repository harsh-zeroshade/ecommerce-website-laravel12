@extends('layouts.app')

@section('title', 'Returns & Exchanges')

@section('content')

<!-- Page Header -->
<div class="support-header">
    <div class="container">
        <span class="eyebrow reveal">Support</span>
        <h1 class="display-lg reveal reveal-delay-1">Returns & Exchanges</h1>
        <p class="text-muted reveal reveal-delay-2" style="max-width:600px; margin:1rem auto 0;">
            Our hassle-free return and exchange policy ensures your satisfaction, always.
        </p>
    </div>
</div>

<!-- Returns Content -->
<section class="section">
    <div class="container" style="max-width:800px;">

        <!-- Return Policy Overview -->
        <div class="policy-overview reveal">
            <h2 class="section-title">Return Policy</h2>

            <div class="policy-card highlight">
                <div class="policy-highlight-grid">
                    <div class="policy-stat">
                        <span class="stat-value">30</span>
                        <span class="stat-label">Days to Return</span>
                    </div>
                    <div class="policy-stat">
                        <span class="stat-value">Free</span>
                        <span class="stat-label">Return Shipping</span>
                    </div>
                    <div class="policy-stat">
                        <span class="stat-value">5-7</span>
                        <span class="stat-label">Days to Refund</span>
                    </div>
                </div>
            </div>

            <p style="margin-top:2rem; margin-bottom:0;">
                We want you to love your purchase. If you're not completely satisfied, you can return or exchange your items within 30 days of purchase for a full refund or store credit.
            </p>
        </div>

        <!-- Eligibility -->
        <div class="returns-eligibility reveal reveal-delay-1">
            <h2 class="section-title">Return Eligibility</h2>

            <div class="eligibility-list">
                <div class="eligibility-item valid">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <h4>Eligible Items</h4>
                        <p class="text-muted">Unused items with tags attached, in original condition, within 30 days of purchase</p>
                    </div>
                </div>

                <div class="eligibility-item valid">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <h4>With Receipt/Order Number</h4>
                        <p class="text-muted">We'll need your order number or proof of purchase to process the return</p>
                    </div>
                </div>

                <div class="eligibility-item invalid">
                    <i class="bi bi-x-circle-fill"></i>
                    <div>
                        <h4>Non-Eligible Items</h4>
                        <p class="text-muted">Washed, worn, or damaged items; items without tags; custom or personalized pieces</p>
                    </div>
                </div>

                <div class="eligibility-item invalid">
                    <i class="bi bi-x-circle-fill"></i>
                    <div>
                        <h4>Outside Return Window</h4>
                        <p class="text-muted">Returns initiated after 30 days may not be accepted</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- How to Return -->
        <div class="returns-process reveal reveal-delay-2">
            <h2 class="section-title">How to Return</h2>

            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h4>Initiate Return</h4>
                    <p class="text-muted">Log into your account, go to "My Orders," and click "Request Return" on the order.</p>
                </div>

                <div class="process-arrow">→</div>

                <div class="process-step">
                    <div class="step-number">2</div>
                    <h4>Select Items</h4>
                    <p class="text-muted">Choose which items you want to return and specify the reason (size, style, defect, etc.)</p>
                </div>

                <div class="process-arrow">→</div>

                <div class="process-step">
                    <div class="step-number">3</div>
                    <h4>Print Label</h4>
                    <p class="text-muted">Download and print your prepaid shipping label. No cost to you.</p>
                </div>

                <div class="process-arrow">→</div>

                <div class="process-step">
                    <div class="step-number">4</div>
                    <h4>Ship Item</h4>
                    <p class="text-muted">Pack the item securely and drop it at your nearest shipping partner location.</p>
                </div>

                <div class="process-arrow">→</div>

                <div class="process-step">
                    <div class="step-number">5</div>
                    <h4>Get Refund</h4>
                    <p class="text-muted">Once we receive and inspect your return, we'll process your refund in 5-7 business days.</p>
                </div>
            </div>
        </div>

        <!-- Exchange Option -->
        <div class="returns-exchange reveal reveal-delay-3">
            <h2 class="section-title">Exchanges</h2>

            <div class="exchange-card">
                <div class="exchange-card-icon">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div class="exchange-card-content">
                    <h4>Free Exchanges</h4>
                    <p class="text-muted" style="margin-bottom:1rem;">
                        If you'd like a different size or style, we offer free exchanges within 30 days.
                    </p>
                    <ul style="font-size:0.9rem; color:var(--text-muted); margin:0; padding-left:1.5rem;">
                        <li>Same return process as regular returns</li>
                        <li>Select "Exchange" instead of "Refund"</li>
                        <li>Free shipping on your replacement item</li>
                        <li>We'll send your new item once we receive the original</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Refund Information -->
        <div class="returns-refund reveal reveal-delay-4">
            <h2 class="section-title">Refund Details</h2>

            <div class="refund-info-grid">
                <div class="refund-info-item">
                    <h4>Refund Timeline</h4>
                    <p class="text-muted">5-7 business days after we receive and inspect your return. Processing may take longer during peak seasons.</p>
                </div>

                <div class="refund-info-item">
                    <h4>Refund Method</h4>
                    <p class="text-muted">Refunds are credited to your original payment method. Please allow 3-5 additional business days for your bank to process.</p>
                </div>

                <div class="refund-info-item">
                    <h4>Partial Refunds</h4>
                    <p class="text-muted">If items are damaged, worn, or don't meet eligibility requirements, we may offer a partial refund.</p>
                </div>

                <div class="refund-info-item">
                    <h4>Store Credit</h4>
                    <p class="text-muted">Prefer store credit? Get an extra 10% when you choose credit instead of a refund!</p>
                </div>
            </div>
        </div>

        <!-- Damage Claims -->
        <div class="returns-damage reveal reveal-delay-5">
            <h2 class="section-title">Damaged Items</h2>

            <div class="damage-card">
                <div class="damage-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="damage-content">
                    <h4>Received a Damaged Item?</h4>
                    <p class="text-muted" style="margin-bottom:1rem;">
                        We stand behind our products. If you received a damaged or defective item:
                    </p>
                    <ol style="font-size:0.9rem; color:var(--text-muted); margin:0; padding-left:1.5rem;">
                        <li>Contact us within 48 hours of delivery with photos</li>
                        <li>We'll arrange a replacement or full refund</li>
                        <li>Return shipping is covered by us</li>
                    </ol>
                    <a href="{{ route('support.contact') }}" class="btn btn-primary btn-sm" style="margin-top:1.5rem;">
                        <span>Report Damage</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- FAQ CTA -->
        <div class="faq-cta reveal" style="margin-top:4rem;">
            <h3>Have questions about returns?</h3>
            <p class="text-muted" style="margin-bottom:1.5rem;">Check our FAQ or reach out to our support team for assistance.</p>
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

.policy-card {
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
    background: #ffffff;
}

.policy-card.highlight {
    border: 2px solid var(--primary);
    background: linear-gradient(135deg, rgba(255, 250, 240, 0.5) 0%, rgba(245, 240, 235, 0.5) 100%);
}

.policy-highlight-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    text-align: center;
}

.policy-stat {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary);
}

.stat-label {
    font-size: 0.85rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.eligibility-list {
    display: grid;
    gap: 1rem;
}

.eligibility-item {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
    align-items: flex-start;
}

.eligibility-item.valid {
    border-color: rgba(45, 106, 79, 0.2);
    background: rgba(45, 106, 79, 0.05);
}

.eligibility-item.invalid {
    border-color: rgba(192, 57, 43, 0.2);
    background: rgba(192, 57, 43, 0.05);
}

.eligibility-item i {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.eligibility-item.valid i {
    color: var(--success, #2d6a4f);
}

.eligibility-item.invalid i {
    color: var(--danger, #c0392b);
}

.eligibility-item h4 {
    font-weight: 600;
    margin: 0 0 0.25rem;
}

.eligibility-item p {
    margin: 0;
}

.process-steps {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 1rem;
}

.process-step {
    flex: 1;
    min-width: 150px;
    text-align: center;
    padding: 1.5rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
}

.step-number {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    font-weight: 700;
    margin: 0 auto 1rem;
}

.process-step h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 0.5rem;
}

.process-arrow {
    font-size: 1.25rem;
    color: var(--primary);
}

@media (max-width: 768px) {
    .process-steps {
        flex-direction: column;
    }

    .process-arrow {
        transform: rotate(90deg);
    }
}

.exchange-card {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
}

.exchange-card-icon {
    flex-shrink: 0;
    font-size: 2.5rem;
    color: var(--primary);
}

.exchange-card-content h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.75rem;
}

.refund-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.refund-info-item {
    padding: 1.5rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
}

.refund-info-item h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 0.75rem;
}

.refund-info-item p {
    margin: 0;
}

.damage-card {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    border: 2px solid rgba(212, 160, 23, 0.3);
    border-radius: 16px;
    background: rgba(212, 160, 23, 0.05);
}

.damage-icon {
    flex-shrink: 0;
    font-size: 2.5rem;
    color: var(--warning, #d4a017);
}

.damage-content h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.5rem;
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

    .exchange-card,
    .damage-card {
        flex-direction: column;
        text-align: center;
    }

    .exchange-card-icon,
    .damage-icon {
        margin: 0 auto;
    }
}
</style>

@endsection
