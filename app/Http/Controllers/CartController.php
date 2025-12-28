<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->firstOrCreate([]);
        $cart->load('items.variant');

        return new CartResource($cart);
    }

    public function store(CartStoreRequest $request)
    {
        $cart = $request->user()->cart()->firstOrCreate([]);

        // Clear all existing items in the cart
        $cart->items()->delete();

        // Add all new items from the request
        foreach ($request->items as $item) {
            $cart->items()->create([
                'product_variant_id' => $item['product_variant_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return new CartResource($cart->fresh('items.variant'));
    }

    /**
     * Remove all items from the cart.
     */
    public function destroy(Request $request)
    {
        $cart = $request->user()->cart;

        if ($cart) {
            // Delete all cart items
            $cart->items()->delete();

            return response()->json([
                'message' => 'Cart cleared successfully',
            ]);
        }

        return response()->json([
            'message' => 'Cart is already empty',
        ]);
    }
}
