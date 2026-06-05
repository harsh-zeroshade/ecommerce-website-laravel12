<aside class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
        <h3>Shopping Cart ({{ $cartCount }})</h3>
        <button type="button" class="cart-close" aria-label="Close cart">&times;</button>
    </div>

    @if($cartItems->isEmpty())
        <div class="cart-body cart-body--empty">
            <div class="cart-empty-icon"><i class="bi bi-bag"></i></div>
            <p class="cart-empty-text">Your shopping cart<br>is empty</p>
            <p class="cart-empty-sub">Discover pieces crafted for modern style.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-sm">Shop Collection</a>

            @if($featuredProducts->count())
            <div class="cart-suggestions">
                <span class="eyebrow">You may also like</span>
                @foreach($featuredProducts->take(3) as $suggestion)
                <a href="{{ route('product.show', $suggestion) }}" class="cart-suggestion-item">
                    @if($suggestion->image)
                        <img src="{{ asset('storage/' . $suggestion->image) }}" alt="{{ $suggestion->name }}">
                    @else
                        <div class="cart-suggestion-placeholder"></div>
                    @endif
                    <div class="cart-suggestion-info">
                        <h5>{{ $suggestion->name }}</h5>
                        <span class="price">₹{{ number_format($suggestion->price, 2) }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span id="cartTotal">₹0.00</span>
            </div>
            <button type="button" class="btn btn-primary btn-lg" style="width:100%;" disabled>Checkout</button>
        </div>
    @else
        <div class="cart-body cart-body--filled" id="cartItemsList">
            @foreach($cartItems as $item)
            <div class="cart-item" data-product-id="{{ $item['product_id'] }}" data-size="{{ $item['size'] ?? '' }}">
                <a href="{{ route('product.show', $item['product_id']) }}" class="cart-item-image">
                    @if($item['image_url'])
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                    @else
                        <div class="cart-suggestion-placeholder"></div>
                    @endif
                </a>
                <div class="cart-item-details">
                    <a href="{{ route('product.show', $item['product_id']) }}">
                        <h5>{{ $item['name'] }}</h5>
                    </a>
                    @if($item['size'])
                        <span class="cart-item-size">Size: {{ $item['size'] }}</span>
                    @endif
                    <span class="cart-item-price">₹{{ number_format($item['price'], 2) }}</span>
                    <div class="cart-item-qty">
                        <button type="button" class="qty-btn qty-minus" aria-label="Decrease quantity">−</button>
                        <span class="qty-value">{{ $item['quantity'] }}</span>
                        <button type="button" class="qty-btn qty-plus" aria-label="Increase quantity">+</button>
                    </div>
                </div>
                <button type="button" class="cart-item-remove" aria-label="Remove item">&times;</button>
            </div>
            @endforeach
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span id="cartTotal">₹{{ number_format($cartSubtotal, 2) }}</span>
            </div>
            @auth
                <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg" style="width:100%;">Checkout</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg" style="width:100%;">Login to Checkout</a>
            @endauth
        </div>
    @endif
</aside>
