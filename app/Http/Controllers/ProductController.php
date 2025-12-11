<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest\StoreProductRequest;
use App\Http\Requests\ProductRequest\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {

        $validatedData = $request->validated();

        // 2. Data Storage: Using the Product Model's create() method
        try {
            // The create() method uses the $fillable array for mass assignment
            $product = Product::create($validatedData);

            // 3. Response: Return a success message and the created product
            return response()->json([
                'message' => 'Product created successfully!',
                'data' => new ProductResource($product),
            ], 201); // 201 Created status code

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Product creation failed: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'message' => 'Failed to create product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        return (new ProductResource($product))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $validatedData = $request->validated();

        // 2. Data Update: Use the Product Model's update() method
        try {
            // update() only uses the fields present in the $validatedData array
            $product->update($validatedData);

            // 3. Response: Return a success message and the updated product
            return response()->json([
                'message' => 'Product updated successfully!',
                'data' => new ProductResource($product), // Return the refreshed product data
            ]); // Default status code is 200 OK

        } catch (\Exception $e) {
            Log::error('Product update failed for ID ' . $product->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Product $product)
    // {
    //     //
    // }
    public function destroy(Product $product)
    {
        try {
            // 1. Delete the record
            $product->delete();

            // 2. Return success status
            // 204 No Content is the standard HTTP status for a successful deletion
            return response()->json([
                'message' => 'Product deleted successfully.',

            ], 200);
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());

            // Return a generic 500 error response if the deletion fails unexpectedly
            return response()->json([
                'message' => 'Failed to delete product due to an internal server error.'
            ], 500);
        }
    }
}
