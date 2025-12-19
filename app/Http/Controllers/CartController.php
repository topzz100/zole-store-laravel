<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\CartStoreRequest;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()
            ->cart()
            ->with('items.variant')
            ->firstOrCreate([]);

        return new CartResource($cart);
    }

    public function store(CartStoreRequest $request)
    {
        $cart = $request->user()->cart()->firstOrCreate([]);

        $cart->items()->updateOrCreate(
            ['product_variant_id' => $request->product_variant_id],
            ['quantity' => DB::raw('quantity + ' . $request->quantity)]
        );

        return new CartResource($cart->fresh('items.variant'));
    }
}
