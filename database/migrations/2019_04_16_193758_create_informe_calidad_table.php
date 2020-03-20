<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeCalidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_calidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref');
            $table->string('nombre_producto');
            $table->integer('saldo_geminus');
            $table->integer('cantidad');
            $table->integer('conteo');
            $table->string('diferencia');
            $table->string('mes');
            $table->string('year');
            $table->date('fecha');
            $table->integer('costo_unitario');
            $table->integer('costo_total');
            $table->integer('costo_diferencia');
            $table->unsignedBigInteger('id_calendario');
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
        Schema::dropIfExists('informe_calidad');
    }
}
