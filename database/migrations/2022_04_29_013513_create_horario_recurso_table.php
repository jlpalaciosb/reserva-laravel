<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioRecursoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_recurso', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('limite');
            $table->bigInteger('id_horario');
            $table->foreign('id_horario')->references('id')->on('horarios');
            $table->bigInteger('id_recurso');
            $table->foreign('id_recurso')->references('id')->on('recursos');
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
        Schema::dropIfExists('horario_recurso');
    }
}
