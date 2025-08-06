<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payer_type' => 'required|in:individual,company',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'inn' => 'nullable|string|required_if:payer_type,company',
            'delivery_address' => 'required|string',
            'delivery_method_id' => 'required|exists:delivery_methods,id',
            'cart' => 'required|array|min:1',
            'cart.*.construction' => 'required|string',
            'cart.*.length' => 'required|integer|min:10',
            'cart.*.width' => 'required|integer|min:10',
            'cart.*.height' => 'nullable|integer|min:0',
            'cart.*.color' => 'required|string|exists:carton_colors,code',
            'cart.*.tirage' => 'required|integer|min:1',
            'cart.*.price_per_unit' => 'required|numeric',
            'cart.*.total_price' => 'required|numeric',
            'cart.*.weight' => 'required|numeric',
            'cart.*.volume' => 'required|numeric',
        ];
    }

}
