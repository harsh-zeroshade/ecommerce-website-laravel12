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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    @yield('styles')
    <style>
        /* Customer Loading Overlay */
        .customer-loading-overlay {
            position: fixed;
            inset: 0;
            background: var(--bg);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1.5rem;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        
        .customer-loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        
        .customer-loading-logo {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--accent), #4a4540);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--cream);
            letter-spacing: 0.05em;
            animation: customer-logo-pulse 2s ease-in-out infinite;
            box-shadow: 0 20px 60px rgba(26, 26, 26, 0.2);
        }
        
        @keyframes customer-logo-pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 20px 60px rgba(26, 26, 26, 0.2); }
            50% { transform: scale(1.08); box-shadow: 0 25px 80px rgba(26, 26, 26, 0.25); }
        }
        
        .customer-loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: customer-spin 0.8s linear infinite;
        }
        
        @keyframes customer-spin {
            to { transform: rotate(360deg); }
        }
        
        .customer-loading-brand {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text);
        }
        
        .customer-loading-text {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.08em;
        }
    </style>
</head>
<body>
    <!-- Customer Loading Overlay -->
    <div class="customer-loading-overlay" id="customerLoadingOverlay">
        <div class="customer-loading-logo">A</div>
        <div class="customer-loading-brand">ADGON</div>
        <div class="customer-loading-spinner"></div>
        <div class="customer-loading-text">Loading...</div>
    </div>

    <nav class="site-nav">
        <div class="nav-inner">
            <div class="nav-links-left">
                <a href="{{ route('home') }}#philosophy"><i class="bi bi-stars"></i> About</a>
                <a href="{{ route('shop.index') }}"><i class="bi bi-grid-3x3-gap"></i> Shop</a>
            </div>

            <a href="{{ route('home') }}" class="nav-logo">Adgon</a>

            <div class="nav-actions">
                <button type="button" class="nav-action theme-toggle" aria-label="Toggle dark mode" title="Toggle theme">
                    <i class="bi bi-moon-stars-fill theme-icon-dark"></i>
                    <i class="bi bi-sun-fill theme-icon-light"></i>
                </button>

                @auth
                <a href="{{ route('wishlist.index') }}" class="nav-action wishlist-link" title="Wishlist" aria-label="Wishlist">
                    <i class="bi bi-heart{{ ($wishlistCount ?? 0) > 0 ? '-fill' : '' }}"></i>
                    <span class="nav-action-text">Wishlist</span>
                    <span class="wishlist-count{{ ($wishlistCount ?? 0) === 0 ? ' wishlist-count--hidden' : '' }}">{{ $wishlistCount ?? 0 }}</span>
                </a>
                @endauth

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-action nav-action--admin" title="Admin Panel">
                            @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'sm'])
                            <span class="nav-action-text">Admin</span>
                        </a>
                    @endif

                    @if(auth()->user()->isCustomer())
                        <div class="nav-account-dropdown">
                            <button type="button" class="nav-action nav-action--account">
                                @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'sm'])
                                <span class="nav-action-text">{{ auth()->user()->name }}</span>
                                <i class="bi bi-chevron-down nav-chevron"></i>
                            </button>

                            <div class="nav-account-dropdown-menu">
                                <div class="nav-dropdown-user">
                                    @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'md'])
                                    <div>
                                        <strong>{{ auth()->user()->name }}</strong>
                                        <span>{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                                <div class="nav-menu-divider"></div>
                                <a href="{{ route('account.profile') }}" class="nav-menu-item">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="{{ route('account.orders.index') }}" class="nav-menu-item">
                                    <i class="bi bi-bag-check"></i>
                                    <span>My Orders</span>
                                </a>
                                <a href="{{ route('account.tracking') }}" class="nav-menu-item">
                                    <i class="bi bi-truck"></i>
                                    <span>Track Orders</span>
                                </a>
                                <div class="nav-menu-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-menu-item nav-menu-item--danger">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="nav-action">
                        <i class="bi bi-person"></i>
                        <span class="nav-action-text">Account</span>
                    </a>
                @endauth

                <button type="button" class="nav-action cart-trigger" aria-label="Open cart">
                    <i class="bi bi-bag"></i>
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

    <div class="nav-overlay"></div>
    <div class="nav-menu">
        <div class="nav-menu-header">
            <span class="nav-logo">Adgon</span>
            <button type="button" class="nav-close" aria-label="Close menu">&times;</button>
        </div>

        @auth
        <div class="nav-menu-user">
            @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'lg'])
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <span>{{ auth()->user()->email }}</span>
            </div>
        </div>
        @endauth

        <div class="nav-menu-links">
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> Home</a>
            <a href="{{ route('home') }}#philosophy"><i class="bi bi-stars"></i> About</a>
            <a href="{{ route('shop.index') }}"><i class="bi bi-grid-3x3-gap"></i> Shop</a>
            <a href="{{ route('support.faq') }}"><i class="bi bi-question-circle"></i> FAQ</a>
            <a href="{{ route('support.shipping') }}"><i class="bi bi-truck"></i> Shipping</a>
            <a href="{{ route('support.returns') }}"><i class="bi bi-arrow-left-right"></i> Returns</a>
            <a href="{{ route('support.contact') }}"><i class="bi bi-envelope"></i> Contact</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Admin</a>
                @endif
                <a href="{{ route('account.profile') }}"><i class="bi bi-person-circle"></i> Profile</a>
                <a href="{{ route('account.orders.index') }}"><i class="bi bi-bag-check"></i> Orders</a>
            @else
                <a href="{{ route('login') }}"><i class="bi bi-person"></i> Account</a>
                <a href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Register</a>
            @endauth
        </div>

        <div class="nav-menu-social">
            <span class="eyebrow">Follow Us</span>
            @include('partials.social-links')
        </div>
    </div>

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

    <main>
        @yield('content')
    </main>

    <div class="cart-overlay"></div>
    @include('partials.cart-drawer')

    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <span class="nav-logo">Adgon</span>
                    <p>Premium apparel engineered for modern style. Curated collections designed to define, elevate, and endure.</p>
                    @include('partials.social-links', ['class' => 'social-links social-links--footer'])
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
                        <li><a href="{{ route('support.faq') }}">FAQ</a></li>
                        <li><a href="{{ route('support.shipping') }}">Shipping</a></li>
                        <li><a href="{{ route('support.returns') }}">Returns</a></li>
                        <li><a href="{{ route('support.contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h5>Subscribe</h5>
                    <p class="footer-subscribe-text">Get early access to new drops and exclusive offers.</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" placeholder="Your email address" aria-label="Email">
                        <button type="submit"><i class="bi bi-arrow-right"></i></button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }}. All rights reserved. ADGON</span>
                <div class="footer-bottom-links">
                    <a href="{{ route('legal.return-policy') }}">Return Policy</a>
                    <a href="{{ route('legal.terms') }}">Terms &amp; Conditions</a>
                    <a href="{{ route('legal.privacy-policy') }}">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.ADGON_ROUTES = {
            cartAdd: '{{ route('cart.add') }}',
            cartUpdate: '{{ url('/cart/update') }}',
            cartRemove: '{{ url('/cart/remove') }}',
            wishlistToggle: '{{ route('wishlist.toggle') }}',
            wishlistCount: '{{ route('wishlist.count') }}',
            loginUrl: '{{ route('login') }}',
            @auth
            wishlistRemove: '/wishlist/',
            @endauth
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
