<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'type' => 'nullable|string',
            'supplier' => 'nullable|string',
            'start_on' => 'nullable|date',
            'finish_on' => 'nullable|date|after_or_equal:inicio',
        ];
    }

    /**
     * Define mensagens personalizadas para as regras de validação.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'finish_on.after_or_equal' => 'A data de término deve ser igual ou após a data de início.',
        ];
    }
}
