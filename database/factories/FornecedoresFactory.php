<?php

namespace Database\Factories;

use App\Models\Fornecedores;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fornecedores>
 */
class FornecedoresFactory extends Factory
{
    protected $model = Fornecedores::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->company,
            'descricao' => $this->faker->sentence,
            'contato_principal' => $this->faker->name,
            'endereco' => $this->faker->address,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
