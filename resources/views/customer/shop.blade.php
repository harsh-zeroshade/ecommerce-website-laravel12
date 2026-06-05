@extends('layouts.app')

@section('title', 'Shop')

@section('content')

<div class="shop-header">
    <div class="container">
        <span class="eyebrow reveal">Shop</span>
        <h1 class="display-lg reveal reveal-delay-1">The Collection</h1>
        <p class="text-muted reveal reveal-delay-2" style="max-width:500px; margin:1rem auto 0;">
            Browse all styles curated for a modern wardrobe and effortless everyday outfits.
        </p>
    </div>
</div>

<div class="container shop-layout">
    <!-- Filters Sidebar -->
    <aside class="shop-filters reveal">
        <div class="filter-card">
            <h4>Filters</h4>
            <form method="GET" action="{{ route('shop.index') }}" id="filterForm">
                <div class="filter-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search" placeholder="Search products..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort">Sort By</label>
                    <select id="sort" name="sort">
                        <option value="">Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm" style="width:100%; margin-bottom:0.75rem;">
                    <span>Apply</span>
                </button>
                <a href="{{ route('shop.index') }}" class="btn btn-outline btn-sm" style="width:100%; display:flex;">
                    <span>Clear</span>
                </a>
            </form>
        </div>
    </aside>

    <!-- Products -->
    <div>
        <div class="shop-results-meta reveal">
            <span>Showing {{ $products->count() }} {{ Str::plural('product', $products->count()) }}</span>
            @if(request('category'))
                @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
                @if($activeCat)
                    <span>in <strong>{{ $activeCat->name }}</strong></span>
                @endif
            @endif
        </div>

        <div class="collection-grid">
            @forelse($products as $product)
                @include('partials.product-tile', ['product' => $product])
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:4rem 0;">
                    <i class="bi bi-search" style="font-size:3rem; color:var(--sand);"></i>
                    <p class="text-muted" style="margin-top:1rem;">No products found. Try adjusting your filters.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm" style="margin-top:1.5rem;"><span>View All</span></a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="pagination-wrapper">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
