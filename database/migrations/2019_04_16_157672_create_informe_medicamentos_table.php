<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_medicamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref');
            $table->string('nombre_producto');
            $table->bigInteger('saldo_geminus');
            $table->bigInteger('cantidad');
            $table->bigInteger('conteo');
            $table->string('diferencia');
            $table->string('mes');
            $table->string('year');
            $table->date('fecha');
            $table->integer('costo_unitario');
            $table->integer('costo_total');
            $table->integer('costo_diferencia');
            $table->unsignedBigInteger('id_calendario');
            $table->foreign('id_calendario')->references('id')->on('calendario');
            $table->string('fecha_vencimiento')->nullable();
            $table->longText('observaciones')->nullable();
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
        Schema::dropIfExists('informe_medicamentos');
    }
}
