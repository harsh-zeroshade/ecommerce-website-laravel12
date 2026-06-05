@extends('layouts.app')

@section('title', $product->name)

@section('content')

<section class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Gallery (Modern animated carousel) -->
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
                    <div class="product-gallery-placeholder" style="height:420px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-bag" style="font-size:2rem;"></i>
                    </div>
                @else
                    <div class="product-carousel" id="productCarousel" data-total="{{ count($carouselImages) }}">
                        <div class="product-carousel-viewport" style="position:relative;">
                            <button type="button" class="product-carousel-btn prev" aria-label="Previous image" id="carouselPrev"
                                    style="position:absolute; left:12px; top:50%; transform:translateY(-50%); z-index:5;
                                           width:40px; height:40px; border-radius:999px; border:1px solid rgba(0,0,0,0.08);
                                           background:rgba(255,255,255,0.9); cursor:pointer;">
                                ‹
                            </button>

                            <button type="button" class="product-carousel-btn next" aria-label="Next image" id="carouselNext"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); z-index:5;
                                           width:40px; height:40px; border-radius:999px; border:1px solid rgba(0,0,0,0.08);
                                           background:rgba(255,255,255,0.9); cursor:pointer;">
                                ›
                            </button>

                            <div class="product-carousel-viewport-inner"
                                 style="overflow:hidden; border-radius:16px; background:rgba(0,0,0,0.02);">
                                <div class="product-carousel-track"
                                     id="carouselTrack"
                                     style="display:flex; width:100%; transition: transform 420ms cubic-bezier(0.2, 0.8, 0.2, 1);">
                                    @foreach($carouselImages as $img)
                                        <div class="product-carousel-slide"
                                             style="min-width:100%; padding:0; display:flex; align-items:center; justify-content:center;
                                                    aspect-ratio: 4 / 3;">
                                            <div class="product-zoom" style="width:100%; height:100%; padding:18px; position:relative; overflow:hidden; border-radius:12px;">
                                                <img
                                                    class="product-zoom-img"
                                                    src="{{ asset('storage/' . $img) }}"
                                                    alt="{{ $product->name }}"
                                                    style="width:100%; height:100%; object-fit:contain; transform:scale(1); transition: transform 180ms ease;"
                                                >
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if(count($carouselImages) > 1)
                            <div class="product-carousel-thumbs" style="margin-top:1rem;">
                                <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                                    @foreach($carouselImages as $idx => $img)
                                        <button type="button"
                                                class="product-carousel-thumb"
                                                data-index="{{ $idx }}"
                                                aria-label="Go to image {{ $idx + 1 }}"
                                                style="border:none; background:transparent; padding:0; cursor:pointer;">
                                            <img
                                                src="{{ asset('storage/' . $img) }}"
                                                alt="{{ $product->name }} thumbnail {{ $idx + 1 }}"
                                                style="width:70px; height:55px; object-fit:cover; border-radius:10px;
                                                       border:2px solid transparent; opacity:0.75;"
                                                id="thumb-{{ $idx }}"
                                            >
                                        </button>
                                    @endforeach
                                </div>
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

                {{-- Rating slug / summary --}}
                @if($productAvgRating > 0)
                    <div class="product-rating" style="display:flex; align-items:center; gap:.75rem; margin:.75rem 0 1.25rem;">
                        <div class="product-rating-stars" style="display:flex; gap:.12rem; align-items:center;">
                            @for($i = 0; $i < 5; $i++)
                                <i class="{{ $i < floor($productAvgRating) ? 'bi bi-star-fill' : 'bi bi-star' }}" style="font-size:1rem;"></i>
                            @endfor
                        </div>
                        <div style="display:flex; flex-direction:column; line-height:1.05;">
                            <div style="font-weight:800;">{{ $productAvgRating }}/5</div>
                            <div class="text-muted" style="font-size:.9rem;">
                                {{ $productReviewsCount }} {{ Str::plural('review', $productReviewsCount) }}
                            </div>
                        </div>
                        <span class="product-tile-badge" style="margin-left:auto; background:rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.06);">
                            Rating
                        </span>
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
                    <p class="text-muted" style="margin-bottom:2rem; line-height:1.8;">{{ $product->short_description }}</p>
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
                        <button type="button" class="btn btn-outline btn-lg">
                            <i class="bi bi-heart"></i> Add to Wishlist
                        </button>
                    @else
                        <button type="button" class="btn btn-lg" style="background:var(--sand); color:var(--text-muted); width:100%;" disabled>
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

        <!-- Reviews -->
        @php
            $reviews = $product->reviews ?? collect();
            $reviewsCount = $reviews->count();
            $avgRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 1) : 0;
        @endphp

        <div class="reviews-section">
            <div class="section-label reveal">
                <span class="eyebrow">Reviews</span>
                <h2 class="display-md">Customer Reviews</h2>
            </div>

            <!-- Rating Summary -->
            <div class="review-summary reveal" style="display:flex; align-items:center; gap:1rem; margin: 0 0 2rem;">
                <div class="review-summary-stars" style="display:flex; gap:.15rem; align-items:center;">
                    @for($i = 0; $i < 5; $i++)
                        <i class="{{ $i < floor($avgRating) ? 'bi bi-star-fill' : 'bi bi-star' }}"></i>
                    @endfor
                </div>
                <div class="review-summary-text">
                    <div style="font-weight:700; line-height:1;">{{ $avgRating }}/5</div>
                    <div class="text-muted" style="line-height:1.3;">
                        {{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }}
                    </div>
                </div>
            </div>

            @forelse($reviews as $review)
            <div class="review-card reveal">
                <div class="review-card-header">
                    <div>
                        <h4>{{ $review->title }}</h4>
                        <span class="review-author">by {{ $review->user->name }}</span>
                        @if($review->is_verified_purchase)
                            <div style="margin-top:.25rem;" class="text-muted">
                                <span class="product-tile-badge" style="padding:.25rem .5rem;">Verified Purchase</span>
                            </div>
                        @endif
                    </div>
                    <div class="review-stars" style="display:flex; gap:.15rem; align-items:center;">
                        @for($i = 0; $i < $review->rating; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                        @for($i = $review->rating; $i < 5; $i++)
                            <i class="bi bi-star"></i>
                        @endfor
                        <span class="text-muted" style="margin-left:.5rem;">{{ $review->rating }}/5</span>
                    </div>
                </div>

                <p>{{ $review->comment }}</p>

                @if(!empty($review->photo_paths) && is_array($review->photo_paths) && count($review->photo_paths) > 0)
                    <div class="review-photos" style="display:flex; gap:.75rem; flex-wrap:wrap; margin: 1rem 0;">
                        @foreach($review->photo_paths as $photoPath)
                            <a href="{{ asset('storage/' . $photoPath) }}" target="_blank" rel="noopener">
                                <img
                                    src="{{ asset('storage/' . $photoPath) }}"
                                    alt="Review photo"
                                    style="width:100px; height:100px; object-fit:cover; border-radius:12px; border:1px solid rgba(0,0,0,.08);"
                                >
                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
            </div>
            @empty
            <p class="text-muted" style="text-align:center; padding:2rem 0;">No reviews yet. Be the first to review!</p>
            @endforelse

            <!-- Add Review -->
            <div class="add-review-section reveal" style="margin-top:3rem;">
                <div class="section-label">
                    <span class="eyebrow">Write a Review</span>
                    <h2 class="display-md">Rate this product</h2>
                </div>

                @auth
                    @php
                        $canReview = true;
                        $alreadyReviewed = $product->reviews->where('user_id', auth()->id())->count() > 0;

                        if ($alreadyReviewed) {
                            $canReview = false;
                        }
                    @endphp

                    @if(!$canReview)
                        <div class="alert" style="padding:1rem; border-radius:14px; background: rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.06);">
                            <strong>Already reviewed.</strong> You have submitted a review for this product.
                        </div>
                    @else
                        <form method="POST" action="{{ route('product.reviews.store', $product) }}" enctype="multipart/form-data" class="admin-form" style="max-width:760px;">
                            @csrf

                            {{-- Rating (stars UI) --}}
                            <div class="admin-field" style="margin-bottom:1.25rem;">
                                <label style="font-weight:700;">Your Rating</label>
                                <div style="display:flex; align-items:center; gap:1rem; margin-top:.75rem; padding:1rem; border:1px solid rgba(0,0,0,.06); border-radius:14px; background: rgba(0,0,0,.02);">
                                    <div class="review-star-picker" style="display:flex; gap:.25rem;">
                                        @for($r = 5; $r >= 1; $r--)
                                            <input
                                                type="radio"
                                                name="rating"
                                                value="{{ $r }}"
                                                id="star-{{ $r }}"
                                                style="position:absolute; opacity:0; pointer-events:none;"
                                                {{ old('rating') !== null && (int) old('rating') === $r ? 'checked' : '' }}
                                                required
                                            >
                                            <label
                                                for="star-{{ $r }}"
                                                data-star="{{ $r }}"
                                                style="cursor:pointer; font-size:1.5rem; line-height:1; color: rgba(0,0,0,.20);"
                                            >
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <div class="text-muted" style="font-size:.95rem;">
                                        Choose 1 to 5 stars
                                    </div>

                                    <script>
                                        (function () {
                                            const root = document.currentScript && document.currentScript.closest('form');
                                            if (!root) return;

                                            const radios = root.querySelectorAll('input[name="rating"]');
                                            const labels = root.querySelectorAll('.review-star-picker label[data-star]');

                                            const paint = (value) => {
                                                labels.forEach((lab) => {
                                                    const star = Number(lab.getAttribute('data-star'));
                                                    lab.style.color = star <= value ? 'var(--primary, #000)' : 'rgba(0,0,0,.20)';
                                                });
                                            };

                                            const checked = root.querySelector('input[name="rating"]:checked');
                                            if (checked) paint(Number(checked.value));

                                            labels.forEach((lab) => {
                                                const star = Number(lab.getAttribute('data-star'));

                                                lab.addEventListener('mouseenter', () => paint(star));
                                                lab.addEventListener('mouseleave', () => {
                                                    const nowChecked = root.querySelector('input[name="rating"]:checked');
                                                    paint(nowChecked ? Number(nowChecked.value) : 0);
                                                });
                                                lab.addEventListener('click', () => paint(star));
                                            });

                                            radios.forEach((r) => {
                                                r.addEventListener('change', (e) => paint(Number(e.target.value)));
                                            });
                                        })();
                                    </script>
                                </div>
                                @error('rating')
                                    <div class="error-text" style="margin-top:.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Title + Comment --}}
                            <div class="admin-field" style="margin-bottom:1rem;">
                                <label for="title" style="font-weight:700;">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" maxlength="150" required
                                       style="width:100%; padding:.75rem .85rem; border-radius:12px; border:1px solid rgba(0,0,0,.12);">
                                @error('title')
                                    <div class="error-text" style="margin-top:.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="admin-field" style="margin-bottom:1rem;">
                                <label for="comment" style="font-weight:700;">Comment</label>
                                <textarea name="comment" id="comment" rows="5" maxlength="2000" required
                                          style="width:100%; padding:.75rem .85rem; border-radius:12px; border:1px solid rgba(0,0,0,.12);">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="error-text" style="margin-top:.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Photos --}}
                            <div class="admin-field" style="margin-bottom:1.25rem;">
                                <label for="photos" style="font-weight:700;">Upload Photos (optional)</label>
                                <input type="file" id="photos" name="photos[]" accept="image/*" multiple
                                       style="width:100%;">
                                <div class="text-muted" style="margin-top:.5rem; font-size:.9rem;">
                                    Max 5 photos. Each up to 5MB.
                                </div>
                                @error('photos')
                                    <div class="error-text" style="margin-top:.5rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('review')
                                <div class="error-text" style="margin-bottom:1rem;">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-add-cart btn-lg" style="width:100%; max-width:260px;">
                                <span>Submit Review</span>
                            </button>
                        </form>
                    @endif
                @else
                    <div class="alert" style="padding:1rem; border-radius:14px; background: rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.06); text-align:center;">
                        Please <a href="{{ route('login') }}" style="text-decoration:underline; font-weight:700;">login</a> to submit a review.
                    </div>
                @endauth
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div style="padding: 4rem 0;">
            <div class="section-label reveal">
                <span class="eyebrow">You May Also Like</span>
                <h2 class="display-md">Related products</h2>
            </div>
            <div class="collection-grid">
                @foreach($relatedProducts as $relatedProduct)
                    @include('partials.product-tile', ['product' => $relatedProduct])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const addToCartBtn = document.getElementById('addToCartBtn');
    addToCartBtn?.addEventListener('click', function() {
        const size = document.querySelector('.size-option.active')?.textContent?.trim() || 'M';
        addToCart(this.dataset.productId, 1, size, this);
    });

    const carouselRoot = document.getElementById('productCarousel');
    if (!carouselRoot) return;

    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    if (!track) return;

    const slides = Array.from(track.children);
    const thumbButtons = Array.from(document.querySelectorAll('.product-carousel-thumb'));

    const total = slides.length || thumbButtons.length || Number(carouselRoot.dataset.total || 0);

    // Hover zoom (cursor-follow) on the main carousel images
    const zoomWrappers = document.querySelectorAll('.product-zoom');
    zoomWrappers.forEach((wrap) => {
        const img = wrap.querySelector('.product-zoom-img');
        if (!img) return;

        const maxScale = 2;

        const onEnter = () => {
            img.style.transition = 'transform 120ms ease';
            img.style.willChange = 'transform, transform-origin';
            img.style.transformOrigin = '50% 50%';
            img.style.transform = `scale(${maxScale})`;
        };

        const onMove = (e) => {
            const rect = wrap.getBoundingClientRect();
            const x = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
            const y = Math.min(1, Math.max(0, (e.clientY - rect.top) / rect.height));

            const originX = (x * 100).toFixed(2) + '%';
            const originY = (y * 100).toFixed(2) + '%';

            img.style.transformOrigin = `${originX} ${originY}`;
            img.style.transform = `scale(${maxScale})`;
        };

        const onLeave = () => {
            img.style.transition = 'transform 180ms ease';
            img.style.willChange = '';
            img.style.transformOrigin = '50% 50%';
            img.style.transform = 'scale(1)';
        };

        wrap.addEventListener('mouseenter', onEnter);
        wrap.addEventListener('mousemove', onMove);
        wrap.addEventListener('mouseleave', onLeave);
    });

    // Slider wiring
    if (total <= 1) {
        if (prevBtn) prevBtn.style.display = 'none';
        if (nextBtn) nextBtn.style.display = 'none';
        return;
    }

    let index = 0;

    const setActiveThumb = () => {
        for (let i = 0; i < total; i++) {
            const thumbImg = document.getElementById('thumb-' + i);
            if (!thumbImg) continue;

            const active = i === index;
            thumbImg.style.borderColor = active ? 'var(--primary, #000)' : 'transparent';
            thumbImg.style.opacity = active ? '1' : '0.75';
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
});
</script>
@endsection
