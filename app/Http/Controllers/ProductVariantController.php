<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest\StoreProductVariantRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductVariantResource;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductVariantController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResponse
    {
        //
        $variants = $product->variants;

        // 2. Return the collection using the resource for standardized formatting (HTTP 200 OK).
        return ProductVariantResource::collection($variants)->response();
    }


    public function store(StoreProductVariantRequest $request, Product $product): JsonResponse
    {
        $validatedData = $request->validated();

        // Automatically fill the foreign key using the parent model instance
        $validatedData['product_id'] = $product->id;

        try {
            // Create the variant and link it to the product
            $variant = $product->variants()->create($validatedData);

            return response()->json([
                'message' => 'Product variant created successfully.',
                'data' => new ProductVariantResource($variant)
            ], 201);
        } catch (\Exception $e) {
            Log::error('Variant creation failed: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $variant): JsonResponse
    {
        // We can optionally eager load the parent product if needed for context
        // $variant->load('product'); 

        // 1. Return the single resource instance (HTTP 200 OK).
        return (new ProductVariantResource($variant))->response();
    }
}
