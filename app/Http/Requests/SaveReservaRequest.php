<?php

namespace App\Http\Requests;

use App\Models\HorarioRecurso;
use App\Models\Reserva;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Request para reserva store & update
 */
class SaveReservaRequest extends FormRequest
{

    /**
     * Updating Reserva instance, null on store
     */
    protected ?Reserva $reserva = null;

    /**
     * set $this->reserva
     */
    public function setRouteResolver(\Closure $callback)
    {
        parent::setRouteResolver(...func_get_args());
        $this->reserva = $this->route('reserva');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws HttpException asi respondemos algunos mensajes de error
     */
    public function authorize()
    {
        // add input id usuario logueado
        $this->merge(['id_usuario' => Auth::user()->id]);

        // verificar limite
        $horarioRecurso = HorarioRecurso::with('reservas')
            ->find($this->input('id_horario_recurso'));
        if (count($horarioRecurso->reservas) >= $horarioRecurso->limite) {
            throw new HttpException(400, 'Límite alcanzado.');
        }

        // verificar x si el usuario ya reservo el horario-recurso
        $count = Reserva::where('id_usuario', $this->input('id_usuario'))
            ->where('id_horario_recurso', $this->input('id_horario_recurso'))
            ->count();
        if ($count > 0) {
            throw new HttpException(400, 'Usted ya lo reservó.');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_horario_recurso' => [
                'required',
            ],
            'id_usuario' => [
                'required', // cargado en authorize()
            ],
        ];
    }
}
