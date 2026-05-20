<?php

namespace App\Http\Controllers;

use App\Actions\Cart\CartManager;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index(CartManager $cart): View
    {
        return view('cart.index', [
            'cart' => $cart->summary(),
        ]);
    }

    public function summary(CartManager $cart): JsonResponse
    {
        return response()->json([
            'cart' => $cart->summary(),
        ]);
    }

    public function store(StoreCartItemRequest $request, CartManager $cart): JsonResponse
    {
        return response()->json([
            'message' => __('client/cart.added'),
            'cart' => $cart->add(
                productId: (int) $request->integer('product_id'),
                variantId: $request->filled('variant_id') ? (int) $request->integer('variant_id') : null,
                quantity: (int) $request->integer('quantity', 1),
                comboItemIds: $request->array('combo_items'),
            ),
        ]);
    }

    public function update(UpdateCartItemRequest $request, CartManager $cart, string $key): JsonResponse
    {
        return response()->json([
            'cart' => $cart->update($key, (int) $request->integer('quantity')),
        ]);
    }

    public function destroy(CartManager $cart, string $key): JsonResponse
    {
        return response()->json([
            'cart' => $cart->remove($key),
        ]);
    }
}
