<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Collection;

class WishlistService
{
    /**
     * Get the current user's full wishlist (with eager-loaded product info).
     * Returns an empty collection for guests.
     */
    public function items(): Collection
    {
        if (! auth()->check()) {
            return collect();
        }

        return Wishlist::with(['product.category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(function (Wishlist $row) {
                $product = $row->product;

                // Auto-clean if the product was removed or deactivated
                if (! $product || ! $product->is_active) {
                    $row->delete();
                    return null;
                }

                $row->setAttribute('image_url', $product->image
                    ? asset('storage/' . $product->image)
                    : null);

                return $row;
            })
            ->filter()
            ->values();
    }

    /**
     * Total number of wishlist items for the current user.
     */
    public function count(): int
    {
        if (! auth()->check()) {
            return 0;
        }

        return Wishlist::where('user_id', auth()->id())->count();
    }

    /**
     * Set of product IDs the current user has wishlisted.
     * Useful for hydrating the heart-fill state on product cards in bulk.
     */
    public function productIds(): array
    {
        if (! auth()->check()) {
            return [];
        }

        return Wishlist::where('user_id', auth()->id())
            ->pluck('product_id')
            ->all();
    }

    /**
     * Check whether the current user has wishlisted a given product.
     */
    public function has(int $productId): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Toggle a product on the current user's wishlist.
     * Returns [bool $added, int $count].
     */
    public function toggle(int $productId): array
    {
        // Make sure the product exists and is active
        Product::where('id', $productId)->where('is_active', true)->firstOrFail();

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
            $added = true;
        }

        return [
            'added' => $added,
            'count' => $this->count(),
        ];
    }

    /**
     * Remove a product from the current user's wishlist.
     */
    public function remove(int $productId): int
    {
        Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->delete();

        return $this->count();
    }

    /**
     * Empty the current user's wishlist.
     */
    public function clear(): void
    {
        if (! auth()->check()) {
            return;
        }

        Wishlist::where('user_id', auth()->id())->delete();
    }
}
