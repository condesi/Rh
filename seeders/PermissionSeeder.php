<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds for permissions.
     */
    public function run(): void
    {
        // First, check if there's a permissions table and create it if it doesn't exist
        if (!Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('description');
                $table->string('category');
                $table->timestamps();
            });
            
            Schema::create('rol_permissions', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('rol_id');
                $table->uuid('permission_id');
                $table->timestamps();
                
                $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                
                $table->unique(['rol_id', 'permission_id']);
            });
        }
        
        // Clear existing permissions to avoid duplicates
        if (Schema::hasTable('rol_permissions')) {
            DB::table('rol_permissions')->delete();
        }
        
        if (Schema::hasTable('permissions')) {
            DB::table('permissions')->delete();
        }
        
        $categories = Permission::getCategories();
        $allPermissions = [];
        
        // Generate permissions based on the Permission model's permisosDisponibles method
        foreach (\App\Models\Rol::permisosDisponibles() as $permission) {
            // Extract category from permission name (e.g., 'empleados.ver' => 'empleados')
            $parts = explode('.', $permission);
            $category = $parts[0];
            $action = $parts[1] ?? '';
            
            // Build a readable description
            $categoryName = $categories[$category] ?? ucfirst($category);
            $description = $this->generateDescription($action, $categoryName);
            
            $allPermissions[] = [
                'id' => Str::uuid()->toString(),
                'name' => $permission,
                'description' => $description,
                'category' => $category,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        // Insert all permissions
        DB::table('permissions')->insert($allPermissions);
        
        // Log completion
        $this->command->info('Seeded ' . count($allPermissions) . ' permissions.');
    }
    
    /**
     * Generate a human-readable description for a permission
     */
    private function generateDescription($action, $categoryName): string
    {
        $actionDescriptions = [
            'ver' => 'Ver',
            'crear' => 'Crear',
            'editar' => 'Editar',
            'eliminar' => 'Eliminar',
            'exportar' => 'Exportar',
            'aprobar' => 'Aprobar',
            'rechazar' => 'Rechazar',
            'registrar' => 'Registrar',
            'solicitar' => 'Solicitar',
            'generar' => 'Generar',
            'subir' => 'Subir',
            'configurar' => 'Configurar',
            'ver_propias' => 'Ver propias',
            'ver_todos' => 'Ver todos',
            'ver_todas' => 'Ver todas',
            'ver_basicos' => 'Ver básicos',
            'ver_avanzados' => 'Ver avanzados',
            'ver_confidencial' => 'Ver confidencial',
            'programar' => 'Programar',
            'firmar' => 'Firmar',
            'reenviar' => 'Reenviar',
        ];
        
        $actionDesc = $actionDescriptions[$action] ?? ucfirst(str_replace('_', ' ', $action));
        
        return "$actionDesc $categoryName";
    }
}