<?php

namespace App\Http\Requests\ProductVariantRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku'              => 'required|string|unique:product_variants,sku|max:50',
            'color'            => 'nullable|string|max:50',
            'size'             => 'nullable|string|max:50',
            'price'            => 'required|numeric|min:0', // Can override base price
            'stock_quantity'   => 'required|integer|min:0',
            'image_path'       => 'nullable|url',

            // Ensures that the color/size combination is unique for this specific product
            // This requires a custom rule if you want the logic inside validation.
            // Database unique constraint on (product_id, color, size) is safer.
        ];
    }
}
