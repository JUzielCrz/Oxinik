<?php

namespace Tests\Feature;

use App\Models\NotaForanea;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotaForaneaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDataFiltersNotesThatStillNeedAttention()
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'foranea@example.com',
            'password' => bcrypt('password'),
        ]);

        $role = Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
        ]);
        $user->roles()->attach($role->id);

        NotaForanea::create([
            'nombre' => 'Cliente pendiente',
            'subtotal' => 100,
            'total' => 116,
            'pago_cubierto' => false,
            'tanques_devueltos' => true,
            'fecha' => '2026-11-01',
            'user_id' => $user->id,
        ]);

        NotaForanea::create([
            'nombre' => 'Cliente completa',
            'subtotal' => 200,
            'total' => 232,
            'pago_cubierto' => true,
            'tanques_devueltos' => true,
            'fecha' => '2026-11-02',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson('/nota/foranea/data?draw=1&start=0&length=10&estado=pendiente');

        $response->assertOk();
        $response->assertJsonPath('recordsFiltered', 1);
        $response->assertJsonPath('data.0.nombre', 'Cliente pendiente');
        $response->assertJsonPath('data.0.pago_cubierto', '<span class="badge badge-warning">Adeuda</span>');
        $response->assertJsonPath('data.0.estado_nota', '<span class="badge badge-warning">Pendiente</span>');

        $completeResponse = $this->actingAs($user)->getJson('/nota/foranea/data?draw=1&start=0&length=10&pago=cubierto&tanques=devueltos&desde=2026-11-02&hasta=2026-11-02');

        $completeResponse->assertOk();
        $completeResponse->assertJsonPath('recordsFiltered', 1);
        $completeResponse->assertJsonPath('data.0.nombre', 'Cliente completa');
    }
}
