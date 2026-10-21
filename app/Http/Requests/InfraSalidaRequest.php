<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfraSalidaRequest extends FormRequest
{
    public function authorize()
    {
        // El módulo requiere autenticación general; la autorización por roles
        // se definirá en una implementación posterior.
        return true;
    }

    protected function prepareForValidation()
    {
        $series = $this->input('inputNumSerie', []);

        if (!is_array($series)) {
            return;
        }

        $this->merge([
            'inputNumSerie' => array_map(function ($serie) {
                if (!is_string($serie)) {
                    return $serie;
                }

                return strtoupper(preg_replace('/\s+/', '', trim($serie)));
            }, $series),
        ]);
    }

    public function rules()
    {
        return [
            'cantidad' => ['required', 'integer', 'min:1'],
            'inputNumSerie' => ['required', 'array', 'min:1'],
            'inputNumSerie.*' => ['required', 'string', 'max:255', 'distinct'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $series = $this->input('inputNumSerie', []);

            if (is_array($series) && (int) $this->input('cantidad') !== count($series)) {
                $validator->errors()->add(
                    'cantidad',
                    'La cantidad debe coincidir con el número de cilindros seleccionados.'
                );
            }
        });
    }

    public function messages()
    {
        return [
            'cantidad.required' => 'La cantidad de cilindros es obligatoria.',
            'cantidad.integer' => 'La cantidad de cilindros debe ser un número entero.',
            'cantidad.min' => 'Debes seleccionar al menos un cilindro.',
            'inputNumSerie.required' => 'Debes seleccionar al menos un número de serie.',
            'inputNumSerie.array' => 'La lista de cilindros no es válida.',
            'inputNumSerie.*.distinct' => 'No puedes agregar el mismo número de serie más de una vez.',
        ];
    }
}
