@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Dashboard-specific styles */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    @media (min-width: 992px) {
        .dashboard-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .dashboard-grid > .dashboard-main {
            grid-column: 1;
        }
        
        .dashboard-grid > .dashboard-side {
            grid-column: 2;
        }
    }
    
    @media (min-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .stat-card-modern {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        padding: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: all var(--admin-transition);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--admin-gold);
        opacity: 0;
        transition: opacity var(--admin-transition);
    }
    
    .stat-card-modern:hover {
        box-shadow: 0 12px 40px rgba(26, 26, 26, 0.08);
        transform: translateY(-2px);
    }
    
    .stat-card-modern:hover::before {
        opacity: 1;
    }
    
    .stat-card-modern.revenue::before {
        background: var(--admin-success);
    }
    
    .stat-card-modern.orders::before {
        background: var(--admin-info);
    }
    
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
    }
    
    .stat-icon-wrapper i {
        font-size: 1.25rem;
        color: #faf8f5;
    }
    
    .stat-card-modern.revenue .stat-icon-wrapper {
        background: linear-gradient(135deg, var(--admin-success), #1e4d3a);
    }
    
    .stat-card-modern.orders .stat-icon-wrapper {
        background: linear-gradient(135deg, var(--admin-info), #2a4a6b);
    }
    
    .stat-content {
        flex: 1;
        min-width: 0;
    }
    
    .stat-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--admin-muted);
        margin-bottom: 0.25rem;
    }
    
    .stat-value {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-text);
        line-height: 1.2;
    }
    
    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.35rem;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
    }
    
    .stat-trend.positive {
        background: rgba(45, 106, 79, 0.1);
        color: var(--admin-success);
    }
    
    .stat-trend.neutral {
        background: var(--admin-bg);
        color: var(--admin-muted);
    }
    
    .chart-card {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        overflow: hidden;
    }
    
    .chart-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--admin-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }
    
    .chart-card-header h3 {
        font-family: var(--font-display);
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }
    
    .chart-card-header .chart-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .chart-btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-muted);
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .chart-btn:hover,
    .chart-btn.active {
        background: var(--admin-sidebar);
        color: #faf8f5;
        border-color: var(--admin-sidebar);
    }
    
    .chart-container {
        padding: 1.25rem;
        min-height: 250px;
    }
    
    .chart-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 200px;
        color: var(--admin-muted);
        text-align: center;
    }
    
    .chart-placeholder i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .revenue-chart {
        width: 100%;
        height: 200px;
    }
    
    .revenue-bar {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        height: 100%;
        padding-bottom: 1.5rem;
    }
    
    .revenue-bar-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        min-width: 0;
    }
    
    .revenue-bar-column {
        width: 100%;
        background: linear-gradient(180deg, var(--admin-gold), #8a6d4a);
        border-radius: 4px 4px 0 0;
        transition: all 0.3s ease;
        position: relative;
        min-height: 4px;
    }
    
    .revenue-bar-column:hover {
        background: linear-gradient(180deg, var(--admin-success), var(--admin-gold));
    }
    
    .revenue-bar-column::after {
        content: attr(data-value);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.6rem;
        font-weight: 600;
        color: var(--admin-text);
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.2s;
        margin-bottom: 0.25rem;
    }
    
    .revenue-bar-column:hover::after {
        opacity: 1;
    }
    
    .revenue-bar-label {
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--admin-muted);
    }
    
    .order-status-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    @media (min-width: 576px) {
        .order-status-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (min-width: 768px) {
        .order-status-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }
    
    .status-card {
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        padding: 1rem;
        text-align: center;
        transition: all var(--admin-transition);
    }
    
    .status-card:hover {
        box-shadow: 0 8px 24px rgba(26, 26, 26, 0.06);
        transform: translateY(-2px);
    }
    
    .status-card .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1.1rem;
    }
    
    .status-card.pending .status-icon {
        background: rgba(212, 160, 23, 0.15);
        color: var(--admin-warning);
    }
    
    .status-card.processing .status-icon {
        background: rgba(61, 107, 142, 0.15);
        color: var(--admin-info);
    }
    
    .status-card.shipped .status-icon {
        background: rgba(184, 149, 106, 0.15);
        color: var(--admin-gold);
    }
    
    .status-card.delivered .status-icon {
        background: rgba(45, 106, 79, 0.15);
        color: var(--admin-success);
    }
    
    .status-card.cancelled .status-icon {
        background: rgba(192, 57, 43, 0.15);
        color: var(--admin-danger);
    }
    
    .status-card .status-count {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-text);
        line-height: 1.2;
    }
    
    .status-card .status-label {
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--admin-muted);
        margin-top: 0.15rem;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    
    @media (min-width: 576px) {
        .quick-actions {
            grid-template-columns: repeat(4, 1fr);
        }
    }
    
    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: var(--admin-surface);
        border: 1px solid var(--admin-border);
        border-radius: var(--admin-radius);
        cursor: pointer;
        transition: all var(--admin-transition);
        text-decoration: none;
        color: inherit;
    }
    
    .quick-action-btn:hover {
        border-color: var(--admin-gold);
        box-shadow: 0 8px 24px rgba(26, 26, 26, 0.06);
        transform: translateY(-2px);
    }
    
    .quick-action-btn .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #faf8f5;
    }
    
    .quick-action-btn .action-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--admin-text);
        text-align: center;
    }
    
    /* Recent Orders Table */
    .recent-orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .recent-orders-table th {
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--admin-muted);
        text-align: left;
        padding: 0.75rem 1rem;
        background: var(--admin-bg);
        border-bottom: 1px solid var(--admin-border);
    }
    
    .recent-orders-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.8rem;
        vertical-align: middle;
    }
    
    .recent-orders-table tbody tr {
        transition: background 0.2s;
    }
    
    .recent-orders-table tbody tr:hover {
        background: rgba(244, 241, 236, 0.5);
    }
    
    .order-number {
        font-family: var(--font-display);
        font-weight: 600;
    }
    
    .customer-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .customer-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #faf8f5;
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .customer-name {
        font-weight: 500;
    }
    
    .customer-email {
        font-size: 0.7rem;
        color: var(--admin-muted);
    }
    
    .amount-cell {
        font-family: var(--font-display);
        font-weight: 600;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.6rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .status-badge.pending {
        background: rgba(212, 160, 23, 0.15);
        color: var(--admin-warning);
    }
    
    .status-badge.processing {
        background: rgba(61, 107, 142, 0.15);
        color: var(--admin-info);
    }
    
    .status-badge.shipped {
        background: rgba(184, 149, 106, 0.15);
        color: var(--admin-gold);
    }
    
    .status-badge.delivered {
        background: rgba(45, 106, 79, 0.15);
        color: var(--admin-success);
    }
    
    .status-badge.cancelled {
        background: rgba(192, 57, 43, 0.15);
        color: var(--admin-danger);
    }
    
    .date-cell {
        color: var(--admin-muted);
        font-size: 0.75rem;
    }
    
    .action-btn {
        padding: 0.3rem 0.6rem;
        font-size: 0.6rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .action-btn:hover {
        background: var(--admin-sidebar);
        color: #faf8f5;
        border-color: var(--admin-sidebar);
    }
    
    /* Top Products List */
    .top-products-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    
    .top-product-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--admin-border);
        transition: background 0.2s;
    }
    
    .top-product-item:last-child {
        border-bottom: none;
    }
    
    .top-product-item:hover {
        background: rgba(244, 241, 236, 0.5);
    }
    
    .top-product-rank {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: var(--admin-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--admin-muted);
        flex-shrink: 0;
    }
    
    .top-product-item:nth-child(1) .top-product-rank {
        background: linear-gradient(135deg, #ffd700, #b8860b);
        color: #1a1a1a;
    }
    
    .top-product-item:nth-child(2) .top-product-rank {
        background: linear-gradient(135deg, #c0c0c0, #8a8a8a);
        color: #1a1a1a;
    }
    
    .top-product-item:nth-child(3) .top-product-rank {
        background: linear-gradient(135deg, #cd7f32, #8b5a2b);
        color: #faf8f5;
    }
    
    .top-product-thumb {
        width: 40px;
        height: 50px;
        border-radius: 6px;
        overflow: hidden;
        background: var(--admin-bg);
        border: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    
    .top-product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .top-product-info {
        flex: 1;
        min-width: 0;
    }
    
    .top-product-name {
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 0.15rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.8rem;
    }
    
    .top-product-category {
        font-size: 0.7rem;
        color: var(--admin-muted);
    }
    
    .top-product-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.75rem;
    }
    
    .top-product-price {
        font-family: var(--font-display);
        font-weight: 600;
        color: var(--admin-text);
    }
    
    .top-product-rating {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--admin-gold);
        font-size: 0.7rem;
    }
    
    .top-product-reviews {
        font-size: 0.7rem;
        color: var(--admin-muted);
    }
    
    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--admin-sidebar) 0%, #2c2825 100%);
        border-radius: var(--admin-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        color: #faf8f5;
        position: relative;
        overflow: hidden;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(184, 149, 106, 0.15), transparent);
        border-radius: 50%;
    }
    
    .welcome-content {
        position: relative;
        z-index: 1;
        max-width: 500px;
    }
    
    .welcome-greeting {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--admin-gold);
        margin-bottom: 0.35rem;
    }
    
    .welcome-title {
        font-family: var(--font-display);
        font-size: clamp(1.25rem, 2.5vw, 1.75rem);
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }
    
    .welcome-subtitle {
        color: rgba(250, 248, 245, 0.7);
        font-size: 0.85rem;
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .welcome-stats {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .welcome-stat {
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
    }
    
    .welcome-stat-value {
        font-family: var(--font-display);
        font-size: 1.25rem;
        font-weight: 700;
    }
    
    .welcome-stat-label {
        font-size: 0.6rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: rgba(250, 248, 245, 0.5);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .welcome-banner {
            padding: 1.25rem;
        }
        
        .welcome-stats {
            gap: 1rem;
        }
        
        .chart-container {
            min-height: 200px;
            padding: 1rem;
        }
        
        .recent-orders-table th,
        .recent-orders-table td {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
        
        .top-product-item {
            padding: 0.5rem 0.75rem;
        }
        
        .quick-actions {
            grid-template-columns: 1fr 1fr;
        }
        
        .status-card .status-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }
        
        .status-card .status-count {
            font-size: 1.25rem;
        }
        
        .stat-card-modern {
            padding: 1rem;
        }
        
        .stat-icon-wrapper {
            width: 40px;
            height: 40px;
        }
        
        .stat-icon-wrapper i {
            font-size: 1rem;
        }
        
        .stat-value {
            font-size: 1.25rem;
        }
        
        .customer-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .top-product-meta {
            flex-direction: column;
            align-items: flex-end;
            gap: 0.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .welcome-title {
            font-size: 1.1rem;
        }
        
        .welcome-subtitle {
            font-size: 0.8rem;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
        
        .order-status-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-content">
        <div class="welcome-greeting">Welcome back, {{ auth()->user()->name }}</div>
        <h1 class="welcome-title">Here's what's happening with your store today</h1>
        <p class="welcome-subtitle">Track your key metrics, manage orders, and grow your business with actionable insights.</p>
        <div class="welcome-stats">
            <div class="welcome-stat">
                <span class="welcome-stat-value">{{ $totalOrders }}</span>
                <span class="welcome-stat-label">Total Orders</span>
            </div>
            <div class="welcome-stat">
                <span class="welcome-stat-value">₹{{ number_format($totalRevenue, 0) }}</span>
                <span class="welcome-stat-label">Total Revenue</span>
            </div>
            <div class="welcome-stat">
                <span class="welcome-stat-value">{{ $totalProducts }}</span>
                <span class="welcome-stat-label">Active Products</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="admin-stats" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card-modern">
        <div class="stat-icon-wrapper">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Customers</div>
            <div class="stat-value">{{ $totalUsers }}</div>
        </div>
    </div>
    
    <div class="stat-card-modern">
        <div class="stat-icon-wrapper">
            <i class="bi bi-bag"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
    </div>
    
    <div class="stat-card-modern">
        <div class="stat-icon-wrapper">
            <i class="bi bi-list-ul"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Categories</div>
            <div class="stat-value">{{ $totalCategories }}</div>
        </div>
    </div>
    
    <div class="stat-card-modern orders">
        <div class="stat-icon-wrapper">
            <i class="bi bi-receipt"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>
    </div>
    
    <div class="stat-card-modern revenue">
        <div class="stat-icon-wrapper">
            <i class="bi bi-currency-rupee"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">₹{{ number_format($totalRevenue, 0) }}</div>
        </div>
    </div>
</div>

<!-- Main Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Left Column (Main) -->
    <div class="dashboard-main">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-card-header">
                <h3>Revenue Overview</h3>
                <div class="chart-actions">
                    <button class="chart-btn active" data-period="month">Month</button>
                    <button class="chart-btn" data-period="quarter">Quarter</button>
                    <button class="chart-btn" data-period="year">Year</button>
                </div>
            </div>
            <div class="chart-container">
                <div class="revenue-chart">
                    <div class="revenue-bar">
                        @php
                            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                            $monthlyData = [];
                            foreach ($monthlyRevenue as $mr) {
                                $monthlyData[$mr->month] = $mr->revenue;
                            }
                            $maxRevenue = $monthlyRevenue->max('revenue') ?? 1;
                        @endphp
                        @for($m = 1; $m <= 12; $m++)
                            @php
                                $revenue = $monthlyData[$m] ?? 0;
                                $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 100 : 0;
                            @endphp
                            <div class="revenue-bar-item">
                                <div class="revenue-bar-column" style="height: {{ max(2, $height) }}%;" data-value="₹{{ number_format($revenue, 0) }}"></div>
                                <span class="revenue-bar-label">{{ $months[$m - 1] }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="chart-card" style="margin-top: 1.5rem;">
            <div class="chart-card-header">
                <h3>Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="chart-btn" style="background: var(--admin-sidebar); color: #faf8f5; border-color: var(--admin-sidebar);">View All</a>
            </div>
            <div style="overflow-x: auto;">
                @if($recentOrders->count() > 0)
                    <table class="recent-orders-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td class="order-number">#{{ $order->order_number }}</td>
                                <td>
                                    <div class="customer-info">
                                        @include('partials.user-avatar', ['user' => $order->user, 'size' => 'sm'])
                                        <div>
                                            <div class="customer-name">{{ $order->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="amount-cell">₹{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($order->order_status) {
                                            'delivered' => 'delivered',
                                            'pending' => 'pending',
                                            'cancelled' => 'cancelled',
                                            default => 'processing',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->order_status) }}</span>
                                </td>
                                <td class="date-cell">{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="action-btn">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="chart-placeholder">
                        <i class="bi bi-receipt-cutoff"></i>
                        <p>No orders yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Column (Side) -->
    <div class="dashboard-side">
        <!-- Order Status Breakdown -->
        <div class="chart-card">
            <div class="chart-card-header">
                <h3>Order Status</h3>
            </div>
            <div class="chart-container" style="min-height: auto;">
                <div class="order-status-grid">
                    @php
                        $statuses = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled'];
                        $icons = ['pending' => 'bi-clock', 'processing' => 'bi-gear', 'shipped' => 'bi-truck', 'delivered' => 'bi-check2-circle', 'cancelled' => 'bi-x-circle'];
                    @endphp
                    @foreach($statuses as $key => $label)
                        @php
                            $count = $orderStatusStats[$key] ?? 0;
                        @endphp
                        <div class="status-card {{ $key }}">
                            <div class="status-icon">
                                <i class="bi {{ $icons[$key] }}"></i>
                            </div>
                            <div class="status-count">{{ $count }}</div>
                            <div class="status-label">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="chart-card" style="margin-top: 1.5rem;">
            <div class="chart-card-header">
                <h3>Quick Actions</h3>
            </div>
            <div class="chart-container" style="min-height: auto;">
                <div class="quick-actions">
                    <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                        <div class="action-icon"><i class="bi bi-plus-lg"></i></div>
                        <span class="action-label">Add Product</span>
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="quick-action-btn">
                        <div class="action-icon"><i class="bi bi-tag"></i></div>
                        <span class="action-label">Add Category</span>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="quick-action-btn">
                        <div class="action-icon"><i class="bi bi-person-plus"></i></div>
                        <span class="action-label">Add User</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="quick-action-btn">
                        <div class="action-icon"><i class="bi bi-receipt"></i></div>
                        <span class="action-label">Orders</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Top Products -->
        <div class="chart-card" style="margin-top: 1.5rem;">
            <div class="chart-card-header">
                <h3>Top Products</h3>
                <a href="{{ route('admin.products.index') }}" class="chart-btn" style="background: var(--admin-sidebar); color: #faf8f5; border-color: var(--admin-sidebar);">View All</a>
            </div>
            <div style="min-height: 200px;">
                @if($topProducts->count() > 0)
                    <div class="top-products-list">
                        @foreach($topProducts as $index => $product)
                            <div class="top-product-item">
                                <div class="top-product-rank">{{ $index + 1 }}</div>
                                <div class="top-product-thumb">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--admin-muted);"><i class="bi bi-image"></i></div>
                                    @endif
                                </div>
                                <div class="top-product-info">
                                    <div class="top-product-name">{{ $product->name }}</div>
                                    <div class="top-product-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                </div>
                                <div class="top-product-meta">
                                    <span class="top-product-price">₹{{ number_format($product->price, 2) }}</span>
                                    <div class="top-product-rating">
                                        @for($i = 0; $i < floor($product->rating); $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                        <span class="top-product-reviews">({{ $product->reviews_count }})</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="chart-placeholder">
                        <i class="bi bi-bag"></i>
                        <p>No products yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Chart period buttons
    document.querySelectorAll('.chart-btn[data-period]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.chart-btn[data-period]').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
});
</script>
@endsection