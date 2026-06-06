@extends('layouts.app')

@section('title', 'Return Policy')

@section('content')

<!-- Page Header -->
<div class="legal-header">
    <div class="container">
        <h1 class="display-md reveal">Return Policy</h1>
        <p class="text-muted reveal reveal-delay-1">Last Updated: June 2026</p>
    </div>
</div>

<!-- Legal Content -->
<section class="section">
    <div class="container legal-content">
        
        <div class="legal-section reveal">
            <h2>Our Return Policy</h2>
            <p>At ADGON, we want you to be completely satisfied with your purchase. If you're not happy with your item, we make returns simple and hassle-free.</p>
        </div>

        <div class="legal-section reveal reveal-delay-1">
            <h3>Return Window</h3>
            <p>You have <strong>30 days</strong> from the date of delivery to initiate a return. Items must be unused, unwashed, and in their original condition with all tags attached.</p>
            <div class="legal-highlight">
                <p><strong>Note:</strong> Returns initiated after 30 days may not be accepted. We recommend initiating your return as soon as possible.</p>
            </div>
        </div>

        <div class="legal-section reveal reveal-delay-2">
            <h3>Eligible Items for Return</h3>
            <p>The following items are eligible for return:</p>
            <ul class="legal-list">
                <li>Apparel and accessories that are unused and unwashed</li>
                <li>Items with original price tags attached</li>
                <li>Items in original packaging and condition</li>
                <li>Items that have not been altered or tailored</li>
                <li>Items purchased within the last 30 days</li>
            </ul>
        </div>

        <div class="legal-section reveal reveal-delay-2">
            <h3>Non-Returnable Items</h3>
            <p>The following items cannot be returned:</p>
            <ul class="legal-list">
                <li>Worn, washed, or damaged items</li>
                <li>Items without original tags or labels</li>
                <li>Custom or personalized pieces</li>
                <li>Sale items marked as "Final Sale"</li>
                <li>Items purchased more than 30 days ago</li>
                <li>Items that have been altered or hemmed</li>
            </ul>
        </div>

        <div class="legal-section reveal reveal-delay-3">
            <h3>How to Return an Item</h3>
            <ol class="legal-list-numbered">
                <li><strong>Log into Your Account</strong> — Visit adgon.com and sign in with your credentials</li>
                <li><strong>Navigate to My Orders</strong> — Go to your account dashboard and find the order you wish to return</li>
                <li><strong>Request Return</strong> — Click "Request Return" and select which items you want to return</li>
                <li><strong>Provide Reason</strong> — Tell us why you're returning the item (size, style, defect, etc.)</li>
                <li><strong>Print Shipping Label</strong> — Download and print your prepaid shipping label</li>
                <li><strong>Package Item</strong> — Securely pack the item(s) with the label</li>
                <li><strong>Ship Item</strong> — Drop off at your nearest courier location at no cost to you</li>
                <li><strong>Await Refund</strong> — Once we receive and inspect your return, we'll process your refund in 5-7 business days</li>
            </ol>
        </div>

        <div class="legal-section reveal reveal-delay-4">
            <h3>Shipping Returns</h3>
            <p>ADGON provides a prepaid shipping label for all returns. You will not be charged for return shipping. Simply print the label, attach it to your package, and drop it off at your nearest courier location.</p>
            <div class="legal-highlight">
                <p><strong>Important:</strong> Please ensure you use the provided shipping label. Returns sent without a label or paid for by the customer will not be accepted or reimbursed.</p>
            </div>
        </div>

        <div class="legal-section reveal reveal-delay-4">
            <h3>Refund Processing</h3>
            <p>After we receive your return, we will inspect the item to ensure it meets our return criteria. If approved:</p>
            <ul class="legal-list">
                <li>Refunds will be processed within 5-7 business days</li>
                <li>Refunds are credited to your original payment method</li>
                <li>It may take an additional 3-5 business days for your bank to process the credit</li>
                <li>You will receive an email confirmation once your refund has been issued</li>
            </ul>
        </div>

        <div class="legal-section reveal reveal-delay-5">
            <h3>Exchanges</h3>
            <p>If you'd like a different size or style instead of a refund, we offer free exchanges within 30 days. To exchange an item:</p>
            <ol class="legal-list-numbered">
                <li>Request a return through your account</li>
                <li>Select "Exchange" instead of "Refund"</li>
                <li>Choose your replacement item</li>
                <li>We'll send your new item once we receive the original</li>
                <li>Free shipping applies to your replacement</li>
            </ol>
        </div>

        <div class="legal-section reveal reveal-delay-5">
            <h3>Damaged or Defective Items</h3>
            <p>If you receive a damaged or defective item, we'll make it right:</p>
            <ul class="legal-list">
                <li>Contact us within 48 hours of delivery with photos of the damage</li>
                <li>We will arrange a replacement or full refund at no cost to you</li>
                <li>Return shipping will be covered by ADGON</li>
                <li>Email us at support@adgon.com with your order number and photos</li>
            </ul>
        </div>

        <div class="legal-section reveal reveal-delay-6">
            <h3>Partial Refunds</h3>
            <p>If an item is returned in a condition that doesn't meet our return criteria (worn, washed, damaged, etc.), we may issue a partial refund based on the item's condition. You will be notified of any deductions before the refund is processed.</p>
        </div>

        <div class="legal-section reveal reveal-delay-6">
            <h3>Store Credit</h3>
            <p>Prefer store credit instead of a refund? Choose store credit at checkout and receive an extra <strong>10% bonus</strong> on your credit amount. This can be used for future purchases at ADGON.</p>
        </div>

        <div class="legal-section reveal reveal-delay-7">
            <h3>Contact Us</h3>
            <p>If you have any questions about our return policy or need assistance with a return, please contact us:</p>
            <ul class="legal-list">
                <li><strong>Email:</strong> <a href="mailto:support@adgon.com">support@adgon.com</a></li>
                <li><strong>Phone:</strong> <a href="tel:+91-9876543210">+91-9876-543-210</a></li>
                <li><strong>Hours:</strong> Monday-Friday, 10am-6pm IST</li>
            </ul>
        </div>

        <div class="legal-section reveal reveal-delay-7">
            <h3>Policy Updates</h3>
            <p>ADGON reserves the right to update or modify this return policy at any time. Changes will be effective immediately upon posting to our website. Your continued use of our services constitutes acceptance of any changes to this policy.</p>
        </div>

    </div>
