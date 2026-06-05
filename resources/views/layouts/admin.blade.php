<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — ADGON Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="brand">Adgon</a>
                <span class="brand-sub">Admin Panel</span>
            </div>

            <ul class="admin-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="{{ Route::is('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-bag"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-list-ul"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" class="{{ Route::is('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar-footer">
                <a href="{{ route('home') }}">
                    <i class="bi bi-shop"></i>
                    <span>View Store</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <h2>@yield('title')</h2>
                <div style="display:flex; align-items:center;">
                    <a href="{{ route('home') }}" class="store-link">Storefront</a>
                    <span class="user-badge">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <div class="admin-content">
                @if($errors->any())
                    <div class="admin-alert admin-alert-error">
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="button" class="admin-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="admin-alert admin-alert-success">
                        <div>{{ session('success') }}</div>
                        <button type="button" class="admin-alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
