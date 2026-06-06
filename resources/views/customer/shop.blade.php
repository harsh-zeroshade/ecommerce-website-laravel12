@extends('layouts.app')

@section('title', 'Shop')

@section('content')

<!-- Shop Header -->
<section class="shop-hero">
    <div class="container">
        <div class="shop-hero-inner reveal">
            <span class="eyebrow">The Collection</span>
            <h1 class="display-lg">Curated for you</h1>
            <p class="shop-hero-desc">
                Browse through our thoughtfully selected pieces — each designed to elevate your everyday style.
            </p>
        </div>
    </div>
</section>

<!-- Filter Bar -->
<div class="shop-filter-bar" id="shopFilterBar">
    <div class="container">
        <div class="shop-filter-bar-inner">
            <button type="button" class="shop-filter-toggle" aria-label="Toggle filters">
                <i class="bi bi-sliders"></i>
                <span>Filters</span>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <span class="filter-active-dot"></span>
                @endif
            </button>

            <form method="GET" action="{{ route('shop.index') }}" id="filterForm" class="shop-filter-form" autocomplete="off">
                <div class="filter-row">
                    <!-- Search -->
                    <div class="filter-field filter-field--search">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" placeholder="Search pieces..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('shop.index', array_merge(request()->except('search', 'page'))) }}" class="filter-field-clear">&times;</a>
                        @endif
                    </div>

                    <!-- Category -->
                    <div class="filter-field filter-field--select">
                        <select name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <i class="bi bi-chevron-down"></i>
                    </div>

                    <!-- Sort -->
                    <div class="filter-field filter-field--select">
                        <select name="sort" onchange="this.form.submit()">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        </select>
                        <i class="bi bi-chevron-down"></i>
                    </div>

                    @if(request()->hasAny(['search', 'category', 'sort']))
                        <a href="{{ route('shop.index') }}" class="filter-clear-btn" title="Clear all filters">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>

            <div class="shop-results-count">
                <strong>{{ $products->total() ?? $products->count() }}</strong>
                {{ Str::plural('piece', $products->total() ?? $products->count()) }}
            </div>
        </div>
    </div>
</div>

<!-- Active filters tags -->
@if(request()->hasAny(['search', 'category', 'sort']))
<div class="active-filters-bar">
    <div class="container">
        <div class="active-filters-bar-inner">
            <span class="active-filters-label">Active:</span>
            <div class="active-filters-tags">
                @if(request('search'))
                    <span class="filter-tag">
                        "{{ request('search') }}"
                        <a href="{{ route('shop.index', array_merge(request()->except('search', 'page'))) }}">&times;</a>
                    </span>
                @endif
                @if(request('category'))
                    @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                    @if($activeCat)
                        <span class="filter-tag">
                            {{ $activeCat->name }}
                            <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}">&times;</a>
                        </span>
                    @endif
                @endif
                @if(request('sort'))
                    <span class="filter-tag">
                        @switch(request('sort'))
                            @case('price_low') Price: Low to High @break
                            @case('price_high') Price: High to Low @break
                            @case('rating') Top Rated @break
                        @endswitch
                        <a href="{{ route('shop.index', array_merge(request()->except('sort', 'page'))) }}">&times;</a>
                    </span>
                @endif
            </div>
            <a href="{{ route('shop.index') }}" class="active-filters-clear-all">Clear All</a>
        </div>
    </div>
</div>
@endif

<!-- Products -->
<section class="shop-products-section">
    <div class="container">
        @if($products->count() > 0)
            <div class="collection-grid shop-grid">
                @foreach($products as $product)
                    @include('partials.product-tile', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="shop-empty">
                <div class="shop-empty-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3>No pieces found</h3>
                <p>We couldn't find anything matching your criteria. Try adjusting the filters or browse the full collection.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">
                    <span>View All Pieces</span>
                </a>
            </div>
        @endif

        @if($products->hasPages())
            <div class="shop-pagination">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

@endsection