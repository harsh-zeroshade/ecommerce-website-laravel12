<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'size' => ['nullable', 'string', 'max:10'],
        ]);

        try {
            $this->cart->add(
                $validated['product_id'],
                $validated['quantity'] ?? 1,
                $validated['size'] ?? null
            );
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Added to cart',
            'count' => $this->cart->count(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function update(Request $request, int $productId): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
            'size' => ['nullable', 'string', 'max:10'],
        ]);

        try {
            $this->cart->update($productId, $validated['quantity'], $validated['size'] ?? null);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'message' => 'Cart updated',
            'count' => $this->cart->count(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function remove(Request $request, int $productId): JsonResponse
    {
        $this->cart->remove($productId, $request->input('size'));

        return response()->json([
            'message' => 'Item removed',
            'count' => $this->cart->count(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }
}
