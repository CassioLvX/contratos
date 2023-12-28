<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDepartmentTable extends Migration
{
    public function up()
    {
        Schema::create('contract_department', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->unsigned();
            $table->foreignId('department_id')->unsigned();
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contract');
            $table->foreign('department_id')->references('id')->on('department');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contract_department');
    }
}
