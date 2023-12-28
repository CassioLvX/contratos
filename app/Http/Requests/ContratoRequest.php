<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoRequest extends FormRequest
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
            'description' => 'required|string',
            'type' => 'required|string',
            'value' => 'required|numeric',
            'start_on' => 'required|date',
            'finish_on' => 'required|date',
            'supplier_id' => 'required|exists:supplier,id',
            'departments' => 'required|array',
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
            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O campo descrição deve ser uma string.',
            'type.required' => 'O campo tipo de contrato é obrigatório.',
            'type.string' => 'O campo tipo de contrato deve ser uma string.',
            'value.required' => 'O campo valor é obrigatório.',
            'value.numeric' => 'O campo valor deve ser um número.',
            'start_on.required' => 'O campo início é obrigatório.',
            'start_on.date' => 'O campo início deve ser uma data válida.',
            'finish_on.required' => 'O campo término é obrigatório.',
            'finish_on.date' => 'O campo término deve ser uma data válida.',
            'supplier_id.required' => 'O campo fornecedor é obrigatório.',
            'supplier_id.exists' => 'O fornecedor selecionado é inválido.',
            'departments.required' => 'O campo departamentos é obrigatório.',
            'departments.array' => 'O campo departamentos deve ser um array.',

        ];
    }
}
