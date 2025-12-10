<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product'); // Assumes your route is defined as '/products/{product}'

        return [
            // 'sometimes' means the rule only applies if the field is present in the request.
            'name'          => 'sometimes|required|string|max:255',
            // Ignore the current product's ID when checking for slug uniqueness
            'slug'          => 'nullable|string|unique:products,slug,' . $productId . '|max:255',
            'description'   => 'nullable|string',
            'category_id'   => 'sometimes|required|integer|exists:categories,id',
            'brand'         => 'nullable|string|max:100',
            'base_price'         => 'sometimes|required|numeric|min:0.01',
            'tags'          => 'nullable|array',
            'tags.*'        => 'string|max:50',
            'images'        => 'nullable|array|max:5',
            'images.*'      => 'url|max:500',
            'gender'        => 'nullable|string|in:male,female,unisex',
            'is_sold'       => 'boolean',
        ];
    }
}
