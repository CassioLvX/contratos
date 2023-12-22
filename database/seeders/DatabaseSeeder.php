<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contrato;
use App\Models\Departamento;
use App\Models\Fornecedores;
use App\Models\RelacaoDeptContr;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Fornecedores::factory(10)->create();
        Contrato::factory(10)->create();
        Departamento::factory(10)->create();
        RelacaoDeptContr::factory(10)->create();
    }
}
