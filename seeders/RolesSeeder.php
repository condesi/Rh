<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Rol;
use App\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing roles to avoid duplicates
        if (Schema::hasTable('roles')) {
            DB::table('roles')->delete();
        }
        
        // Define roles with their permissions
        $roles = [
            [
                'id' => Str::uuid()->toString(),
                'nombre' => 'Super Administrador',
                'display_name' => 'Super Administrador',
                'descripcion' => 'Acceso completo al sistema',
                'permisos' => json_encode(Rol::permisosDisponibles()),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'nombre' => 'Administrador RRHH',
                'display_name' => 'Administrador RRHH',
                'descripcion' => 'Gestión completa de recursos humanos',
                'permisos' => json_encode([
                    'empleados.crear', 'empleados.editar', 'empleados.ver', 'empleados.ver_todos', 'empleados.exportar',
                    'planillas.crear', 'planillas.editar', 'planillas.ver', 'planillas.aprobar', 'planillas.calcular', 'planillas.exportar',
                    'asistencia.ver', 'asistencia.editar', 'asistencia.registrar', 'asistencia.aprobar_horas_extra', 'asistencia.justificar_faltas',
                    'vacaciones.ver', 'vacaciones.aprobar', 'vacaciones.rechazar', 'vacaciones.programar',
                    'contratos.ver', 'contratos.crear', 'contratos.editar', 'contratos.generar_plantillas',
                    'descansos_medicos.ver', 'descansos_medicos.registrar', 'descansos_medicos.gestionar_subsidios',
                    'legajo.ver', 'legajo.subir_documentos', 'legajo.ver_confidencial',
                    'boletas.ver_todas', 'boletas.generar', 'boletas.reenviar',
                    'reportes.ver_basicos', 'reportes.ver_avanzados', 'reportes.exportar',
                    'exportaciones.plame', 'exportaciones.t_registro', 'exportaciones.afp_net', 'exportaciones.cts',
                    'configuracion.ver', 'configuracion.feriados', 'configuracion.tasas_laborales',
                    'auditoria.ver', 'auditoria.exportar',
                    'notificaciones.enviar_masivas'
                ]),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'nombre' => 'Supervisor',
                'display_name' => 'Supervisor',
                'descripcion' => 'Supervisión de asistencia y planillas',
                'permisos' => json_encode([
                    'empleados.ver', 'empleados.ver_todos',
                    'planillas.ver', 'planillas.exportar',
                    'asistencia.ver', 'asistencia.editar', 'asistencia.justificar_faltas',
                    'vacaciones.ver', 'vacaciones.aprobar', 'vacaciones.rechazar',
                    'descansos_medicos.ver',
                    'legajo.ver',
                    'reportes.ver_basicos', 'reportes.exportar',
                    'boletas.ver_todas'
                ]),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'nombre' => 'Empleado',
                'display_name' => 'Empleado',
                'descripcion' => 'Acceso básico para empleados',
                'permisos' => json_encode([
                    'planillas.ver',
                    'asistencia.ver',
                    'vacaciones.ver', 'vacaciones.solicitar',
                    'descansos_medicos.ver',
                    'legajo.ver',
                    'boletas.ver_propias'
                ]),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'nombre' => 'Contador',
                'display_name' => 'Contador',
                'descripcion' => 'Acceso a información contable y financiera',
                'permisos' => json_encode([
                    'empleados.ver', 'empleados.ver_todos', 'empleados.exportar',
                    'planillas.ver', 'planillas.calcular', 'planillas.exportar',
                    'boletas.ver_todas', 'boletas.generar', 'boletas.reenviar',
                    'exportaciones.plame', 'exportaciones.t_registro', 'exportaciones.afp_net', 'exportaciones.cts',
                    'reportes.ver_basicos', 'reportes.exportar'
                ]),
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert the roles
        if (Schema::hasTable('roles')) {
            DB::table('roles')->insert($roles);
        }
        
        // Now, if we have permissions table, add the relationships
        if (Schema::hasTable('permissions') && Schema::hasTable('rol_permissions')) {
            // For each role, set up permission relationships
            foreach ($roles as $roleData) {
                $roleId = $roleData['id'];
                $permissions = json_decode($roleData['permisos'], true);
                
                // Find all relevant permission records
                $permissionRecords = DB::table('permissions')
                    ->whereIn('name', $permissions)
                    ->get(['id', 'name']);
                
                // Create role_permissions entries
                $rolPermissions = [];
                foreach ($permissionRecords as $permission) {
                    $rolPermissions[] = [
                        'id' => Str::uuid()->toString(),
                        'rol_id' => $roleId,
                        'permission_id' => $permission->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                
                if (count($rolPermissions) > 0) {
                    DB::table('rol_permissions')->insert($rolPermissions);
                }
            }
        }
        
        $this->command->info('Seeded ' . count($roles) . ' roles with permissions.');
    }
}