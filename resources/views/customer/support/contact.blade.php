@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<!-- Page Header -->
<div class="support-header">
    <div class="container">
        <span class="eyebrow reveal">Support</span>
        <h1 class="display-lg reveal reveal-delay-1">Get in Touch</h1>
        <p class="text-muted reveal reveal-delay-2" style="max-width:600px; margin:1rem auto 0;">
            We're here to help. Reach out with questions, feedback, or collaboration inquiries.
        </p>
    </div>
</div>

<!-- Contact Content -->
<section class="section">
    <div class="container">
        
        <!-- Contact Methods -->
        <div class="contact-methods reveal" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:2rem; margin-bottom:4rem;">
            
            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <h3>Email</h3>
                <p class="text-muted" style="margin-bottom:1rem;">For general inquiries and support</p>
                <a href="mailto:support@adgon.com" class="contact-link">support@adgon.com</a>
                <p class="contact-note">Response time: 24-48 hours</p>
            </div>

            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <h3>Live Chat</h3>
                <p class="text-muted" style="margin-bottom:1rem;">Chat with our support team</p>
                <button type="button" class="contact-link" onclick="alert('Live chat coming soon');">Start Live Chat</button>
                <p class="contact-note">Available Mon-Fri, 10am-6pm IST</p>
            </div>

            <div class="contact-method">
                <div class="contact-method-icon">
                    <i class="bi bi-telephone"></i>
                </div>
                <h3>Phone</h3>
                <p class="text-muted" style="margin-bottom:1rem;">Call our support team</p>
                <a href="tel:+91-9876543210" class="contact-link">+91-9876-543-210</a>
                <p class="contact-note">Mon-Fri, 10am-6pm IST</p>
            </div>

        </div>

        <!-- Contact Form & Info -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:start; margin-bottom:4rem;">
            
            <!-- Form -->
            <div class="reveal">
                <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1.5rem;">Send us a Message</h2>
                
                @if(session('success'))
                    <div class="contact-alert success">
                        <i class="bi bi-check-circle"></i>
                        <p>Thank you! Your message has been sent. We'll get back to you soon.</p>
                    </div>
                @endif

                <form method="POST" action="#" class="contact-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required class="form-input" value="{{ old('name') }}">
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required class="form-input" value="{{ old('email', auth()?->user()?->email) }}">
                        @error('email') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone', auth()?->user()?->phone) }}">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required class="form-input">
                            <option value="">Select a subject</option>
                            <option value="order">Order Inquiry</option>
                            <option value="return">Return/Exchange</option>
                            <option value="shipping">Shipping Issue</option>
                            <option value="damage">Damaged Item</option>
                            <option value="feedback">Feedback</option>
                            <option value="partnership">Partnership</option>
                            <option value="other">Other</option>
                        </select>
                        @error('subject') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required class="form-input" rows="5" placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                        @error('message') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="subscribe" value="1" {{ old('subscribe') ? 'checked' : '' }}>
                            <span>Subscribe to our newsletter for updates and offers</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;">
                        <span>Send Message</span>
                    </button>
                </form>
            </div>

            <!-- Info -->
            <div class="reveal reveal-delay-1">
                <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:1.5rem;">Our Details</h2>

                <div class="contact-info-card">
                    <h4>Business Address</h4>
                    <p class="text-muted">
                        ADGON Head Office<br>
                        123 Fashion Street<br>
                        Mumbai, Maharashtra 400001<br>
                        India
                    </p>
                </div>

                <div class="contact-info-card">
                    <h4>Office Hours</h4>
                    <p class="text-muted">
                        Monday - Friday: 10:00 AM - 6:00 PM<br>
                        Saturday: 11:00 AM - 4:00 PM<br>
                        Sunday & Holidays: Closed<br>
                        <strong>IST Timezone</strong>
                    </p>
                </div>

                <div class="contact-info-card">
                    <h4>Response Time</h4>
                    <p class="text-muted">
                        We aim to respond to all inquiries within 24-48 hours during business days. For urgent matters, please call us directly.
                    </p>
                </div>

                <div class="contact-info-card highlight">
                    <h4>Need Immediate Help?</h4>
                    <p class="text-muted" style="margin-bottom:1rem;">
                        Check our FAQ or track your order using your account.
                    </p>
                    <div style="display:flex; flex-direction:column; gap:0.75rem;">
                        <a href="{{ route('support.faq') }}" class="btn btn-outline btn-sm" style="justify-content:center;">
                            <span>View FAQ</span>
                        </a>
                        @auth
                            <a href="{{ route('account.orders.index') }}" class="btn btn-outline btn-sm" style="justify-content:center;">
                                <span>Track Order</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

        </div>

        <!-- Support Options -->
        <div class="support-options reveal">
            <h2 style="font-size:1.25rem; font-weight:600; margin-bottom:2rem; text-align:center;">Other Support Options</h2>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:1.5rem;">
                
                <a href="{{ route('support.faq') }}" class="support-option-card">
                    <div class="support-option-icon">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <h4>FAQ</h4>
                    <p class="text-muted">Find answers to common questions</p>
                </a>

                <a href="{{ route('support.shipping') }}" class="support-option-card">
                    <div class="support-option-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>Shipping Info</h4>
                    <p class="text-muted">Learn about our shipping options</p>
                </a>

                <a href="{{ route('support.returns') }}" class="support-option-card">
                    <div class="support-option-icon">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <h4>Returns & Exchanges</h4>
                    <p class="text-muted">Easy returns within 30 days</p>
                </a>

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

