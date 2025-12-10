<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest\StoreCategoryRequest;
use App\Http\Requests\CategoryRequest\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();

        //return response()->json($categories);
        return CategoryResource::collection($categories)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // The request is guaranteed to be validated at this point (422 status if invalid).
        $validatedData = $request->validated();

        try {
            // Use Eloquent to create the new record
            $category = Category::create($validatedData);

            // Return 201 Created status and the new resource
            return response()->json([
                'message' => 'Category created successfully.',
                'data' => new CategoryResource($category)
            ], 201);
        } catch (\Exception $e) {

            if ($e->getCode() === 409) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => 'Conflict',
                ], 409); // <-- Return 409 Conflict
            }
            // Catch unexpected server/database errors (e.g., connection loss)
            Log::error('Category creation failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create category due to an internal error.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return (new CategoryResource($category))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // The $category variable is an instance of the Category model fetched by its ID.
        // The UpdateCategoryRequest ensures the slug is unique (ignoring the current ID) 
        // and that parent_id is not the category's own ID.

        $validatedData = $request->validated();

        try {
            // Use Eloquent's update() method
            $category->update($validatedData);

            // Return 200 OK status and the updated resource
            return response()->json([
                'message' => 'Category updated successfully.',
                'data' => new CategoryResource($category->fresh()) // Use fresh() to get the latest data
            ]);
        } catch (\Exception $e) {
            if ($e->getCode() === 409) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => 'Conflict',
                ], 409); // <-- Return 409 Conflict
            }
            Log::error('Category update failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update category due to an internal error.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // 1. Delete the record
            $category->delete();

            // 2. Return success status
            // 204 No Content is the standard HTTP status for a successful deletion
            return response()->json([
                'message' => 'Category deleted successfully.',

            ], 200);
        } catch (\Exception $e) {
            Log::error('Category deletion failed: ' . $e->getMessage());

            // Return a generic 500 error response if the deletion fails unexpectedly
            return response()->json([
                'message' => 'Failed to delete category due to an internal server error.'
            ], 500);
        }
    }
}
