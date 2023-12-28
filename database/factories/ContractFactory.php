<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'type' => $this->faker->word,
            'value' => $this->faker->randomFloat(2, 100, 10000),
            'start_on' => $this->faker->date,
            'finish_on' => $this->faker->date,
            'supplier_id' => function () {
                return Supplier::factory(1)->create()->first()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
