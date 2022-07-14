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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws HttpException asi respondemos algunos mensajes de error
     */
    public function authorize()
    {
        $horario = $this->route('horario'); // null si post

        if ($horario != null) { // update
            // verificar que no se uso todavia (que es nuevo)
            $c = HorarioRecurso::where('id_horario', $horario->id)->count();
            if ($c > 0) {
                throw new HttpException(400, 'Solo se pueden editar los horarios nuevos');
            }
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
        $horario = $this->route('horario'); // null si post
        return [
            'nombre' => [
                'required',
                Rule::unique('App\Models\Horario', 'nombre')
                    ->ignore($horario->id ?? null),
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
