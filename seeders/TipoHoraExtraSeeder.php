<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoHoraExtraSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'Hora Extra 25%',
                'codigo' => 'HE_25',
                'valor_porcentual' => 25.00,
                'descripcion' => 'Horas extras en días laborables',
                'orden_aparicion' => 1,
                'activo' => true
            ],
            [
                'nombre' => 'Hora Extra 35%',
                'codigo' => 'HE_35',
                'valor_porcentual' => 35.00,
                'descripcion' => 'Horas extras nocturnas (10pm - 6am)',
                'orden_aparicion' => 2,
                'activo' => true
            ],
            [
                'nombre' => 'Hora Extra 100%',
                'codigo' => 'HE_100',
                'valor_porcentual' => 100.00,
                'descripcion' => 'Horas extras en domingos y feriados',
                'orden_aparicion' => 3,
                'activo' => true
            ],
            [
                'nombre' => 'Recargo Dominical',
                'codigo' => 'RD_100',
                'valor_porcentual' => 100.00,
                'descripcion' => 'Recargo por trabajo en domingo',
                'orden_aparicion' => 4,
                'activo' => true
            ],
            [
                'nombre' => 'Hora Extra Especial 50%',
                'codigo' => 'HE_50',
                'valor_porcentual' => 50.00,
                'descripcion' => 'Horas extras en días de capacitación o eventos especiales',
                'orden_aparicion' => 5,
                'activo' => true
            ],
            [
                'nombre' => 'Recargo Feriado',
                'codigo' => 'RF_100',
                'valor_porcentual' => 100.00,
                'descripcion' => 'Recargo por trabajo en días feriados',
                'orden_aparicion' => 6,
                'activo' => true
            ]
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_hora_extra')->insert([
                'nombre' => $tipo['nombre'],
                'codigo' => $tipo['codigo'],
                'valor_porcentual' => $tipo['valor_porcentual'],
                'descripcion' => $tipo['descripcion'],
                'orden_aparicion' => $tipo['orden_aparicion'],
                'activo' => $tipo['activo'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
