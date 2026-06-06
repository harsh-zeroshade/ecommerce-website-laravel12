<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — ADGON Admin</title>
    <script>
        (function() {
            const theme = localStorage.getItem('adgon-admin-theme');
            if (theme === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
        })();
    </script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
    <style>
        /* Loading Overlay - Global */
        .global-loading-overlay {
            position: fixed;
            inset: 0;
            background: var(--admin-surface);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1.5rem;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        
        .global-loading-overlay.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        
        .global-loading-logo {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 800;
            color: #faf8f5;
            letter-spacing: 0.05em;
            animation: global-logo-pulse 2s ease-in-out infinite;
            box-shadow: 0 20px 60px rgba(184, 149, 106, 0.3);
        }
        
        @keyframes global-logo-pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 20px 60px rgba(184, 149, 106, 0.3); }
            50% { transform: scale(1.08); box-shadow: 0 25px 80px rgba(184, 149, 106, 0.4); }
        }
        
        .global-loading-spinner {
            width: 44px;
            height: 44px;
            border: 3px solid var(--admin-border);
            border-top-color: var(--admin-gold);
            border-radius: 50%;
            animation: global-spin 0.8s linear infinite;
        }
        
        @keyframes global-spin {
            to { transform: rotate(360deg); }
        }
        
        .global-loading-text {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--admin-muted);
            letter-spacing: 0.08em;
        }
        
        .global-loading-brand {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--admin-text);
            margin-top: -0.5rem;
        }
    </style>
</head>
<body>
    <!-- Global Loading Overlay -->
    <div class="global-loading-overlay" id="globalLoadingOverlay">
        <div class="global-loading-logo">A</div>
        <div class="global-loading-brand">ADGON</div>
        <div class="global-loading-spinner"></div>
        <div class="global-loading-text">Loading...</div>
    </div>

    <div class="admin-wrapper">
        <div class="admin-sidebar-overlay" aria-hidden="true"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <div class="admin-sidebar-brand">
                    <a href="{{ route('admin.dashboard') }}" class="brand">Adgon</a>
                    <span class="brand-sub">Admin Panel</span>
                </div>
                <button type="button" class="admin-sidebar-close" aria-label="Close sidebar">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <ul class="admin-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ Route::is('admin.products.*') ? 'active' : '' }}" title="Products">
                        <i class="bi bi-bag-fill"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ Route::is('admin.categories.*') ? 'active' : '' }}" title="Categories">
                        <i class="bi bi-layers-fill"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ Route::is('admin.orders.*') ? 'active' : '' }}" title="Orders">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}" title="Users">
                        <i class="bi bi-people-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar-footer">
                <a href="{{ route('home') }}" title="View Store">
                    <i class="bi bi-shop-window"></i>
                    <span>View Store</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button type="button" class="admin-sidebar-toggle" aria-label="Toggle sidebar" aria-expanded="true">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <h2>@yield('title')</h2>
                </div>
                <div class="admin-topbar-actions">
                    <button type="button" class="admin-theme-toggle" aria-label="Toggle dark mode" title="Toggle theme">
                        <i class="bi bi-moon-stars-fill theme-icon-dark"></i>
                        <i class="bi bi-sun-fill theme-icon-light"></i>
                    </button>
                    <a href="{{ route('home') }}" class="store-link">
                        <i class="bi bi-shop-window"></i>
                        <span class="store-link-text">Storefront</span>
                    </a>
                    <div class="admin-user-pill">
                        @include('partials.user-avatar', ['user' => auth()->user(), 'size' => 'sm'])
                        <div class="admin-user-pill-info">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="admin-content">
                @if($errors->any())
                    <div class="admin-notification admin-notification-error" id="notificationError">
                        <div class="admin-notification-icon">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="admin-notification-content">
                            <div class="admin-notification-title">Validation Error</div>
                            <div class="admin-notification-message">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                        <button type="button" class="admin-notification-close" onclick="this.closest('.admin-notification').style.opacity='0'; setTimeout(() => this.closest('.admin-notification').remove(), 300);">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="admin-notification admin-notification-success" id="notificationSuccess">
                        <div class="admin-notification-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="admin-notification-content">
                            <div class="admin-notification-title">Success</div>
                            <div class="admin-notification-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="admin-notification-close" onclick="this.closest('.admin-notification').style.opacity='0'; setTimeout(() => this.closest('.admin-notification').remove(), 300);">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-notification admin-notification-error" id="notificationError">
                        <div class="admin-notification-icon">
                            <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div class="admin-notification-content">
                            <div class="admin-notification-title">Error</div>
                            <div class="admin-notification-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="admin-notification-close" onclick="this.closest('.admin-notification').style.opacity='0'; setTimeout(() => this.closest('.admin-notification').remove(), 300);">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>
</html>
