<?php

namespace App\Http\Requests;

use App\Models\Horario;
use App\Models\HorarioRecurso;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Request para horario store & update
 */
class SaveHorarioRequest extends FormRequest
{

    /**
     * Updating Horario instance, null on store
     */
    private ?Horario $horario = null;

    /**
     * set $this->horario
     */
    public function setRouteResolver(\Closure $callback)
    {
        parent::setRouteResolver(...func_get_args());
        $this->horario = $this->route('horario');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws HttpException asi respondemos algunos mensajes de error
     */
    public function authorize()
    {
        if (isset($this->horario)) {
            // verificar que el horario no se uso todavia
            $c = HorarioRecurso::where('id_horario', $this->horario->id)->count();
            if ($c > 0) {
                throw new HttpException(400, 'Solo se pueden editar los horarios nuevos');
            }
        }
        return $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => [
                'required',
                Rule::unique('App\Models\Horario', 'nombre')
                    ->ignore($this->horario->id ?? null),
            ],
            'hora_ini' => [
                'required',
                'before:hora_fin',
            ],
            'hora_fin' => [
                'required',
            ],
        ];
    }
}
