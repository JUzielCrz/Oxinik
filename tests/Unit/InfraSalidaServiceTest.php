<?php

namespace Tests\Unit;

use App\Models\InfraLLenado;
use App\Models\InfraTanque;
use App\Models\Tanque;
use App\Services\InfraSalidaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class InfraSalidaServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistersAllSelectedTanksAndChangesTheirStatus()
    {
        $this->crearTanque('A-001', 'VACIO-ALMACEN');
        $this->crearTanque('A-002', 'VACIO-ALMACEN');

        $infra = (new InfraSalidaService())->registrar(['A-001', 'A-002'], 2, 10);

        $this->assertSame(2, $infra->cantidad_salida);
        $this->assertSame(2, InfraTanque::count());
        $this->assertSame(2, Tanque::where('estatus', 'INFRA')->count());
    }

    public function testRejectsWhenQuantityDoesNotMatchSelectedTanks()
    {
        $this->crearTanque('A-001', 'VACIO-ALMACEN');

        $this->expectException(ValidationException::class);

        (new InfraSalidaService())->registrar(['A-001'], 2, 10);
    }

    public function testRejectsTankThatIsNotAvailableAndDoesNotCreateOutput()
    {
        $this->crearTanque('A-001', 'INFRA');

        try {
            (new InfraSalidaService())->registrar(['A-001'], 1, 10);
            $this->fail('Se esperaba una validación para el tanque no disponible.');
        } catch (ValidationException $exception) {
            $this->assertSame(0, InfraLLenado::count());
            $this->assertSame(0, InfraTanque::count());
        }
    }

    private function crearTanque($serie, $estatus)
    {
        if (!DB::table('catalogo_gases')->where('id', 1)->exists()) {
            DB::table('catalogo_gases')->insert([
                'id' => 1,
                'nombre' => 'Oxígeno',
                'abreviatura' => 'O2',
            ]);
        }

        Tanque::create([
            'num_serie' => $serie,
            'ph' => '2026-01',
            'capacidad' => '1 CARGA',
            'material' => 'Acero',
            'fabricante' => 'Infra',
            'tipo_gas' => 1,
            'tipo_tanque' => 'Industrial',
            'estatus' => $estatus,
        ]);
    }
}
