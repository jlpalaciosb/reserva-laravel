<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * en una fecha no se puede programar un mismo recurso en un horario mas de una vez
 */
class AddHorarioRecursoUniqueToHorarioRecurso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('horario_recurso', function (Blueprint $table) {
            $table->unique(['fecha', 'id_horario', 'id_recurso'], 'fecha_horario_recurso_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horario_recurso', function (Blueprint $table) {
            $table->dropUnique('fecha_horario_recurso_unique');
        });
    }
}
