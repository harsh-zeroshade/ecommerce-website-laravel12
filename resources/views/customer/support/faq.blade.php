@extends('layouts.app')

@section('title', 'FAQ')

@section('content')

<!-- Page Header -->
<div class="support-header">
    <div class="container">
        <span class="eyebrow reveal">Support</span>
        <h1 class="display-lg reveal reveal-delay-1">Frequently Asked Questions</h1>
        <p class="text-muted reveal reveal-delay-2" style="max-width:600px; margin:1rem auto 0;">
            Find answers to common questions about our products, ordering, and services.
        </p>
    </div>
</div>

<!-- FAQ Content -->
<section class="section">
    <div class="container" style="max-width:800px;">
        <div class="faq-search reveal">
            <div class="faq-search-input">
                <i class="bi bi-search"></i>
                <input type="text" id="faqSearch" placeholder="Search FAQs..." autocomplete="off">
            </div>
        </div>

        <div class="faq-categories reveal reveal-delay-1" id="faqCategories">
            <!-- Categories will show below -->
        </div>

        <div class="faq-list" id="faqList">
            <!-- FAQ Items -->
            @php
            $faqs = [
                [
                    'category' => 'Ordering & Payment',
                    'questions' => [
                        [
                            'q' => 'How do I place an order?',
                            'a' => 'Browse our collection, add items to your cart, and proceed to checkout. You\'ll need to create an account or log in to complete your purchase. Fill in your shipping and payment details, review your order, and submit to complete.'
                        ],
                        [
                            'q' => 'What payment methods do you accept?',
                            'a' => 'We accept all major credit cards (Visa, Mastercard, American Express), debit cards, and digital payment methods. All transactions are secured with industry-standard encryption.'
                        ],
                        [
                            'q' => 'Is my payment information secure?',
                            'a' => 'Yes, absolutely. We use SSL encryption and comply with PCI DSS standards to protect your payment information. Your data is never stored on our servers.'
                        ],
                        [
                            'q' => 'Can I apply a coupon code to my order?',
                            'a' => 'Coupon codes can be applied at the checkout page before payment. Enter the code in the "Promo Code" field and click apply to see the discount.'
                        ],
                    ]
                ],
                [
                    'category' => 'Shipping & Delivery',
                    'questions' => [
                        [
                            'q' => 'How much does shipping cost?',
                            'a' => 'We offer free shipping on orders over ₹999. For orders below this amount, shipping costs ₹99. International shipping is available upon request.'
                        ],
                        [
                            'q' => 'How long does delivery take?',
                            'a' => 'Standard delivery takes 3-5 business days from the order date. Express delivery (1-2 days) is available in select locations for an additional charge.'
                        ],
                        [
                            'q' => 'Can I track my order?',
                            'a' => 'Yes, you\'ll receive a tracking number via email once your order ships. You can also track it in your account under "My Orders."'
                        ],
                        [
                            'q' => 'Do you ship internationally?',
                            'a' => 'Currently, we ship within India. International shipping is available in select countries. Contact us for details.'
                        ],
                    ]
                ],
                [
                    'category' => 'Returns & Refunds',
                    'questions' => [
                        [
                            'q' => 'What is your return policy?',
                            'a' => 'We accept returns within 30 days of purchase. Items must be unused, unwashed, and in original condition with tags attached. Initiate a return through your account or contact support.'
                        ],
                        [
                            'q' => 'How do I return an item?',
                            'a' => 'Log into your account, go to "My Orders," select the order, and click "Request Return." Follow the instructions and print your label. Ship the item back at no cost.'
                        ],
                        [
                            'q' => 'When will I get my refund?',
                            'a' => 'Refunds are processed within 5-7 business days after we receive and inspect your return. The refund will be credited to your original payment method.'
                        ],
                        [
                            'q' => 'What if the item doesn\'t fit?',
                            'a' => 'We offer free exchanges for different sizes or styles within 30 days. Use the return process and select "Exchange" instead of "Refund."'
                        ],
                    ]
                ],
                [
                    'category' => 'Products & Sizing',
                    'questions' => [
                        [
                            'q' => 'How do I find the right size?',
                            'a' => 'Check our detailed size guide on each product page. Measurements include chest, length, and sleeve length. Compare with a similar item you own for best results.'
                        ],
                        [
                            'q' => 'What materials do you use?',
                            'a' => 'We use premium, sustainable fabrics including organic cotton, linen blends, and certified recycled materials. Material info is listed on each product page.'
                        ],
                        [
                            'q' => 'Are your products sustainable?',
                            'a' => 'We\'re committed to sustainability. We use eco-friendly materials, ethical manufacturing practices, and minimal packaging. Learn more on our Sustainability page.'
                        ],
                        [
                            'q' => 'Can I customize my order?',
                            'a' => 'We don\'t offer custom sizing at this time, but we do offer personalization like monogramming on select items. Contact us for special requests.'
                        ],
                    ]
                ],
                [
                    'category' => 'Account & Profile',
                    'questions' => [
                        [
                            'q' => 'How do I create an account?',
                            'a' => 'Click "Account" in the navigation, then "Register." Enter your email, name, phone, and create a password. You\'ll be able to log in immediately.'
                        ],
                        [
                            'q' => 'Can I change my account information?',
                            'a' => 'Yes, go to your profile under "My Account" to update your name, email, phone, and password. Changes take effect immediately.'
                        ],
                        [
                            'q' => 'How do I reset my password?',
                            'a' => 'Click "Log In," then "Forgot Password?" Enter your email, and we\'ll send you a reset link. Check your spam folder if you don\'t see it.'
                        ],
                        [
                            'q' => 'Can I delete my account?',
                            'a' => 'Yes, you can request account deletion from your profile settings. Note that order history will be retained for records.'
                        ],
                    ]
                ],
            ];
            @endphp

            @foreach($faqs as $category)
            <div class="faq-category" data-category="{{ strtolower(str_replace('&', 'and', $category['category'])) }}">
                <h3 class="faq-category-title">{{ $category['category'] }}</h3>

                @foreach($category['questions'] as $index => $item)
                <div class="faq-item">
                    <button type="button" class="faq-item-toggle" data-question="{{ strtolower($item['q']) }}">
                        <span class="faq-item-question">{{ $item['q'] }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="faq-item-answer">
                        <p>{{ $item['a'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>

        <!-- Still have questions? -->
        <div class="faq-cta reveal" style="margin-top:4rem;">
            <h3>Still have questions?</h3>
            <p class="text-muted" style="margin-bottom:1.5rem;">We're here to help. Reach out to our support team.</p>
            <a href="{{ route('support.contact') }}" class="btn btn-primary"><span>Contact Support</span></a>
        </div>
    </div>
</section>

<style>
.support-header {
    padding: 4rem 0 3rem;
    text-align: center;
    background: linear-gradient(135deg, #f4f1ec 0%, #fbfaf7 100%);
}

.faq-search {
    margin: 2rem 0;
    position: relative;
}

.faq-search-input {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0 1.25rem;
    border: 1px solid rgba(26, 26, 26, 0.1);
    border-radius: 16px;
    background: #ffffff;
    height: 3rem;
}

.faq-search-input i {
    color: var(--text-muted);
    font-size: 1rem;
}

.faq-search-input input {
    flex: 1;
    border: none;
    background: none;
    outline: none;
    font-size: 0.95rem;
    color: var(--text);
}

.faq-search-input input::placeholder {
    color: var(--text-muted);
}

.faq-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin: 2rem 0;
    justify-content: center;
}

.faq-category-pill {
    padding: 0.65rem 1.25rem;
    border-radius: 999px;
    border: 1px solid rgba(26, 26, 26, 0.1);
    background: #ffffff;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
}

.faq-category-pill:hover,
.faq-category-pill.active {
    border-color: var(--primary);
    background: var(--primary);
    color: white;
}

.faq-category {
    margin: 3rem 0;
}

.faq-category-title {
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(26, 26, 26, 0.06);
}

.faq-item {
    margin-bottom: 1rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
}

.faq-item:hover {
    border-color: rgba(26, 26, 26, 0.12);
    box-shadow: 0 4px 16px rgba(26, 26, 26, 0.06);
}

.faq-item-toggle {
    width: 100%;
    padding: 1.25rem;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    text-align: left;
}

.faq-item-question {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text);
}

.faq-item-toggle i {
    font-size: 1rem;
    color: var(--primary);
    transition: transform 0.3s;
    flex-shrink: 0;
}

.faq-item.open .faq-item-toggle i {
    transform: rotate(180deg);
}

.faq-item-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 0 1.25rem 0;
}

.faq-item.open .faq-item-answer {
    max-height: 1000px;
    padding: 0 1.25rem 1.25rem;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.faq-item-answer p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: var(--text-muted);
}

.faq-item.hidden {
    display: none;
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

    .faq-item-toggle {
        padding: 1rem;
    }

    .faq-cta {
        padding: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.faq-item-toggle');
    const searchInput = document.getElementById('faqSearch');
    const faqList = document.getElementById('faqList');

    items.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const parent = toggle.closest('.faq-item');
            parent.classList.toggle('open');
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const categories = document.querySelectorAll('.faq-category');

            categories.forEach(cat => {
                const items = cat.querySelectorAll('.faq-item');
                let visibleCount = 0;

                items.forEach(item => {
                    const question = item.querySelector('.faq-item-question').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-item-answer p').textContent.toLowerCase();

                    if (question.includes(query) || answer.includes(query)) {
                        item.classList.remove('hidden');
                        item.classList.add('open');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('open');
                    }
                });

                cat.style.display = visibleCount > 0 ? '' : 'none';
            });
        });
    }
});
</script>

@endsection
