<?php

namespace Tests\Feature;

use App\Models\InfraLLenado;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InfraControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testInfraDataReturnsFilteredRowsAndOperationalSummary()
    {
        $user = User::create([
            'name' => 'Operador INFRA',
            'email' => 'infra@example.com',
            'password' => bcrypt('password'),
        ]);

        InfraLLenado::create([
            'cantidad_salida' => 4,
            'cantidad_entrada' => null,
            'cantidad_diferencia' => 0,
            'pendiente' => true,
            'user_id' => $user->id,
        ]);

        InfraLLenado::create([
            'cantidad_salida' => 5,
            'cantidad_entrada' => 3,
            'cantidad_diferencia' => 2,
            'pendiente' => true,
            'user_id' => $user->id,
        ]);

        InfraLLenado::create([
            'cantidad_salida' => 2,
            'cantidad_entrada' => 2,
            'cantidad_diferencia' => 0,
            'pendiente' => false,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson('/infra/data?draw=1&start=0&length=10&status=difference');

        $response->assertOk();
        $response->assertJsonPath('recordsFiltered', 1);
        $response->assertJsonPath('summary.total', 1);
        $response->assertJsonPath('summary.pending', 0);
        $response->assertJsonPath('summary.difference', 1);
        $response->assertJsonPath('summary.complete', 0);
        $response->assertJsonPath('summary.pending_cylinders', 2);
        $response->assertJsonPath('data.0.cantidad_entrada', 3);
        $response->assertJsonPath('data.0.mostrar_diferencia', 2);
    }
}
