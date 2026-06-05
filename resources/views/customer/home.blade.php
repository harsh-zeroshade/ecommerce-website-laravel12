@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Hero -->
<section class="hero hero--with-image">
    <div class="hero-bg"></div>
    <div class="hero-image" style="background-image: url('https://images.unsplash.com/photo-1483985988355-763728ad1994?w=1920&q=80');"></div>
    <div class="container hero-content">
        <p class="eyebrow reveal">Premium Clothing</p>
        <h1 class="display-xl reveal reveal-delay-1">
            Engineered for<br><em>Ultimate</em> Style
        </h1>
        <p class="hero-subtitle reveal reveal-delay-2">
            Curated apparel and statement pieces designed to define your wardrobe — built for comfort, crafted for confidence.
        </p>
        <div class="hero-cta reveal reveal-delay-3">
            <a href="{{ route('shop.index') }}" class="btn btn-primary"><span>Shop Collection</span></a>
            <a href="#collection" class="btn btn-outline"><span>Explore</span></a>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Scroll Down</span>
        <div class="hero-scroll-line"></div>
    </div>
</section>

<!-- Marquee -->
<section class="marquee-section">
    <div class="marquee-track">
        <span class="marquee-item">New Season Drop</span>
        <span class="marquee-item">Free Shipping Over ₹999</span>
        <span class="marquee-item">Premium Fabrics</span>
        <span class="marquee-item">Sustainable Style</span>
        <span class="marquee-item">Crafted in India</span>
        <span class="marquee-item">Limited Edition</span>
    </div>
</section>

<!-- The Collection -->
<section class="section" id="collection">
    <div class="container">
        <div class="section-label reveal">
            <span class="eyebrow">The Collection</span>
            <h2 class="display-md">Curated for the modern wardrobe</h2>
        </div>
        <div class="collection-grid">
            @forelse($featuredProducts as $product)
                @include('partials.product-tile', ['product' => $product])
            @empty
                @for($i = 0; $i < 4; $i++)
                <div class="product-tile reveal">
                    <div class="product-tile-image">
                        <div class="product-tile-placeholder"><i class="bi bi-bag"></i></div>
                    </div>
                    <div class="product-tile-info">
                        <h3>Coming Soon</h3>
                        <div class="price">—</div>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
        @if($featuredProducts->count() > 0)
        <div style="text-align:center; margin-top:3rem;" class="reveal">
            <a href="{{ route('shop.index') }}" class="btn btn-ghost">View All Products</a>
        </div>
        @endif
    </div>
</section>

<!-- Philosophy -->
<section class="section philosophy" id="philosophy">
    <div class="container">
        <div class="philosophy-grid">
            <div class="philosophy-text reveal">
                <span class="eyebrow">Our Philosophy</span>
                <h2 class="display-lg">Our pieces are designed as Style Fitness Tools</h2>
                <div class="philosophy-pillars">
                    <div class="pillar">
                        <strong>Define</strong>
                        <span>Building a wardrobe that reflects your identity with intention and clarity.</span>
                    </div>
                    <div class="pillar">
                        <strong>Elevate</strong>
                        <span>Transforming everyday outfits into confident, polished statements.</span>
                    </div>
                    <div class="pillar">
                        <strong>Endure</strong>
                        <span>Premium fabrics and timeless cuts that perform season after season.</span>
                    </div>
                </div>
                <a href="{{ route('shop.index') }}" class="btn btn-primary" style="margin-top:2.5rem;"><span>Explore Collection</span></a>
            </div>
            <div class="philosophy-visual reveal reveal-delay-2">
                <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?w=900&q=80" alt="ADGON premium clothing collection" loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Wardrobe System -->
