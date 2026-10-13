<?php

namespace App\Services;

use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InfraSalidaService
{
    public function registrar(array $series, $cantidad, $userId)
    {
        $series = array_values(array_unique($series));

        if ((int) $cantidad !== count($series)) {
            throw ValidationException::withMessages([
                'cantidad' => 'La cantidad debe coincidir con el número de cilindros seleccionados.',
            ]);
        }

        return DB::transaction(function () use ($series, $cantidad, $userId) {
            $tanques = Tanque::whereIn('num_serie', $series)
                ->lockForUpdate()
                ->get()
                ->keyBy('num_serie');

            $faltantes = array_values(array_diff($series, $tanques->keys()->all()));

            if (count($faltantes) > 0) {
                throw ValidationException::withMessages([
                    'inputNumSerie' => 'No se encontraron los cilindros: '.implode(', ', $faltantes).'.',
                ]);
            }

            $noDisponibles = $tanques->filter(function ($tanque) {
                return $tanque->estatus !== 'VACIO-ALMACEN';
            });

            if ($noDisponibles->isNotEmpty()) {
                $detalle = $noDisponibles->map(function ($tanque) {
                    return $tanque->num_serie.' ('.$tanque->estatus.')';
                })->implode(', ');

                throw ValidationException::withMessages([
                    'inputNumSerie' => 'Los siguientes cilindros no están disponibles para salida: '.$detalle.'.',
                ]);
            }

            $infra = new InfraLLenado;
            $infra->cantidad_salida = (int) $cantidad;
            $infra->user_id = $userId;
            $infra->save();

            foreach ($series as $serie) {
                $infraTanque = new InfraTanque;
                $infraTanque->num_serie = $serie;
                $infraTanque->infrallenado_id = $infra->id;
                $infraTanque->incidencia = 'SALIDA';
                $infraTanque->save();

                $tanques->get($serie)->update(['estatus' => 'INFRA']);
            }

            return $infra;
        });
    }
}
