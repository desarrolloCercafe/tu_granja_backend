<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeMantenimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_mantenimiento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref');
            $table->string('nombre_producto');
            $table->longText('saldo_geminus');
            $table->longText('cantidad');
            $table->longText('conteo');
            $table->longText('diferencia');
            $table->string('mes');
            $table->string('year');
            $table->date('fecha');
            $table->string('fecha_vencimiento')->nullable();
            $table->longText('observaciones')->nullable();
            $table->longText('costo_unitario');
            $table->longText('costo_total');
            $table->longText('costo_diferencia');
            $table->unsignedBigInteger('id_calendario');
            $table->foreign('id_calendario')->references('id')->on('calendario');
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
        Schema::dropIfExists('informe_mantenimiento');
    }
}
