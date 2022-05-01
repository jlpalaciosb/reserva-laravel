<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the horario that owns the HorarioRecurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horario::class, 'id_horario', 'id');
    }

    /**
     * Get the recurso that owns the RecursoRecurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurso(): BelongsTo
    {
        return $this->belongsTo(Recurso::class, 'id_recurso', 'id');
    }

    /**
     * Get all of the reservas for the HorarioRecurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_horario_recurso', 'id');
    }
}
