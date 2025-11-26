<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category');
        return [
            // 'sometimes' ensures we only validate the field if the client sends it.
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',

            // Note: The 'slug' rule is omitted because the Model Mutator handles its generation and uniqueness.

            // 2. Parent ID Validation (The most complex part)
            'parent_id'   => [
                'nullable', // Allows a category to be promoted to top-level
                'integer',

                // Rule 2a: Ensures the parent category ID exists in the database.
                Rule::exists('categories', 'id'),

                // Rule 2b (CRITICAL): Prevents a category from being set as its own parent.
                Rule::notIn([$categoryId]),

                // Optional Rule: You could add custom logic here to prevent 
                // circular dependency (A is parent of B, B is parent of A).
            ],
        ];
    }
}
