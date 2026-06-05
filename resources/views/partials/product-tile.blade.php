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
                <button type="button" class="btn-select" onclick="event.preventDefault(); window.location='{{ route('product.show', $product) }}'">Select</button>
            @endif

            @if($product->stock <= 0)
                <span class="product-tile-badge" style="background: #c0392b;">Sold Out</span>
            @endif
        </div>
        <div class="product-tile-info">
            <h3>{{ $product->name }}</h3>
            <div class="price">
                ₹{{ number_format($product->price, 2) }}
                @if($product->discount_percentage > 0)
                    <span class="price-original">₹{{ number_format($product->price / (1 - $product->discount_percentage / 100), 2) }}</span>
                @endif
            </div>
        </div>
    </a>
</div>
