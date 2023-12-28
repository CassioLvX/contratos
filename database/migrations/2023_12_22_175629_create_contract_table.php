<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('description');
            $table->decimal('value', 10, 2);
            $table->date('start_on');
            $table->date('finish_on');
            $table->foreignId('supplier_id')->unsigned();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('supplier');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contract');
    }
}
