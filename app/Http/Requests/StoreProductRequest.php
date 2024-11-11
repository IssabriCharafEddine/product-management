<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku'),
            ],
            'status' => [
                'required',
                'string',
                'max:255',
                Rule::in(['draft', 'published', 'archived', 'out', 'deleted', 'sale']), // Add valid statuses
            ],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'currency' => [
                'required',
                'string',
                'max:20',
                Rule::in(['USD', 'EUR', 'GBP', 'SAR', 'MAD']), // Add your supported currencies
            ],
            'image' => [
                'nullable',
                'string',
                'max:255',
                'url',
            ],
            'variations' => ['sometimes', 'array'],
            'variations.*.options' => ['required_with:variations', 'array'],
            'variations.*.options.*' => ['required', 'string', 'max:255'],
            'variations.*.quantity' => [
                'required_with:variations',
                'integer',
                'min:0',
                'max:999999'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.max' => 'The product name cannot exceed 255 characters.',
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'This SKU is already in use.',
            'status.required' => 'The product status is required.',
            'status.in' => 'The status must be either draft, published, or archived.',
            'price.required' => 'The price is required.',
            'price.min' => 'The price must be greater than or equal to 0.',
            'price.decimal' => 'The price must have 2 decimal places.',
            'currency.required' => 'The currency is required.',
            'currency.in' => 'The selected currency is not supported.',
            'image.url' => 'The image must be a valid URL.',
            'variations.*.quantity.min' => 'The quantity must be greater than or equal to 0.',
            'variations.*.quantity.max' => 'The quantity cannot exceed 999999.',
            'variations.*.options.required' => 'Options are required for each variation.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('price')) {
            $this->merge([
                'price' => (float) str_replace(',', '', $this->price)
            ]);
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'product name',
            'sku' => 'SKU',
            'variations.*.options' => 'variation options',
            'variations.*.quantity' => 'variation quantity',
        ];
    }
}