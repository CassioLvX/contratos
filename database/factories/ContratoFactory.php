<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\Fornecedores;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contrato>
 */
class ContratoFactory extends Factory
{
    protected $model = Contrato::class;

    public function definition()
    {
        return [
            'descricao' => $this->faker->sentence,
            'valor' => $this->faker->randomFloat(2, 100, 10000),
            'inicio' => $this->faker->date,
            'termino' => $this->faker->date,
            'fornecedor_id' => function () {
                return Fornecedores::factory(1)->create()->first()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
