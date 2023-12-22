<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\Departamento;
use App\Models\RelacaoDeptContr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RelacaoDeptContr >
 */
class RelacaoDeptContrFactory extends Factory
{
    protected $model = RelacaoDeptContr::class;

    public function definition()
    {
        return [
            'id_contrato' => function () {
                return Contrato::factory(1)->create()->first()->id;
            },
            'id_departamento' => function () {
                return Departamento::factory(1)->create()->first()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
