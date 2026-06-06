<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function __construct(protected WishlistService $wishlist) {}

    /**
     * Show the full wishlist page.
     */
    public function index(): View
    {
        $items = $this->wishlist->items();

        return view('customer.wishlist', [
            'wishlistItems' => $items,
        ]);
    }

    /**
     * Toggle a product on/off the wishlist.
     * Used by the heart buttons in product tiles, product detail, and the wishlist page itself.
     */
    public function toggle(Request $request): JsonResponse|RedirectResponse
    {
        if (! auth()->check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'auth' => false,
                    'redirect' => route('login'),
                    'message' => 'Please log in to save items to your wishlist.',
                ], 401);
            }
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $result = $this->wishlist->toggle($validated['product_id']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'auth' => true,
                'added' => $result['added'],
                'count' => $result['count'],
                'message' => $result['added']
                    ? 'Added to your wishlist.'
                    : 'Removed from your wishlist.',
            ]);
        }

        return back()->with('success', $result['added']
            ? 'Added to your wishlist.'
            : 'Removed from your wishlist.');
    }

    /**
     * Remove a product from the wishlist (used on the wishlist page).
     */
    public function destroy(Request $request, int $productId): JsonResponse|RedirectResponse
    {
        if (! auth()->check()) {
            abort(401);
        }

        $count = $this->wishlist->remove($productId);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'count' => $count,
                'message' => 'Removed from your wishlist.',
            ]);
        }

        return back()->with('success', 'Removed from your wishlist.');
    }

    /**
     * Get the current count of wishlist items (for the topbar badge).
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'count' => $this->wishlist->count(),
        ]);
    }
}
