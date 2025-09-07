<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'  => ['required', 'string', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:255'],
            'message'    => ['required', 'string', 'max:5000'],
            'topic'      => ['nullable', 'string', 'max:255'],
            'subject'    => ['nullable', 'string', 'max:255'], // alias if frontend prefers different name
            'page'       => ['nullable', 'string', 'max:1024'],
            'attachment' => ['nullable', 'file', 'max:10240', 'mimetypes:image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/zip'],
            // Honeypot fields (if present)
            'hp_name'    => ['nullable', 'string', 'max:0'],
            'hp_time'    => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Укажите ФИО.',
            'email.required'     => 'Укажите email.',
            'email.email'        => 'Укажите корректный email.',
            'message.required'   => 'Введите сообщение.',
            'attachment.max'     => 'Максимальный размер файла 10 МБ.',
            'attachment.mimetypes' => 'Недопустимый тип файла.',
        ];
    }
}

