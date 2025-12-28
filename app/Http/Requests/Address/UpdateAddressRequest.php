<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by auth:sanctum middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'sometimes' means the rule only applies if the field is present in the request
            'full_name' => ['sometimes', 'required', 'string'],
            'phone' => ['sometimes', 'required', 'string'],
            'street' => ['sometimes', 'required', 'string'],
            'city' => ['sometimes', 'required', 'string'],
            'state' => ['sometimes', 'required', 'string'],
            'country' => ['sometimes', 'required', 'string'],
            'is_default' => ['sometimes', 'boolean'],
        ];
    }
}
