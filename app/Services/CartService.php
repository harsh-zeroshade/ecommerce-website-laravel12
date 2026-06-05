<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    protected string $sessionKey = 'cart';

    public function items(): Collection
    {
        $cart = session($this->sessionKey, []);

        return collect($cart)->map(function ($item) {
            $product = Product::find($item['product_id']);
            if (!$product || !$product->is_active) {
                return null;
            }

            return array_merge($item, [
                'product' => $product,
                'line_total' => $item['price'] * $item['quantity'],
                'image_url' => $product->image
                    ? asset('storage/' . $product->image)
                    : null,
            ]);
        })->filter();
    }

    public function add(int $productId, int $quantity = 1, ?string $size = null): void
    {
        $product = Product::where('id', $productId)->where('is_active', true)->firstOrFail();

        if ($product->stock <= 0) {
            abort(422, 'Product is out of stock.');
        }

        $cart = session($this->sessionKey, []);
        $key = $this->itemKey($productId, $size);

        $existingQty = $cart[$key]['quantity'] ?? 0;
        $newQty = $existingQty + $quantity;

        if ($newQty > $product->stock) {
            abort(422, 'Not enough stock available.');
        }

        $cart[$key] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'quantity' => $newQty,
            'size' => $size,
            'image' => $product->image,
            'max_stock' => $product->stock,
        ];

        session([$this->sessionKey => $cart]);
    }

    public function update(int $productId, int $quantity, ?string $size = null): void
    {
        $cart = session($this->sessionKey, []);
        $key = $this->itemKey($productId, $size);

        if (!isset($cart[$key])) {
            return;
        }

        $product = Product::findOrFail($productId);

        if ($quantity <= 0) {
            unset($cart[$key]);
        } else {
            if ($quantity > $product->stock) {
                abort(422, 'Not enough stock available.');
            }
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['max_stock'] = $product->stock;
        }

        session([$this->sessionKey => $cart]);
    }

    public function remove(int $productId, ?string $size = null): void
    {
        $cart = session($this->sessionKey, []);
        $key = $this->itemKey($productId, $size);
        unset($cart[$key]);
        session([$this->sessionKey => $cart]);
    }

    public function clear(): void
    {
        session()->forget($this->sessionKey);
    }

    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    public function subtotal(): float
    {
        return $this->items()->sum('line_total');
    }

    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }

    protected function itemKey(int $productId, ?string $size): string
    {
        return $productId . '_' . ($size ?? 'default');
    }
}
