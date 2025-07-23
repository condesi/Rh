<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TiposContratoSeeder extends Seeder
{
    public function run(): void
    {
        $tiposContrato = [
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato Indefinido',
                'descripcion' => 'Contrato a plazo indeterminado segun la legislacion peruana',
                'modalidad' => 'indefinido',
                'duracion_maxima_meses' => null,
                'permite_renovacion' => false,
                'requisitos_legales' => 'No requiere causa especifica para su terminacion',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato por Necesidad del Mercado',
                'descripcion' => 'Contrato sujeto a modalidad por necesidades del mercado',
                'modalidad' => 'temporal',
                'duracion_maxima_meses' => 60,
                'permite_renovacion' => true,
                'requisitos_legales' => 'Requiere justificacion de necesidad del mercado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato por Obra o Servicio',
                'descripcion' => 'Contrato para obra determinada o servicio especifico',
                'modalidad' => 'obra_servicio',
                'duracion_maxima_meses' => 60,
                'permite_renovacion' => true,
                'requisitos_legales' => 'Debe especificar la obra o servicio a realizar',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato de Emergencia',
                'descripcion' => 'Contrato para cubrir necesidades de emergencia',
                'modalidad' => 'temporal',
                'duracion_maxima_meses' => 6,
                'permite_renovacion' => false,
                'requisitos_legales' => 'Solo para situaciones de emergencia justificadas',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato de Suplencia',
                'descripcion' => 'Contrato para reemplazar a trabajador con suspension de labores',
                'modalidad' => 'temporal',
                'duracion_maxima_meses' => null,
                'permite_renovacion' => false,
                'requisitos_legales' => 'Debe especificar al trabajador que se esta reemplazando',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Contrato de Practicas',
                'descripcion' => 'Contrato para estudiantes en practicas profesionales',
                'modalidad' => 'practicas',
                'duracion_maxima_meses' => 12,
                'permite_renovacion' => true,
                'requisitos_legales' => 'Requiere convenio con centro de estudios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('tipos_contrato')->insert($tiposContrato);
    }
}