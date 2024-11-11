<?php
// app/Http/Requests/ProductRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'variations' => 'array',
            'variations.*.options' => 'required|array',
            'variations.*.quantity' => 'required|integer|min:0',
        ];

        if ($this->isMethod('POST')) {
            $rules['sku'] = 'required|string|unique:products,sku|max:255';
        }

        return $rules;
    }
}