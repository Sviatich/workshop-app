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
            'construction' => 'required|string|in:fefco_0427,fefco_0426,fefco_0201,fefco_0300',
            'length' => 'required|integer|min:10',
            'width' => 'required|integer|min:10',
            'height' => 'nullable|integer|min:0',
            'color' => 'required|string|exists:carton_colors,code',
            'tirage' => 'required|integer|min:1',
        ];
    }
}
