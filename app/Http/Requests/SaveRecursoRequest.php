<?php

namespace App\Http\Requests;

use App\Models\Recurso;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Request para recurso store & update
 */
class SaveRecursoRequest extends FormRequest
{

    /**
     * Updating Recurso instance, null on store
     */
    protected ?Recurso $recurso = null;

    /**
     * En este metodo seteamos los atributos
     */
    public function setRouteResolver(\Closure $callback)
    {
        parent::setRouteResolver(...func_get_args());
        $this->recurso = $this->route('recurso');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @throws HttpException asi respondemos algunos mensajes de error
     */
    public function authorize()
    {
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
                Rule::unique('App\Models\Recurso', 'nombre')
                    ->ignore($this->recurso->id ?? null),
            ],
        ];
    }
}
