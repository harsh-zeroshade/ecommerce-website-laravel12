<div class="product-tile reveal">
    <a href="{{ route('product.show', $product) }}">
        <div class="product-tile-image">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <div class="product-tile-placeholder">
                    <i class="bi bi-bag"></i>
                </div>
            @endif

            @if($product->discount_percentage > 0)
                <span class="product-tile-badge">{{ $product->discount_percentage }}% Off</span>
            @endif

            @if($product->stock > 0)
                @php $isWished = in_array($product->id, $wishlistProductIds ?? [], true); @endphp
                <div class="product-tile-actions">
                    <button type="button" class="product-action-btn" title="View Product" onclick="event.preventDefault(); window.location='{{ route('product.show', $product) }}'">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button type="button" class="product-action-btn" title="Add to Cart" onclick="event.preventDefault(); addToCart({{ $product->id }})">
                        <i class="bi bi-bag-plus"></i>
                    </button>
                    <button type="button" class="product-action-btn product-action-btn--wishlist {{ $isWished ? 'is-wishlisted' : '' }}" data-product-id="{{ $product->id }}" data-wishlist-btn title="{{ $isWished ? 'Remove from Wishlist' : 'Add to Wishlist' }}" onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist({{ $product->id }}, this);">
                        <i class="bi {{ $isWished ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    </button>
                </div>
            @endif

            @if($product->stock <= 0)
                <span class="product-tile-badge" style="background: #c0392b;">Sold Out</span>
            @endif
        </div>
        <div class="product-tile-info">
            <h3>{{ $product->name }}</h3>
            
            @php
                $reviewCount = $product->reviews()->count();
                $avgRating = $reviewCount > 0 ? round($product->reviews()->avg('rating'), 1) : 0;
            @endphp
            
            <div class="product-rating">
                @if($reviewCount > 0)
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRating)
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - 0.5 <= $avgRating)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="rating-value">{{ $avgRating }}</span>
                    <span class="review-count">({{ $reviewCount }})</span>
                @else
                    <span class="no-reviews">No reviews yet</span>
                @endif
            </div>
            
            <div class="price">
                ₹{{ number_format($product->price, 2) }}
                @if($product->discount_percentage > 0)
                    <span class="price-original">₹{{ number_format($product->price / (1 - $product->discount_percentage / 100), 2) }}</span>
                @endif
            </div>
        </div>
    </a>
</div>
