<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConfiguracionSistemaSeeder extends Seeder
{
    public function run(): void
    {
        $configuraciones = [
            // Información de la empresa
            [
                'id' => Str::uuid(),
                'clave' => 'empresa_ruc',
                'valor' => '20123456789',
                'descripcion' => 'RUC de la empresa',
                'grupo' => 'empresa',
                'tipo' => 'string',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'empresa_razon_social',
                'valor' => 'Mi Empresa S.A.C.',
                'descripcion' => 'Razon social de la empresa',
                'grupo' => 'empresa',
                'tipo' => 'string',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'empresa_direccion',
                'valor' => 'Av. Principal 123, Lima, Peru',
                'descripcion' => 'Direccion fiscal de la empresa',
                'grupo' => 'empresa',
                'tipo' => 'string',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Configuración de planillas
            [
                'id' => Str::uuid(),
                'clave' => 'planilla_asignacion_familiar',
                'valor' => '102.50',
                'descripcion' => 'Monto de asignacion familiar vigente',
                'grupo' => 'planilla',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'planilla_uit_anual',
                'valor' => '5150.00',
                'descripcion' => 'UIT anual vigente',
                'grupo' => 'planilla',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'planilla_rmv',
                'valor' => '1025.00',
                'descripcion' => 'Remuneracion Minima Vital',
                'grupo' => 'planilla',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Porcentajes de aportes
            [
                'id' => Str::uuid(),
                'clave' => 'aporte_essalud_empleador',
                'valor' => '9.00',
                'descripcion' => 'Porcentaje EsSalud empleador (%)',
                'grupo' => 'aportes',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'aporte_pension_empleado',
                'valor' => '13.00',
                'descripcion' => 'Porcentaje AFP empleado (%)',
                'grupo' => 'aportes',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'sctr_pension_empleador',
                'valor' => '1.23',
                'descripcion' => 'Porcentaje SCTR Pension empleador (%)',
                'grupo' => 'aportes',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'sctr_salud_empleador',
                'valor' => '0.53',
                'descripcion' => 'Porcentaje SCTR Salud empleador (%)',
                'grupo' => 'aportes',
                'tipo' => 'decimal',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Configuración de asistencia
            [
                'id' => Str::uuid(),
                'clave' => 'asistencia_tolerancia_entrada',
                'valor' => '15',
                'descripcion' => 'Minutos de tolerancia para entrada',
                'grupo' => 'asistencia',
                'tipo' => 'integer',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'clave' => 'asistencia_horas_extras_25',
                'valor' => '2',
                'descripcion' => 'Horas extras diarias al 25% antes del 35%',
                'grupo' => 'asistencia',
                'tipo' => 'integer',
                'es_editable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('configuracion_sistema')->insert($configuraciones);
    }
}