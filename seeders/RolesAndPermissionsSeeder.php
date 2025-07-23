<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear permisos para cada módulo
        $modules = [
            'empleados',
            'contratos',
            'asistencias',
            'vacaciones',
            'planillas',
            'documentos',
            'configuracion',
            'reportes'
        ];

        $actions = [
            'ver',
            'crear',
            'editar',
            'eliminar',
            'exportar'
        ];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$action} {$module}"]);
            }
        }

        // Crear roles con sus permisos
        $roles = [
            'super-admin' => '*',
            'administrador' => [
                'ver *',
                'crear *',
                'editar *',
                'eliminar *',
                'exportar *'
            ],
            'rrhh' => [
                'ver empleados',
                'crear empleados',
                'editar empleados',
                'ver contratos',
                'crear contratos',
                'editar contratos',
                'ver asistencias',
                'editar asistencias',
                'ver vacaciones',
                'crear vacaciones',
                'editar vacaciones',
                'ver documentos',
                'crear documentos',
                'ver reportes',
                'exportar reportes'
            ],
            'supervisor' => [
                'ver empleados',
                'ver asistencias',
                'editar asistencias',
                'ver vacaciones',
                'ver reportes'
            ],
            'empleado' => [
                'ver asistencias',
                'ver documentos'
            ]
        ];

        foreach ($roles as $role => $permissions) {
            $roleInstance = Role::create(['name' => $role]);
            
            if ($permissions === '*') {
                $roleInstance->givePermissionTo(Permission::all());
            } else {
                $roleInstance->givePermissionTo($permissions);
            }
        }
    }
}
