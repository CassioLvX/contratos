<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Department;
use App\Models\ContractDepartment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractDepartmentFactory extends Factory
{
    protected $model = ContractDepartment::class;

    public function definition()
    {
        return [
            'contract_id' => function () {
                return Contract::factory(1)->create()->first()->id;
            },
            'department_id' => function () {
                return Department::factory(1)->create()->first()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