</section>

<style>
.legal-header {
    padding: 4rem 0 3rem;
    text-align: center;
    background: linear-gradient(135deg, #f4f1ec 0%, #fbfaf7 100%);
}

.legal-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.legal-header p {
    font-size: 0.95rem;
}

.legal-content {
    max-width: 800px;
    margin: 0 auto;
}

.legal-section {
    margin-bottom: 3rem;
    line-height: 1.8;
}

.legal-section h2 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--text);
}

.legal-section h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--text);
}

.legal-section p {
    margin-bottom: 1rem;
    color: var(--text);
    font-size: 0.95rem;
}

.legal-section p:last-child {
    margin-bottom: 0;
}

.legal-list {
    list-style: none;
    padding: 0;
    margin: 1rem 0;
}

.legal-list li {
    padding: 0.5rem 0 0.5rem 1.5rem;
    position: relative;
    color: var(--text);
    font-size: 0.95rem;
}

.legal-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--primary);
    font-weight: 600;
}

.legal-list-numbered {
    list-style: none;
    padding: 0;
    margin: 1rem 0;
    counter-reset: item;
}

.legal-list-numbered li {
    counter-increment: item;
    padding: 0.75rem 0 0.75rem 2rem;
    position: relative;
    color: var(--text);
    font-size: 0.95rem;
}

.legal-list-numbered li::before {
    content: counter(item);
    position: absolute;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: 600;
}

.legal-highlight {
    padding: 1.25rem;
    margin: 1.5rem 0;
    background: linear-gradient(135deg, rgba(184, 149, 106, 0.08) 0%, rgba(184, 149, 106, 0.04) 100%);
    border-left: 4px solid var(--primary);
    border-radius: 8px;
}

.legal-highlight p {
    margin: 0;
    font-size: 0.9rem;
}

.legal-section a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: text-decoration 0.2s;
}

.legal-section a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .legal-header h1 {
        font-size: 1.75rem;
    }

    .legal-section h2 {
        font-size: 1.4rem;
    }

    .legal-section h3 {
        font-size: 1.05rem;
    }

    .legal-section {
        margin-bottom: 2rem;
    }
}
</style>

@endsection
