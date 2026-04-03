<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * FormasPagoSeeder
 *
 * Métodos de pago de uso frecuente en Colombia.
 *
 * requiere_banco:
 *   true  → al registrar el pago se debe seleccionar una cuenta bancaria
 *   false → pago en efectivo o sin cuenta bancaria asociada
 */
class FormasPagoSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $formas = [
            ['nombre' => 'Efectivo',           'requiere_banco' => false, 'descripcion' => 'Pago en efectivo'],
            ['nombre' => 'Transferencia',      'requiere_banco' => true,  'descripcion' => 'Transferencia bancaria o ACH'],
            ['nombre' => 'Cheque',             'requiere_banco' => true,  'descripcion' => 'Cheque bancario'],
            ['nombre' => 'Tarjeta Débito',     'requiere_banco' => true,  'descripcion' => 'Pago con tarjeta débito'],
            ['nombre' => 'Tarjeta Crédito',    'requiere_banco' => false, 'descripcion' => 'Pago con tarjeta crédito'],
            ['nombre' => 'Nequi',              'requiere_banco' => false, 'descripcion' => 'Pago por Nequi'],
            ['nombre' => 'Daviplata',          'requiere_banco' => false, 'descripcion' => 'Pago por Daviplata'],
            ['nombre' => 'PSE',                'requiere_banco' => true,  'descripcion' => 'Pago en línea PSE'],
            ['nombre' => 'Crédito Directo',    'requiere_banco' => false, 'descripcion' => 'Crédito otorgado directamente por la empresa'],
            ['nombre' => 'Compensación',       'requiere_banco' => false, 'descripcion' => 'Cruce de cuentas o compensación de cartera'],
        ];

        foreach ($formas as $forma) {
            $existe = DB::table('formas_pago')->where('nombre', $forma['nombre'])->exists();
            if (! $existe) {
                DB::table('formas_pago')->insert([
                    'nombre'         => $forma['nombre'],
                    'requiere_banco' => $forma['requiere_banco'],
                    'descripcion'    => $forma['descripcion'],
                    'activo'         => true,
                    'created_at'     => $now,
                    'updated_at'     => $now,
                ]);
            }
        }
    }
}
