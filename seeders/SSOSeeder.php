<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SSOSeeder extends Seeder
{
    public function run()
    {
        // Sembrar categorías de EPP básicas
        $epps = [
            [
                'nombre' => 'Casco de Seguridad',
                'codigo' => 'EPP-C001',
                'descripcion' => 'Casco de seguridad con suspensión de 4 puntos',
                'categoria' => 'proteccion_cabeza',
                'vida_util_meses' => 36,
                'requiere_devolucion' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Lentes de Seguridad',
                'codigo' => 'EPP-L001',
                'descripcion' => 'Lentes de seguridad transparentes antiempañantes',
                'categoria' => 'proteccion_ocular',
                'vida_util_meses' => 12,
                'requiere_devolucion' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Tapones Auditivos',
                'codigo' => 'EPP-T001',
                'descripcion' => 'Tapones auditivos reutilizables con cordón',
                'categoria' => 'proteccion_auditiva',
                'vida_util_meses' => 6,
                'requiere_devolucion' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Respirador Media Cara',
                'codigo' => 'EPP-R001',
                'descripcion' => 'Respirador de media cara para partículas',
                'categoria' => 'proteccion_respiratoria',
                'vida_util_meses' => 24,
                'requiere_devolucion' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Guantes de Nitrilo',
                'codigo' => 'EPP-G001',
                'descripcion' => 'Guantes de nitrilo resistentes a químicos',
                'categoria' => 'proteccion_manos',
                'vida_util_meses' => 3,
                'requiere_devolucion' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Botas de Seguridad',
                'codigo' => 'EPP-B001',
                'descripcion' => 'Botas de seguridad con punta de acero',
                'categoria' => 'proteccion_pies',
                'vida_util_meses' => 12,
                'requiere_devolucion' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Arnés de Seguridad',
                'codigo' => 'EPP-A001',
                'descripcion' => 'Arnés de cuerpo completo con 4 puntos de anclaje',
                'categoria' => 'proteccion_altura',
                'vida_util_meses' => 60,
                'requiere_devolucion' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Chaleco Reflectivo',
                'codigo' => 'EPP-CH001',
                'descripcion' => 'Chaleco reflectivo con cintas reflectivas',
                'categoria' => 'ropa_protectora',
                'vida_util_meses' => 12,
                'requiere_devolucion' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($epps as $epp) {
            DB::table('sso_epp')->insert($epp);
        }

        // Sembrar tipos de capacitaciones básicas
        $capacitaciones = [
            [
                'titulo' => 'Inducción de Seguridad General',
                'descripcion' => 'Capacitación inicial sobre seguridad y salud en el trabajo',
                'tipo' => 'induccion',
                'modalidad' => 'presencial',
                'duracion_minutos' => 240,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'titulo' => 'Trabajo en Altura',
                'descripcion' => 'Capacitación especializada para trabajo en altura',
                'tipo' => 'especifica',
                'modalidad' => 'presencial',
                'duracion_minutos' => 480,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'titulo' => 'Primeros Auxilios',
                'descripcion' => 'Capacitación básica en primeros auxilios',
                'tipo' => 'periodica',
                'modalidad' => 'mixta',
                'duracion_minutos' => 360,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($capacitaciones as $capacitacion) {
            DB::table('sso_capacitaciones')->insert($capacitacion);
        }
    }
}
