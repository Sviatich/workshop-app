<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'construction' => 'required|string|in:fefco_0427,fefco_0426,fefco_0201,fefco_0215',
            'length' => 'required|integer|min:10',
            'width' => 'required|integer|min:10',
            'height' => 'nullable|integer|min:0',
            'color' => 'required|string|exists:carton_colors,code',
            'tirage' => 'required|integer|min:1',
            'has_logo' => 'sometimes|boolean',
            'has_fullprint' => 'sometimes|boolean',
        ];
    }
    public function attributes(): array
    {
        return [
            'length' => 'длина',
            'width' => 'ширина',
            'height' => 'высота',
            'tirage' => 'тираж',
        ];
    }

    public function messages(): array
    {
        return [
            'length.min' => 'Длина должна быть не меньше :min мм',
            'length.integer' => 'Длина должна быть целым числом',

            'width.min' => 'Ширина должна быть не меньше :min мм',
            'width.integer' => 'Ширина должна быть целым числом',

            'height.min' => 'Высота должна быть не меньше :min мм',
            'height.integer' => 'Высота должна быть целым числом',

            'tirage.min' => 'Тираж должен быть не меньше :min шт',
            'tirage.integer' => 'Тираж должен быть целым числом',
        ];
    }
}
