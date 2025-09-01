<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function expectsJson()
    {
        // Возвращаем JSON на ошибки валидации для API-запросов
        return true;
    }

    public function validationData()
    {
        $data = $this->all();
        if ($this->has('cart')) {
            $decoded = json_decode($this->input('cart'), true);
            if (is_array($decoded)) {
                $data['cart'] = $decoded;
            }
        }
        return $data;
    }

    public function rules(): array
    {
        return [
            'payer_type' => ['required', Rule::in(['individual', 'company'])],
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'inn' => 'nullable|string|required_if:payer_type,company',
            'delivery_method_code' => 'required|string|in:pickup,pek,cdek',
            'delivery_address' => 'nullable|string|required_unless:delivery_method_code,pickup',
            'delivery_method_id' => 'required|exists:delivery_methods,id',
            'delivery_price' => 'nullable|numeric|min:0',
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
            // Опционально: логотип
            'cart.*.logo.enabled' => 'nullable|boolean',
            'cart.*.logo.size' => 'nullable|string',
            'cart.*.logo.file_path' => 'nullable|string',
            'cart.*.logo.filename' => 'nullable|string',
            // Опционально: полноформатная печать
            'cart.*.fullprint.enabled' => 'nullable|boolean',
            'cart.*.fullprint.description' => 'nullable|string',
            'cart.*.fullprint.file_path' => 'nullable|string',
            'cart.*.fullprint.filename' => 'nullable|string',
            // Файлы (по индексам)
            // Обрабатываются динамически в контроллере, здесь не валидируются
        ];
    }
}
