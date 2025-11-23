<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
        //
        // $validatedData = $request->validate([
        //     'name'        => 'required|string|max:255',
        //     'slug'        => 'nullable|string|unique:products,slug|max:255',
        //     'description' => 'nullable|string',
        //     'category_id' => 'required|integer|exists:categories,id',
        //     'brand'       => 'nullable|string|max:100',
        //     'price'       => 'required|numeric|min:0.01',
        //     'tags'        => 'nullable|array',
        //     'images'      => 'nullable|array',
        //     'gender'      => 'nullable|string|in:male,female,unisex',
        //     'is_sold'     => 'boolean',
        // ]);
        $validatedData = $request->validated();

        // 2. Data Storage: Using the Product Model's create() method
        try {
            // The create() method uses the $fillable array for mass assignment
            $product = Product::create($validatedData);

            // 3. Response: Return a success message and the created product
            return response()->json([
                'message' => 'Product created successfully!',
                'product' => $product,
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
