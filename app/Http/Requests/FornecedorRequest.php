<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
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
            'name' => 'required|string|max:40',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:90',
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
            'name.required' => 'O campo Nome é obrigatório.',
            'description.required' => 'O campo Descrição é obrigatório.',
            'address.required' => 'O campo Endereço é obrigatório.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
        ];
    }
}
