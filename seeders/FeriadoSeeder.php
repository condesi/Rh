<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feriado;
use Carbon\Carbon;

class FeriadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feriados = [
            [
                'nombre' => 'Año Nuevo',
                'descripcion' => 'Celebración del inicio del año nuevo',
                'fecha' => '2024-01-01',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Jueves Santo',
                'descripcion' => 'Celebración religiosa cristiana',
                'fecha' => '2024-03-28',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Viernes Santo',
                'descripcion' => 'Celebración religiosa cristiana',
                'fecha' => '2024-03-29',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Día del Trabajo',
                'descripcion' => 'Día Internacional del Trabajador',
                'fecha' => '2024-05-01',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Fiestas Patrias - Día de la Independencia',
                'descripcion' => 'Celebración de la independencia nacional',
                'fecha' => '2024-07-28',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Fiestas Patrias - Día de las Fuerzas Armadas',
                'descripcion' => 'Día de las Fuerzas Armadas y Policía Nacional',
                'fecha' => '2024-07-29',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Santa Rosa de Lima',
                'descripcion' => 'Festividad de Santa Rosa de Lima',
                'fecha' => '2024-08-30',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Combate de Angamos',
                'descripcion' => 'Conmemoración del Combate de Angamos',
                'fecha' => '2024-10-08',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Todos los Santos',
                'descripcion' => 'Día de Todos los Santos',
                'fecha' => '2024-11-01',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Inmaculada Concepción',
                'descripcion' => 'Festividad de la Inmaculada Concepción',
                'fecha' => '2024-12-08',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Navidad',
                'descripcion' => 'Celebración del nacimiento de Jesucristo',
                'fecha' => '2024-12-25',
                'tipo' => 'religioso'
            ],
            // Feriados 2025
            [
                'nombre' => 'Año Nuevo',
                'descripcion' => 'Celebración del inicio del año nuevo',
                'fecha' => '2025-01-01',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Jueves Santo',
                'descripcion' => 'Celebración religiosa cristiana',
                'fecha' => '2025-04-17',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Viernes Santo',
                'descripcion' => 'Celebración religiosa cristiana',
                'fecha' => '2025-04-18',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Día del Trabajo',
                'descripcion' => 'Día Internacional del Trabajador',
                'fecha' => '2025-05-01',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Fiestas Patrias - Día de la Independencia',
                'descripcion' => 'Celebración de la independencia nacional',
                'fecha' => '2025-07-28',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Fiestas Patrias - Día de las Fuerzas Armadas',
                'descripcion' => 'Día de las Fuerzas Armadas y Policía Nacional',
                'fecha' => '2025-07-29',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Santa Rosa de Lima',
                'descripcion' => 'Festividad de Santa Rosa de Lima',
                'fecha' => '2025-08-30',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Combate de Angamos',
                'descripcion' => 'Conmemoración del Combate de Angamos',
                'fecha' => '2025-10-08',
                'tipo' => 'nacional'
            ],
            [
                'nombre' => 'Todos los Santos',
                'descripcion' => 'Día de Todos los Santos',
                'fecha' => '2025-11-01',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Inmaculada Concepción',
                'descripcion' => 'Festividad de la Inmaculada Concepción',
                'fecha' => '2025-12-08',
                'tipo' => 'religioso'
            ],
            [
                'nombre' => 'Navidad',
                'descripcion' => 'Celebración del nacimiento de Jesucristo',
                'fecha' => '2025-12-25',
                'tipo' => 'religioso'
            ]
        ];

        // Clear existing data to avoid duplicates
        Feriado::truncate();
        
        foreach ($feriados as $feriado) {
            Feriado::create($feriado);
        }
    }
}