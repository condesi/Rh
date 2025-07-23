<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MainTablesSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear datos de configuración base
        DB::table('configuraciones')->insert([
            'id' => Str::uuid(),
            'razon_social' => 'ADESUR S.A.C.',
            'ruc' => '20123456789',
            'direccion' => 'Av. Principal 123',
            'telefono' => '01-234-5678',
            'email' => 'contacto@adesur.com',
            'website' => 'www.adesur.com',
            'logo' => 'logo.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Crear turnos base
        $turnos = [
            [
                'nombre' => 'Turno Mañana',
                'hora_inicio' => '08:00',
                'hora_fin' => '17:00',
                'es_nocturno' => false,
                'horas_regulares' => 8,
                'dias_semana' => json_encode([1,2,3,4,5])
            ],
            [
                'nombre' => 'Turno Tarde',
                'hora_inicio' => '14:00',
                'hora_fin' => '23:00',
                'es_nocturno' => true,
                'horas_regulares' => 8,
                'dias_semana' => json_encode([1,2,3,4,5])
            ],
            [
                'nombre' => 'Turno Noche',
                'hora_inicio' => '23:00',
                'hora_fin' => '08:00',
                'es_nocturno' => true,
                'horas_regulares' => 8,
                'dias_semana' => json_encode([1,2,3,4,5])
            ]
        ];

        foreach ($turnos as $turno) {
            DB::table('turnos')->insert($turno);
        }

        // 3. Crear cargos base
        $cargos = [
            [
                'id' => Str::uuid(),
                'nombre' => 'Gerente General',
                'descripcion' => 'Dirección general de la empresa',
                'nivel' => 1,
                'created_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Jefe de RRHH',
                'descripcion' => 'Gestión del recurso humano',
                'nivel' => 2,
                'created_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Asistente RRHH',
                'descripcion' => 'Apoyo en gestión de RRHH',
                'nivel' => 3,
                'created_at' => now()
            ]
        ];

        foreach ($cargos as $cargo) {
            DB::table('cargos')->insert($cargo);
        }

        // 4. Crear conceptos de nómina base
        $conceptos = [
            [
                'id' => Str::uuid(),
                'codigo' => 'HAB001',
                'nombre' => 'Sueldo Básico',
                'tipo' => 'ingreso',
                'es_fijo' => true,
                'created_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'codigo' => 'HAB002',
                'nombre' => 'Asignación Familiar',
                'tipo' => 'ingreso',
                'es_fijo' => true,
                'created_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'codigo' => 'DES001',
                'nombre' => 'AFP',
                'tipo' => 'descuento',
                'es_fijo' => true,
                'created_at' => now()
            ],
            [
                'id' => Str::uuid(),
                'codigo' => 'DES002',
                'nombre' => 'ONP',
                'tipo' => 'descuento',
                'es_fijo' => true,
                'created_at' => now()
            ]
        ];

        foreach ($conceptos as $concepto) {
            DB::table('conceptos_nomina')->insert($concepto);
        }

        // 5. Crear feriados del año
        $feriados = [
            ['fecha' => '2025-01-01', 'descripcion' => 'Año Nuevo'],
            ['fecha' => '2025-04-17', 'descripcion' => 'Jueves Santo'],
            ['fecha' => '2025-04-18', 'descripcion' => 'Viernes Santo'],
            ['fecha' => '2025-05-01', 'descripcion' => 'Día del Trabajo'],
            ['fecha' => '2025-06-29', 'descripcion' => 'San Pedro y San Pablo'],
            ['fecha' => '2025-07-28', 'descripcion' => 'Fiestas Patrias'],
            ['fecha' => '2025-07-29', 'descripcion' => 'Fiestas Patrias'],
            ['fecha' => '2025-08-30', 'descripcion' => 'Santa Rosa de Lima'],
            ['fecha' => '2025-10-08', 'descripcion' => 'Combate de Angamos'],
            ['fecha' => '2025-11-01', 'descripcion' => 'Todos los Santos'],
            ['fecha' => '2025-12-08', 'descripcion' => 'Inmaculada Concepción'],
            ['fecha' => '2025-12-25', 'descripcion' => 'Navidad']
        ];

        foreach ($feriados as $feriado) {
            DB::table('feriados')->insert(array_merge($feriado, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // 6. Crear tipos de documentos
        $tiposDocumento = [
            ['codigo' => 'DNI', 'nombre' => 'Documento Nacional de Identidad'],
            ['codigo' => 'CE', 'nombre' => 'Carné de Extranjería'],
            ['codigo' => 'PAS', 'nombre' => 'Pasaporte'],
            ['codigo' => 'PTP', 'nombre' => 'Permiso Temporal de Permanencia']
        ];

        foreach ($tiposDocumento as $tipo) {
            DB::table('tipos_documento')->insert(array_merge($tipo, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // 7. Crear bancos
        $bancos = [
            ['codigo' => 'BCP', 'nombre' => 'Banco de Crédito del Perú'],
            ['codigo' => 'BBVA', 'nombre' => 'BBVA Continental'],
            ['codigo' => 'IBK', 'nombre' => 'Interbank'],
            ['codigo' => 'SBP', 'nombre' => 'Scotiabank Perú'],
            ['codigo' => 'BN', 'nombre' => 'Banco de la Nación']
        ];

        foreach ($bancos as $banco) {
            DB::table('bancos')->insert(array_merge($banco, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // 8. Crear tipos de contrato
        $tiposContrato = [
            [
                'codigo' => 'IND',
                'nombre' => 'Indefinido',
                'descripcion' => 'Contrato a plazo indeterminado'
            ],
            [
                'codigo' => 'FIJ',
                'nombre' => 'Plazo Fijo',
                'descripcion' => 'Contrato a plazo determinado'
            ],
            [
                'codigo' => 'TPP',
                'nombre' => 'Tiempo Parcial',
                'descripcion' => 'Contrato part-time'
            ]
        ];

        foreach ($tiposContrato as $tipo) {
            DB::table('tipos_contrato')->insert(array_merge($tipo, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
