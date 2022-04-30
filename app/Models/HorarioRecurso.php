<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioRecurso extends Model
{
    use HasFactory;

    protected $table = 'horario_recurso';

    protected $fillable = [
        'fecha', 'limite', 'id_horario', 'id_recurso'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
}
