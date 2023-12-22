<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('inicio');
            $table->date('termino');
            $table->foreignId('fornecedor_id')->unsigned();
            $table->timestamps();

            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contratos');
    }
}
