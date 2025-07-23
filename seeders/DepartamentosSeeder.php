<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartamentosSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            [
                'id' => Str::uuid(),
                'nombre' => 'Recursos Humanos',
                'descripcion' => 'Gestion del talento humano',
                'codigo' => 'RRHH',
                'presupuesto_anual' => 50000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Administracion',
                'descripcion' => 'Administracion general',
                'codigo' => 'ADMIN',
                'presupuesto_anual' => 75000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Ventas',
                'descripcion' => 'Departamento comercial',
                'codigo' => 'VENTAS',
                'presupuesto_anual' => 100000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Operaciones',
                'descripcion' => 'Operaciones y produccion',
                'codigo' => 'OPS',
                'presupuesto_anual' => 80000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Tecnologia',
                'descripcion' => 'Sistemas y tecnologia',
                'codigo' => 'TI',
                'presupuesto_anual' => 60000.00,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('departamentos')->insert($departamentos);
    }
}