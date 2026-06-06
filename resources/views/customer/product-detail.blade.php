@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Gallery -->
            @php
                $galleryImages = $product->images ?? null;
                if (is_string($galleryImages)) {
                    $galleryImages = json_decode($galleryImages, true);
                }
                $galleryImages = is_array($galleryImages) ? array_values(array_filter($galleryImages)) : [];
                $fallbackImage = $product->image;
                $carouselImages = !empty($galleryImages) ? $galleryImages : ($fallbackImage ? [$fallbackImage] : []);
            @endphp

            <div class="product-gallery reveal">
                @if(empty($carouselImages))
                    <div class="product-gallery-placeholder">
                        <i class="bi bi-bag"></i>
                    </div>
                @else
                    <div class="product-gallery-main" id="productCarousel" data-total="{{ count($carouselImages) }}">
                        <div class="product-gallery-viewport">
                            <button type="button" class="gallery-btn gallery-btn--prev" id="carouselPrev" aria-label="Previous image">‹</button>
                            <button type="button" class="gallery-btn gallery-btn--next" id="carouselNext" aria-label="Next image">›</button>

                            <div class="gallery-track-wrap">
                                <div class="gallery-track" id="carouselTrack">
                                    @foreach($carouselImages as $img)
                                        <div class="gallery-slide">
                                            <div class="gallery-zoom">
                                                <img class="gallery-zoom-img" src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if(count($carouselImages) > 1)
                            <div class="gallery-thumbs">
                                @foreach($carouselImages as $idx => $img)
                                    <button type="button" class="gallery-thumb" data-index="{{ $idx }}" aria-label="Go to image {{ $idx + 1 }}">
                                        <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }} thumbnail {{ $idx + 1 }}" id="thumb-{{ $idx }}">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="product-info reveal reveal-delay-1">
                @php
                    $productReviews = $product->reviews ?? collect();
                    $productReviewsCount = $productReviews->count();
                    $productAvgRating = $productReviewsCount > 0 ? round($productReviews->avg('rating'), 1) : 0;
                @endphp

                @if($product->category)
                    <span class="eyebrow">{{ $product->category->name }}</span>
                @endif

                <h1>{{ $product->name }}</h1>

                @if($productAvgRating > 0)
                    <div class="product-rating-summary">
                        <div class="stars">
                            @for($i = 0; $i < 5; $i++)
                                <i class="{{ $i < floor($productAvgRating) ? 'bi bi-star-fill' : 'bi bi-star' }}"></i>
                            @endfor
                        </div>
                        <div class="rating-text">
                            <strong>{{ $productAvgRating }}/5</strong>
                            <span>{{ $productReviewsCount }} {{ Str::plural('review', $productReviewsCount) }}</span>
                        </div>
                    </div>
                @endif

                <div class="product-price-block">
                    <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
                    @if($product->discount_percentage > 0)
                        <span class="product-price-old">₹{{ number_format($product->price / (1 - $product->discount_percentage / 100), 2) }}</span>
                        <span class="product-tile-badge">{{ $product->discount_percentage }}% Off</span>
                    @endif
                </div>

                @if($product->short_description)
                    <p class="product-short-desc">{{ $product->short_description }}</p>
                @endif

                <!-- Size Selector -->
                <div class="size-selector">
                    <label>Select Size</label>
                    <div class="size-options">
                        @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
                            <button type="button" class="size-option {{ $size === 'M' ? 'active' : '' }}" onclick="document.querySelectorAll('.size-option').forEach(s=>s.classList.remove('active')); this.classList.add('active');">{{ $size }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="product-meta">
                    <div class="product-meta-item">
                        <span>SKU</span>
                        <span>{{ $product->sku }}</span>
                    </div>
                    @if($product->brand)
                    <div class="product-meta-item">
                        <span>Brand</span>
                        <span>{{ $product->brand }}</span>
                    </div>
                    @endif
                    <div class="product-meta-item">
                        <span>Availability</span>
                        <span>
                            @if($product->stock > 0)
                                <span class="badge-stock badge-in-stock">In Stock ({{ $product->stock }})</span>
                            @else
                                <span class="badge-stock badge-out-stock">Out of Stock</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="product-actions">
                    @if($product->stock > 0)
                        <button type="button" class="btn btn-add-cart btn-lg" id="addToCartBtn"
                            data-product-id="{{ $product->id }}">
                            <i class="bi bi-bag-plus"></i> Add to Cart
                        </button>
                        @php $isWished = in_array($product->id, $wishlistProductIds ?? [], true); @endphp
                        <button type="button" class="btn btn-outline btn-lg product-wishlist-btn {{ $isWished ? 'is-wishlisted' : '' }}" id="wishlistDetailBtn" data-product-id="{{ $product->id }}" data-wishlist-btn onclick="event.preventDefault(); toggleWishlist({{ $product->id }}, this);">
                            <i class="bi {{ $isWished ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            <span class="wishlist-btn-label">{{ $isWished ? 'In Wishlist' : 'Add to Wishlist' }}</span>
                        </button>
                    @else
                        <button type="button" class="btn btn-lg btn-sold-out" disabled>
                            Out of Stock
                        </button>
                    @endif
                </div>

                <div class="product-description">
                    <h3>Description</h3>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        @php
            $reviews = $product->reviews ?? collect();
            $reviewsCount = $reviews->count();
            $avgRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 1) : 0;

            // Rating distribution
            $ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
            foreach ($reviews as $rev) {
                if (isset($ratingCounts[$rev->rating])) $ratingCounts[$rev->rating]++;
            }
        @endphp

        <section class="reviews-section">
            <div class="section-label reveal">
                <span class="eyebrow">Reviews</span>
                <h2 class="display-md">Customer Reviews</h2>
            </div>

            @if($reviewsCount > 0)
            <!-- Rating Summary -->
            <div class="reviews-summary reveal">
                <div class="reviews-summary-score">
                    <div class="score-number">{{ $avgRating }}</div>
                    <div class="score-stars">
                        @for($i = 0; $i < 5; $i++)
                            <i class="{{ $i < floor($avgRating) ? 'bi bi-star-fill' : 'bi bi-star' }}"></i>
                        @endfor
                    </div>
                    <div class="score-count">{{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }}</div>
                </div>
                <div class="reviews-summary-bars">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        @php
                            $pct = $reviewsCount > 0 ? round(($ratingCounts[$star] / $reviewsCount) * 100) : 0;
                        @endphp
                        <div class="rating-bar-row">
                            <span class="rating-bar-label">{{ $star }}</span>
                            <i class="bi bi-star-fill rating-bar-star"></i>
                            <div class="rating-bar-track">
                                <div class="rating-bar-fill" style="width: {{ $pct }}%;"></div>
                            </div>
                            <span class="rating-bar-count">{{ $ratingCounts[$star] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @forelse($reviews as $review)
            <div class="review-card reveal">
                <div class="review-card-top">
                    <div class="review-card-stars">
                        @for($i = 0; $i < $review->rating; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <i class="bi bi-star"></i>
                        @endfor
                        <span class="review-card-rating-text">{{ $review->rating }}/5</span>
                    </div>
                    <div class="review-card-date">{{ $review->created_at->diffForHumans() }}</div>
                </div>
                <h4 class="review-card-title">{{ $review->title }}</h4>
                <div class="review-card-author">
                    by {{ $review->user->name }}
                    @if($review->is_verified_purchase)
                        <span class="verified-badge">✓ Verified Purchase</span>
                    @endif
                </div>
                <p class="review-card-comment">{{ $review->comment }}</p>

                @if(!empty($review->photo_paths) && is_array($review->photo_paths) && count($review->photo_paths) > 0)
                    <div class="review-card-photos">
                        @foreach($review->photo_paths as $photoPath)
                            <a href="{{ asset('storage/' . $photoPath) }}" target="_blank" rel="noopener">
                                <img src="{{ asset('storage/' . $photoPath) }}" alt="Review photo">
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            @empty
            <div class="reviews-empty">
                <i class="bi bi-chat-square-text"></i>
                <h3>No reviews yet</h3>
                <p>Be the first to share your thoughts on this product.</p>
            </div>
            @endforelse

            <!-- Write a Review -->
            <div class="write-review-section reveal">
                <div class="section-label">
                    <span class="eyebrow">Write a Review</span>
                    <h2 class="display-md">Rate this product</h2>
                </div>

                @auth
                    @php
                        $canReview = true;
                        $alreadyReviewed = $product->reviews->where('user_id', auth()->id())->count() > 0;
                        if ($alreadyReviewed) $canReview = false;
                    @endphp

                    @if(!$canReview)
                        <div class="write-review-alert">
                            <i class="bi bi-check-circle"></i> You have already submitted a review for this product.
                        </div>
                    @else
                        <form method="POST" action="{{ route('product.reviews.store', $product) }}" enctype="multipart/form-data" class="review-form">
                            @csrf

                            <!-- Star Picker -->
                            <div class="review-form-group">
                                <label class="review-form-label">Your Rating</label>
                                <div class="star-picker-wrapper">
                                    <div class="star-picker" id="starPicker">
                                        @for($r = 1; $r <= 5; $r++)
                                            <input type="radio" name="rating" value="{{ $r }}" id="star-{{ $r }}"
                                                {{ old('rating') !== null && (int) old('rating') === $r ? 'checked' : '' }} required>
                                            <label for="star-{{ $r }}" data-star="{{ $r }}">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <span class="star-picker-hint" id="starHint">Click a star to rate</span>
                                </div>
                                @error('rating')
                                    <div class="review-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div class="review-form-group">
                                <label class="review-form-label" for="title">Review Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" maxlength="150" required
                                    placeholder="Summarize your experience" class="review-form-input">
                                @error('title')
                                    <div class="review-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div class="review-form-group">
                                <label class="review-form-label" for="comment">Your Review</label>
                                <textarea name="comment" id="comment" rows="5" maxlength="2000" required
                                    placeholder="Tell others what you think about this product..." class="review-form-textarea">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="review-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photos -->
                            <div class="review-form-group">
                                <label class="review-form-label" for="photos">Add Photos (optional)</label>
                                <div class="review-form-upload">
                                    <i class="bi bi-camera"></i>
                                    <span>Click to upload images</span>
                                    <input type="file" id="photos" name="photos[]" accept="image/*" multiple>
                                </div>
                                <div class="review-form-hint">Max 5 photos, up to 5MB each.</div>
                                @error('photos')
                                    <div class="review-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('review')
                                <div class="review-form-error">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-primary">
                                <span>Submit Review</span>
                            </button>
                        </form>
                    @endif
                @else
                    <div class="write-review-login">
                        <i class="bi bi-person"></i>
                        <span>Please <a href="{{ route('login') }}">log in</a> to submit a review.</span>
                    </div>
                @endauth
            </div>
        </section>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <section class="related-section">
            <div class="section-label reveal">
                <span class="eyebrow">You May Also Like</span>
                <h2 class="display-md">Related products</h2>
            </div>
            <div class="collection-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @include('partials.product-tile', ['product' => $relatedProduct])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    /* Add to cart */
    const addToCartBtn = document.getElementById('addToCartBtn');
    addToCartBtn?.addEventListener('click', function() {
        const size = document.querySelector('.size-option.active')?.textContent?.trim() || 'M';
        addToCart(this.dataset.productId, 1, size, this);
    });

    /* Carousel */
    const carouselRoot = document.getElementById('productCarousel');
    if (!carouselRoot) return;

    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    if (!track) return;

    const slides = Array.from(track.children);
    const thumbButtons = Array.from(document.querySelectorAll('.gallery-thumb'));
    const total = slides.length || thumbButtons.length || Number(carouselRoot.dataset.total || 0);
    let index = 0;

    /* Image zoom - smooth, only on the image area */
    const zoomItems = document.querySelectorAll('.gallery-zoom');
    zoomItems.forEach((wrap) => {
        const img = wrap.querySelector('.gallery-zoom-img');
        if (!img) return;

        const onMove = (e) => {
            const rect = wrap.getBoundingClientRect();
            const x = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
            const y = Math.min(1, Math.max(0, (e.clientY - rect.top) / rect.height));
            img.style.transformOrigin = `${(x * 100).toFixed(2)}% ${(y * 100).toFixed(2)}%`;
            img.style.transform = 'scale(2)';
        };

        const onLeave = () => {
            img.style.transformOrigin = '50% 50%';
            img.style.transform = 'scale(1)';
        };

        wrap.addEventListener('mousemove', onMove);
        wrap.addEventListener('mouseleave', onLeave);
    });

    /* Slider wiring */
    if (total <= 1) {
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
        return;
    }

    const setActiveThumb = () => {
        for (let i = 0; i < total; i++) {
            const thumbImg = document.getElementById('thumb-' + i);
            if (!thumbImg) continue;
            thumbImg.classList.toggle('active', i === index);
        }
    };

    const goTo = (i) => {
        if (i < 0) i = total - 1;
        if (i >= total) i = 0;
        index = i;
        track.style.transform = `translateX(-${index * 100}%)`;
        setActiveThumb();
    };

    prevBtn?.addEventListener('click', () => goTo(index - 1));
    nextBtn?.addEventListener('click', () => goTo(index + 1));

    thumbButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const idx = Number(btn.getAttribute('data-index'));
            if (!Number.isNaN(idx)) goTo(idx);
        });
    });

    setActiveThumb();

    /* Star picker hover effect */
    const starPicker = document.getElementById('starPicker');
    if (starPicker) {
        const radios = starPicker.querySelectorAll('input[name="rating"]');
        const labels = starPicker.querySelectorAll('label[data-star]');
        const hint = document.getElementById('starHint');
        const hints = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        let current = 0;

        const paint = (val) => {
            current = val;
            labels.forEach((lab) => {
                const star = Number(lab.dataset.star);
                lab.classList.toggle('active', star <= val);
            });
            if (hint && val > 0) hint.textContent = hints[val];
        };

        const checked = starPicker.querySelector('input[name="rating"]:checked');
        if (checked) paint(Number(checked.value));

        labels.forEach((lab) => {
            const star = Number(lab.dataset.star);
            lab.addEventListener('mouseenter', () => {
                labels.forEach(l => l.classList.remove('hover'));
                labels.forEach(l => {
                    if (Number(l.dataset.star) <= star) l.classList.add('hover');
                });
                if (hint) hint.textContent = hints[star];
            });
            lab.addEventListener('mouseleave', () => {
                labels.forEach(l => l.classList.remove('hover'));
                paint(current);
            });
            lab.addEventListener('click', () => {
                paint(star);
                if (hint) hint.textContent = hints[star];
            });
        });

        radios.forEach((r) => {
            r.addEventListener('change', (e) => paint(Number(e.target.value)));
        });
    }
});
</script>
@endsection