<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|unique:products,slug|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'brand'       => 'nullable|string|max:100',
            'price'       => 'required|numeric|min:0.01',
            'tags'        => 'nullable|array',
            'images'      => 'nullable|array',
            'gender'      => 'nullable|string|in:male,female,unisex',
            'is_sold'     => 'boolean',
        ];
    }
}
