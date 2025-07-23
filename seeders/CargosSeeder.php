<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CargosSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = DB::table('departamentos')->get();
        
        $cargos = [];
        
        foreach ($departamentos as $departamento) {
            switch ($departamento->nombress) {
                case 'Recursos Humanos':
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Gerente de RRHH',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Responsable de la gestion integral de recursos humanos',
                        'salario_minimo' => 4000.00,
                        'salario_maximo' => 6000.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Especialista en RRHH',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Apoyo en procesos de recursos humanos',
                        'salario_minimo' => 2500.00,
                        'salario_maximo' => 3500.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break;
                    
                case 'Administracion':
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Gerente General',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Direccion general de la empresa',
                        'salario_minimo' => 8000.00,
                        'salario_maximo' => 12000.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Contador',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Gestion contable y financiera',
                        'salario_minimo' => 3000.00,
                        'salario_maximo' => 4500.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break;
                    
                case 'Ventas':
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Gerente Comercial',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Direccion del area comercial',
                        'salario_minimo' => 5000.00,
                        'salario_maximo' => 7000.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Vendedor',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Ejecutivo de ventas',
                        'salario_minimo' => 1500.00,
                        'salario_maximo' => 2500.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break;
                    
                case 'Operaciones':
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Supervisor de Operaciones',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Supervision de procesos operativos',
                        'salario_minimo' => 3500.00,
                        'salario_maximo' => 4500.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Operario',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Ejecucion de tareas operativas',
                        'salario_minimo' => 1025.00,
                        'salario_maximo' => 1500.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break;
                    
                case 'Tecnologia':
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Desarrollador Senior',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Desarrollo de software',
                        'salario_minimo' => 4000.00,
                        'salario_maximo' => 6000.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $cargos[] = [
                        'id' => Str::uuid(),
                        'nombre' => 'Soporte Técnico',
                        'departamento_id' => $departamento->id,
                        'descripcion' => 'Soporte tecnico y mantenimiento',
                        'salario_minimo' => 2000.00,
                        'salario_maximo' => 3000.00,
                        'activo' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    break;
            }
        }

        DB::table('cargos')->insert($cargos);
    }
}