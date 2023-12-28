<?php

namespace Database\Seeders;

use App\Models\ContractDepartment;
use Illuminate\Database\Seeder;

class ContractDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContractDepartment::factory(10)->create();
    }
}
