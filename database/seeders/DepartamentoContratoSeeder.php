<?php

namespace Database\Seeders;

use App\Models\RelacaoDeptContr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RelacaoDeptContr::factory(10)->create();
    }
}
