<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelacaoDeptContrTable extends Migration
{
    public function up()
    {
        Schema::create('relacao_dept_contr', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_contrato')->unsigned();
            $table->foreignId('id_departamento')->unsigned();
            $table->timestamps();

            $table->foreign('id_contrato')->references('id')->on('contratos');
            $table->foreign('id_departamento')->references('id')->on('departamentos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('relacao_dept_contr');
    }
}
