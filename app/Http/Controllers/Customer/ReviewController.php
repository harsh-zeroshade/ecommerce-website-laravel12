<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['required', 'string', 'max:150'],
            'comment' => ['required', 'string', 'max:2000'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $existing = Review::where('product_id', $product->id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($existing) {
            return back()->withErrors([
                'review' => 'You have already submitted a review for this product.',
            ])->withInput();
        }

        $isVerifiedPurchase = $this->isVerifiedPurchase($request->user()->id, $product->id);

        // Per your requirement: only verified purchase
        if (! $isVerifiedPurchase) {
            return back()->withErrors([
                'review' => 'Only verified purchases can submit a review for this product.',
            ])->withInput();
        }

        $storedPhotos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $storedPhotos[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => true,
            'photo_paths' => $storedPhotos ?: [],
        ]);

        return redirect()
            ->route('product.show', $product->id)
            ->with('success', 'Thanks! Your review has been submitted.');
    }

    protected function isVerifiedPurchase(int $userId, int $productId): bool
    {
        // Verified purchase means:
        // - orders.payment_status = completed
        // - orders.order_status = delivered
        // - user has an order containing this product
        return DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->where('order_items.product_id', $productId)
            ->where('orders.payment_status', 'completed')
            ->where('orders.order_status', 'delivered')
            ->exists();
    }
}
