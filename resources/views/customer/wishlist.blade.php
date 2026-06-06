@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')

<section class="wishlist-page">
    <div class="container">

        {{-- Page header --}}
        <div class="wishlist-page-header reveal">
            <div class="wishlist-page-header-text">
                <span class="eyebrow">Your Collection</span>
                <h1 class="display-lg">My Wishlist</h1>
                <p class="wishlist-page-sub">
                    @if($wishlistItems->count() > 0)
                        {{ $wishlistItems->count() }} {{ Str::plural('piece', $wishlistItems->count()) }} saved for later — ready when you are.
                    @else
                        Pieces you love will be saved here. Tap the heart on any product to begin curating.
                    @endif
                </p>
            </div>
            @if($wishlistItems->count() > 0)
                <button type="button" class="wishlist-clear-btn" id="wishlistClearBtn">
                    <i class="bi bi-trash3"></i>
                    <span>Clear all</span>
                </button>
            @endif
        </div>

        @if(session('success'))
            <div class="alert-bar success wishlist-flash" role="alert">
                <div><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
                <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @if($wishlistItems->count() > 0)
            <div class="wishlist-grid">
                @foreach($wishlistItems as $row)
                    @php $product = $row->product; @endphp
                    <article class="wishlist-card reveal" data-product-id="{{ $product->id }}">

                        <a href="{{ route('product.show', $product) }}" class="wishlist-card-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="wishlist-card-placeholder"><i class="bi bi-bag"></i></div>
                            @endif

                            @if($product->discount_percentage > 0)
                                <span class="wishlist-card-badge">{{ $product->discount_percentage }}% Off</span>
                            @endif

                            @if($product->stock <= 0)
                                <span class="wishlist-card-badge wishlist-card-badge--sold">Sold Out</span>
                            @endif
                        </a>

                        <button type="button" class="wishlist-card-remove" data-wishlist-remove="{{ $product->id }}" aria-label="Remove from wishlist" title="Remove">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <div class="wishlist-card-body">
                            @if($product->category)
                                <span class="eyebrow wishlist-card-category">{{ $product->category->name }}</span>
                            @endif

                            <a href="{{ route('product.show', $product) }}" class="wishlist-card-name">{{ $product->name }}</a>

                            @php
                                $rCount = $product->reviews()->count();
                                $rAvg = $rCount > 0 ? round($product->reviews()->avg('rating'), 1) : 0;
                            @endphp

                            @if($rCount > 0)
                                <div class="wishlist-card-rating">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rAvg)
                                                <i class="bi bi-star-fill"></i>
                                            @elseif($i - 0.5 <= $rAvg)
                                                <i class="bi bi-star-half"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-value">{{ $rAvg }}</span>
                                </div>
                            @endif

                            <div class="wishlist-card-price-row">
                                <div class="wishlist-card-price">
                                    ₹{{ number_format($product->price, 2) }}
                                    @if($product->discount_percentage > 0)
                                        <span class="wishlist-card-price-old">₹{{ number_format($product->price / (1 - $product->discount_percentage / 100), 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="wishlist-card-actions">
                                @if($product->stock > 0)
                                    <button type="button" class="btn btn-primary btn-sm wishlist-add-to-cart" data-product-id="{{ $product->id }}" onclick="addToCart({{ $product->id }}, 1, 'M', this);">
                                        <i class="bi bi-bag-plus"></i> Add to Cart
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-sold-out" disabled>Out of Stock</button>
                                @endif
                                <button type="button" class="btn btn-outline btn-sm" data-wishlist-btn data-product-id="{{ $product->id }}" onclick="toggleWishlist({{ $product->id }}, this);">
                                    <i class="bi bi-heart-fill"></i> Saved
                                </button>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>
        @else
            <div class="wishlist-empty reveal">
                <div class="wishlist-empty-icon">
                    <i class="bi bi-heart"></i>
                </div>
                <h2 class="display-md">Your wishlist is empty</h2>
                <p>Tap the heart on any product to save it for later. Your favorites will live right here.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-grid-3x3-gap"></i> Browse Collection
                </a>
            </div>
        @endif

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Remove single item via the X button on each card */
    document.querySelectorAll('[data-wishlist-remove]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const productId = btn.dataset.wishlistRemove;
            const card = btn.closest('.wishlist-card');
            if (!card) return;

            // Animate the card out before the request finishes
            card.classList.add('is-removing');

            try {
                const res = await fetch(window.ADGON_ROUTES.wishlistRemove + productId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                updateWishlistCount(data.count);
                showToast(data.message || 'Removed from your wishlist.', 'info');

                setTimeout(() => {
                    card.remove();
                    // If no cards left, reload to show the empty state
                    if (!document.querySelectorAll('.wishlist-card').length) {
                        location.reload();
                    }
                }, 350);
            } catch (e) {
                card.classList.remove('is-removing');
                showToast('Something went wrong. Please try again.', 'error');
            }
        });
    });

    /* Clear all */
    const clearBtn = document.getElementById('wishlistClearBtn');
    if (clearBtn) {
        clearBtn.addEventListener('click', async () => {
            if (!confirm('Remove all items from your wishlist?')) return;

            const cards = Array.from(document.querySelectorAll('.wishlist-card'));
            cards.forEach((c, i) => setTimeout(() => c.classList.add('is-removing'), i * 60));

            // Fire sequential removals in background
            for (const card of cards) {
                const id = card.dataset.productId;
                try {
                    await fetch(window.ADGON_ROUTES.wishlistRemove + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                } catch (e) { /* ignore */ }
            }

            updateWishlistCount(0);
            showToast('Wishlist cleared.', 'info');
            setTimeout(() => location.reload(), 500);
        });
    }
});
</script>
@endsection