.contact-method {
    text-align: center;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
    transition: all 0.3s;
}

.contact-method:hover {
    border-color: rgba(26, 26, 26, 0.12);
    box-shadow: 0 8px 24px rgba(26, 26, 26, 0.06);
    transform: translateY(-2px);
}

.contact-method-icon {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.contact-method h3 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.contact-link {
    display: inline-block;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.contact-link:hover {
    text-decoration: underline;
}

.contact-note {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
}

.contact-alert {
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    font-size: 0.9rem;
}

.contact-alert.success {
    background: rgba(45, 106, 79, 0.1);
    border: 1px solid rgba(45, 106, 79, 0.2);
    color: var(--success, #2d6a4f);
}

.contact-alert i {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.contact-form {
    display: grid;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text);
}

.form-input {
    padding: 0.85rem 1rem;
    border: 1px solid rgba(26, 26, 26, 0.1);
    border-radius: 12px;
    background: #ffffff;
    font-size: 0.95rem;
    font-family: inherit;
    outline: none;
    transition: all 0.2s;
}

.form-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(184, 149, 106, 0.1);
}

.form-error {
    font-size: 0.8rem;
    color: var(--danger, #c0392b);
    margin-top: 0.25rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    cursor: pointer;
}

.checkbox-label input {
    cursor: pointer;
    width: 18px;
    height: 18px;
}

.contact-info-card {
    padding: 1.5rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.contact-info-card.highlight {
    border: 2px solid var(--primary);
    background: linear-gradient(135deg, rgba(255, 250, 240, 0.5) 0%, rgba(245, 240, 235, 0.5) 100%);
}

.contact-info-card h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.contact-info-card p {
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.6;
}

.support-option-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 2rem;
    border: 1px solid rgba(26, 26, 26, 0.08);
    border-radius: 16px;
    text-decoration: none;
    transition: all 0.3s;
}

.support-option-card:hover {
    border-color: var(--primary);
    background: linear-gradient(135deg, rgba(255, 250, 240, 0.5) 0%, rgba(245, 240, 235, 0.5) 100%);
    transform: translateY(-2px);
}

.support-option-icon {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 1rem;
}

.support-option-card h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text);
}

.support-option-card p {
    margin: 0;
    font-size: 0.85rem;
}

@media (max-width: 1024px) {
    .contact-methods {
        margin-bottom: 3rem;
    }

    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 768px) {
    .support-header {
        padding: 3rem 0 2rem;
    }

    .contact-form {
        gap: 1rem;
    }

    .form-group label {
        font-size: 0.8rem;
    }
}
</style>

@endsection
