<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * un mismo usuario no puede reservar mas de una vez un mismo recurso en un horario
 */
class AddUsuarioHorarioRecursoUniqueToReservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->unique(['id_usuario', 'id_horario_recurso'], 'reservas_usuario_horario_recurso_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropUnique('reservas_usuario_horario_recurso_unique');
        });
    }
}
