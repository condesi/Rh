<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PensionSystem;

class PensionSystemSeeder extends Seeder
{
    public function run()
    {
        $pensionSystems = [
            [
                'name' => 'AFP Integra',
                'description' => 'Administradora de Fondos de Pensiones Integra',
                'type' => 'AFP',
                'percentage' => 10.23,
                'active' => true
            ],
            [
                'name' => 'AFP Prima',
                'description' => 'Administradora de Fondos de Pensiones Prima',
                'type' => 'AFP',
                'percentage' => 10.23,
                'active' => true
            ],
            [
                'name' => 'AFP Profuturo',
                'description' => 'Administradora de Fondos de Pensiones Profuturo',
                'type' => 'AFP',
                'percentage' => 10.23,
                'active' => true
            ],
            [
                'name' => 'AFP Habitat',
                'description' => 'Administradora de Fondos de Pensiones Habitat',
                'type' => 'AFP',
                'percentage' => 10.23,
                'active' => true
            ],
            [
                'name' => 'ONP - SNP',
                'description' => 'Oficina de Normalización Previsional - Sistema Nacional de Pensiones',
                'type' => 'SNP',
                'percentage' => 13.00,
                'active' => true
            ],
            [
                'name' => 'Sin Sistema',
                'description' => 'Empleado sin sistema de pensiones',
                'type' => 'SIN_SISTEMA',
                'percentage' => 0.00,
                'active' => true
            ]
        ];

        foreach ($pensionSystems as $system) {
            PensionSystem::firstOrCreate(
                ['name' => $system['name']],
                $system
            );
        }
    }
}