<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_usuario', 'id_horario_recurso'
    ];

    /**
     * Get the usuario that owns the Reserva
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    /**
     * Get the horarioRecurso that owns the Reserva
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horarioRecurso(): BelongsTo
    {
        return $this->belongsTo(HorarioRecurso::class, 'id_horario_recurso', 'id');
    }
}