<section class="section wardrobe-system" id="wardrobe">
    <div class="container">
        <div class="wardrobe-header reveal">
            <div class="wardrobe-number">4</div>
            <span class="eyebrow">The Wardrobe System</span>
            <h2 class="display-lg">Essential layers</h2>
            <p>Four foundational steps that support versatility, confidence, and long-term style performance.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-outline" style="margin-top:2rem; border-color:var(--gold); color:var(--gold);"><span>Shop</span></a>
        </div>

        @php
            $steps = [
                ['num' => '1', 'label' => 'Foundation', 'title' => 'Base Layers', 'desc' => 'Essential tees, shirts, and everyday staples that form the backbone of every outfit. Soft fabrics, perfect fits, built to layer.'],
                ['num' => '2', 'label' => 'Statement', 'title' => 'Core Pieces', 'desc' => 'Bold silhouettes and signature designs that command attention. The pieces that define your personal aesthetic.'],
                ['num' => '3', 'label' => 'Layer', 'title' => 'Outerwear', 'desc' => 'Jackets, coats, and knitwear engineered for transitional weather. Structure meets softness in every stitch.'],
                ['num' => '4', 'label' => 'Finish', 'title' => 'Accessories', 'desc' => 'The final details — bags, belts, and accents that complete the look and elevate any ensemble.'],
            ];
            $stepProducts = $featuredProducts->count() >= 4
                ? $featuredProducts->take(4)
                : $featuredProducts->merge($newArrivals)->unique('id')->take(4);
        @endphp

        <div class="wardrobe-layout">
            <div class="step-indicators">
                @foreach($steps as $step)
                    <div class="step-indicator {{ $loop->first ? 'active' : '' }}" data-step="{{ $step['num'] }}">
                        {{ $step['num'] }}/ {{ $step['label'] }}
                    </div>
                @endforeach
            </div>

            <div class="wardrobe-steps">
                @foreach($steps as $index => $step)
                    @php $product = $stepProducts->get($index); @endphp
                    <div class="wardrobe-step {{ $loop->first ? 'active' : '' }}" data-step="{{ $step['num'] }}">
                        <div class="step-content">
                            <div class="step-number">{{ $step['num'] }}/</div>
                            <h3>{{ $step['label'] }}</h3>
                            @if($product)
                                <div class="product-name">{{ strtoupper($product->name) }}</div>
                            @else
                                <div class="product-name">{{ strtoupper($step['title']) }}</div>
                            @endif
                            <p>{{ $step['desc'] }}</p>
                            @if($product)
                                <a href="{{ route('product.show', $product) }}" class="btn btn-outline btn-sm" style="margin-top:1.5rem; border-color:var(--gold); color:var(--gold);">
                                    <span>View — ₹{{ number_format($product->price, 2) }}</span>
                                </a>
                            @endif
                        </div>
                        <div class="step-image">
                            @if($product && $product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="step-image-placeholder">
                                    <i class="bi bi-{{ ['shirt', 'stars', 'layers', 'handbag'][$index] }}"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="section">
    <div class="container">
        <div class="section-label reveal">
            <span class="eyebrow">Categories</span>
            <h2 class="display-md">Shop by category</h2>
        </div>
        <div class="categories-strip reveal">
            <a href="{{ route('shop.index') }}" class="category-chip {{ !request('category') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="category-chip">
                    <i class="bi bi-tag"></i> {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- New Arrivals -->
<section class="section" style="background:var(--cream);">
    <div class="container">
        <div class="section-label reveal">
            <span class="eyebrow">Just Dropped</span>
            <h2 class="display-md">New arrivals</h2>
        </div>
        <div class="collection-grid">
            @forelse($newArrivals as $product)
                @include('partials.product-tile', ['product' => $product])
            @empty
                <p class="text-muted" style="grid-column:1/-1; text-align:center;">No new arrivals yet.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Top Rated -->
@if($topRatedProducts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-label reveal">
            <span class="eyebrow">Customer Favorites</span>
            <h2 class="display-md">Top rated</h2>
        </div>
        <div class="collection-grid">
            @foreach($topRatedProducts as $product)
                @include('partials.product-tile', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
