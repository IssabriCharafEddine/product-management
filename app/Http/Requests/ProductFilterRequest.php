<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string'],
            'price_min' => ['sometimes', 'numeric', 'min:0'],
            'price_max' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'string', Rule::in(['draft', 'published', 'archived'])],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'sort_by' => ['sometimes', 'string', Rule::in(['name', 'price', 'created_at', 'sku'])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])]
        ];
    }
}