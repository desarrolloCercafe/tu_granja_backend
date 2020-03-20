<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenciasMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referencias_medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_medicamento')->nullable();
            $table->string('nombre_medicamento')->nullable();
            $table->string('tipo_medicamento')->nullable();
            $table->boolean('disable')->nullable();
            $table->string('proveedor_1')->nullable();
            $table->string('proveedor_2')->nullable();
            $table->string('proveedor_3')->nullable();
            $table->string('proveedor_4')->nullable();
            $table->string('precio_medicamento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referencias_medicamentos');
    }
}
