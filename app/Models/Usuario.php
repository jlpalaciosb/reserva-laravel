<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nombre', 'apellido', 'email', 'password', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get all of the reservas for the Usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id');
    }

    /**
     * Genera username a partir de nombre completo
     * Ejemplo: in: José Palacios, out: josé_palacios
     * @param string $nombre_completo
     */
    public static function genUsername($nombre_completo) {
        $nombre_completo = mb_strtolower($nombre_completo);
        $aux = preg_split("/\s+/", $nombre_completo);
        $nombre = $aux[0];
        $apellido = $aux[1] ?? '';
        $username = $nombre . '_' . $apellido;

        // $username debe ser unique en tabla usuarios
        $aux = 2;
        while (Usuario::where('username', $username)->count() != 0) {
            $username = $nombre . '_' . $apellido . '_' . $aux++;
        }

        return $username;
    }

    /**
     * Genera nombre a partir de nombre completo
     * Ejemplo: in: José Palacios, out: José
     * @param string $nombre_completo
     */
    public static function genNombre($nombre_completo) {
        $aux = preg_split("/\s+/", $nombre_completo);
        $nombre = $aux[0];
        return $nombre;
    }

    /**
     * Genera apellido a partir de nombre completo
     * Ejemplo: in: José Palacios, out: Palacios
     * @param string $nombre_completo
     */
    public static function genApellido($nombre_completo) {
        $aux = preg_split("/\s+/", $nombre_completo);
        $apellido = $aux[1] ?? '';
        return $apellido;
    }
}
