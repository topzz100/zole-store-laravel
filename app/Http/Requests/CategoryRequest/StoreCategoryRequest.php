<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            // name is required
            'name' => 'required|string|max:255',

            // slug is required, must be unique in the categories table
            'slug' => 'required|string|unique:categories,slug|max:255',

            // parent_id is optional (top-level category), but if provided, must exist in the categories table
            'parent_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
        ];
    }
}
