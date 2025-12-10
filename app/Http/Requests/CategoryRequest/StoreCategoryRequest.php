<?php

namespace App\Http\Requests\CategoryRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            // 1. Name: Must be present, a string, and within the length limit.
            //    If using composite key uniqueness, remove the unique rule here.
            'name'        => 'required|string|max:255',

            // 2. Slug: The client does NOT send this, as the Model generates it. 
            //    Therefore, we omit the slug rule entirely.

            // 3. Parent ID: Must be nullable (for top-level categories).
            //    If provided, it MUST exist in the 'id' column of the 'categories' table.
            'parent_id'   => 'nullable|integer|exists:categories,id',

            // 4. Description: Optional field.
            'description' => 'nullable|string',
        ];
    }

    /**
     * Optional: Add custom messages for rules (e.g., better error message for exists).
     */
    public function messages(): array
    {
        return [
            'parent_id.exists' => 'The selected parent category does not exist.'
        ];
    }
}
