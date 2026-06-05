<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ADGON — Premium clothing engineered for modern style. Discover curated apparel, accessories, and statement pieces.">
    <title>@yield('title') — ADGON</title>
    <script>
        (function() {
            const theme = localStorage.getItem('adgon-theme');
            if (theme === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="site-nav">
        <div class="nav-inner">
            <div class="nav-links-left">
                <a href="{{ route('home') }}#philosophy">About</a>
                <a href="{{ route('shop.index') }}">Shop</a>
            </div>

            <a href="{{ route('home') }}" class="nav-logo">Adgon</a>

            <div class="nav-actions">
                <button type="button" class="nav-action theme-toggle" aria-label="Toggle dark mode" title="Toggle theme">
                    <i class="bi bi-moon-stars theme-icon-dark"></i>
                    <i class="bi bi-sun theme-icon-light"></i>
                </button>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-action">
                            <span class="nav-action-text">Admin</span>
                        </a>
                    @endif

                    @if(auth()->user()->isCustomer())
                            <div class="nav-account-dropdown">
                            <a href="javascript:void(0)" class="nav-action" style="display:inline-flex; align-items:center; gap:.4rem;">
                                <span class="nav-action-text">My Account</span>
                                <i class="bi bi-chevron-down" style="font-size:.9rem; opacity:.9; transition: transform 0.2s ease;"></i>
                            </a>

                            <div class="nav-account-dropdown-menu">
                                <a href="{{ route('account.profile') }}" class="nav-menu-item">
                                    <span>Profile</span>
                                    <i class="bi bi-person"></i>
                                </a>

                                <a href="{{ route('account.orders.index') }}" class="nav-menu-item">
                                    <span>My Orders</span>
                                    <i class="bi bi-bag-check"></i>
                                </a>

                                <a href="{{ route('account.tracking') }}" class="nav-menu-item">
                                    <span>Track Orders</span>
                                    <i class="bi bi-truck"></i>
                                </a>

                                <div class="nav-menu-divider"></div>

                                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                    @csrf
                                    <button type="submit" class="nav-menu-item">
                                        <span>Logout</span>
                                        <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <style>
                            .nav-account-dropdown {
                                position: relative;
                                display: inline-flex;
                                align-items: center;
                            }

                            .nav-account-dropdown::after {
                                content: '';
                                position: absolute;
                                top: 100%;
                                left: -20px;
                                right: -20px;
                                height: 12px;
                                pointer-events: auto;
                            }

                            .nav-account-dropdown-menu {
                                position: absolute;
                                top: 100%;
                                right: 0;
                                margin-top: 8px;
                                min-width: 220px;
                                background: var(--surface);
                                border: 1px solid var(--border);
                                border-radius: var(--radius);
                                padding: 8px;
                                z-index: 9999;
                                display: flex;
                                flex-direction: column;
                                pointer-events: none;
                                opacity: 0;
                                visibility: hidden;
                                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                                transform: translateY(-12px);
                                box-shadow: var(--shadow-lg);
                                backdrop-filter: blur(10px);
                            }

                            .nav-account-dropdown:hover .nav-account-dropdown-menu,
                            .nav-account-dropdown:hover::after {
                                opacity: 1;
                                visibility: visible;
                                pointer-events: auto;
                                transform: translateY(0);
                            }

                            .nav-account-dropdown:hover .nav-action i {
                                transform: rotate(180deg);
                            }

                            .nav-menu-item {
                                display: flex;
                                align-items: center;
                                justify-content: space-between;
                                padding: 10px 12px;
                                border-radius: 10px;
                                text-decoration: none;
                                color: var(--text);
                                font-size: 0.95rem;
                                cursor: pointer;
                                border: none;
                                background: transparent;
                                text-align: left;
                                width: 100%;
                                transition: all 0.15s ease;
                            }

                            .nav-menu-item:hover {
                                background: var(--bg-warm);
                                color: var(--text);
                            }

                            .nav-menu-item i {
                                opacity: 0.6;
                                font-size: 1.1rem;
                                margin-left: 12px;
                            }

                            .nav-menu-divider {
                                height: 1px;
                                background: var(--border);
                                margin: 4px 0;
                            }

                            [data-theme="dark"] .nav-account-dropdown-menu {
                                background: var(--surface-dark);
                                border-color: rgba(255, 255, 255, 0.1);
                            }

                            [data-theme="dark"] .nav-menu-item:hover {
                                background: rgba(255, 255, 255, 0.08);
                            }

                            [data-theme="dark"] .nav-menu-item {
                                color: rgba(255, 255, 255, 0.95);
                            }
                        </style>
                    @endif

                @else
                    <a href="{{ route('account.orders.index') }}" class="nav-action">
                        <span class="nav-action-text">Account</span>
                    </a>
                @endauth
                <button type="button" class="nav-action cart-trigger">
                    <span class="nav-action-text">Cart</span>
                    <span class="cart-count">{{ $cartCount }}</span>
                </button>
                <button type="button" class="nav-toggle" aria-label="Open menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="nav-overlay"></div>
    <div class="nav-menu">
        <div class="nav-menu-header">
            <span class="nav-logo">Adgon</span>
            <button type="button" class="nav-close" aria-label="Close menu">&times;</button>
        </div>
        <div class="nav-menu-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}#philosophy">About</a>
            <a href="{{ route('shop.index') }}">Shop</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @endif
            @else
                <a href="{{ route('login') }}">Account</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
        <div class="nav-menu-social">
            <span class="eyebrow">Follow Us</span>
            <a href="#">Instagram</a>
            <a href="#">TikTok</a>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="alert-bar error" role="alert">
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-bar success" role="alert">
            <div>{{ session('success') }}</div>
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Cart Drawer -->
    <div class="cart-overlay"></div>
    @include('partials.cart-drawer')

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <span class="nav-logo">Adgon</span>
                    <p>Premium apparel engineered for modern style. Curated collections designed to define, elevate, and endure.</p>
                    <div class="footer-social">
                        <a href="#">Instagram</a>
                        <a href="#">TikTok</a>
                    </div>
                </div>
                <div class="footer-links">
                    <h5>Explore</h5>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('home') }}#philosophy">About Us</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a href="{{ route('shop.index') }}">New Arrivals</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h5>Subscribe</h5>
                    <p style="font-size:0.85rem; line-height:1.6;">Get early access to new drops and exclusive offers.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="Your email address" aria-label="Email">
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }}. All rights reserved. ADGON</span>
                <div class="footer-bottom-links">
                    <a href="#">Return Policy</a>
                    <a href="#">Terms &amp; Conditions</a>
                    <a href="#">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.ADGON_ROUTES = {
            cartAdd: '{{ route('cart.add') }}',
            cartUpdate: '{{ url('/cart/update') }}',
            cartRemove: '{{ url('/cart/remove') }}',
        };
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
