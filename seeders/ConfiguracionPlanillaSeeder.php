<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionPlanilla;
use Illuminate\Support\Facades\DB;

class ConfiguracionPlanillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configuracion_planillas')->truncate();

        $configuraciones = [
            // --- Valores Legales y Tributarios ---
            [
                'clave' => 'UIT',
                'valor' => 5150.00,
                'descripcion' => 'Unidad Impositiva Tributaria (Anual)',
            ],
            [
                'clave' => 'RMV',
                'valor' => 1025.00,
                'descripcion' => 'Remuneración Mínima Vital (Mensual)',
            ],
            [
                'clave' => 'ASIGNACION_FAMILIAR_PORCENTAJE',
                'valor' => 10,
                'descripcion' => 'Porcentaje de la RMV para Asignación Familiar',
            ],

            // --- Aportes del Empleador ---
            [
                'clave' => 'ESSALUD_PORCENTAJE',
                'valor' => 9,
                'descripcion' => 'Aporte a EsSalud por parte del empleador (%)',
            ],
            [
                'clave' => 'SCTR_PENSION_TASA',
                'valor' => 0.53,
                'descripcion' => 'Tasa de SCTR Pensión (puede variar)',
            ],
            [
                'clave' => 'SCTR_SALUD_TASA',
                'valor' => 0.53,
                'descripcion' => 'Tasa de SCTR Salud (puede variar)',
            ],
             [
                'clave' => 'SENATI_PORCENTAJE',
                'valor' => 0.75,
                'descripcion' => 'Aporte al SENATI por parte del empleador (%)',
            ],


            // --- Regímenes de Pensiones (AFP) - Valores referenciales ---
            [
                'clave' => 'AFP_INTEGRA_APORTE_OBLIGATORIO',
                'valor' => 10.00,
                'descripcion' => 'Aporte obligatorio a AFP Integra (%)',
            ],
            [
                'clave' => 'AFP_INTEGRA_PRIMA_SEGURO',
                'valor' => 1.84,
                'descripcion' => 'Prima de seguro de AFP Integra (%)',
            ],
            [
                'clave' => 'AFP_INTEGRA_COMISION_FLUJO',
                'valor' => 0.00,
                'descripcion' => 'Comisión sobre el flujo de AFP Integra (%)',
            ],
            [
                'clave' => 'AFP_PRIMA_APORTE_OBLIGATORIO',
                'valor' => 10.00,
                'descripcion' => 'Aporte obligatorio a AFP Prima (%)',
            ],
            [
                'clave' => 'AFP_PRIMA_PRIMA_SEGURO',
                'valor' => 1.84,
                'descripcion' => 'Prima de seguro de AFP Prima (%)',
            ],
            [
                'clave' => 'AFP_PRIMA_COMISION_FLUJO',
                'valor' => 0.00,
                'descripcion' => 'Comisión sobre el flujo de AFP Prima (%)',
            ],
            [
                'clave' => 'AFP_PROFUTURO_APORTE_OBLIGATORIO',
                'valor' => 10.00,
                'descripcion' => 'Aporte obligatorio a AFP Profuturo (%)',
            ],
            [
                'clave' => 'AFP_PROFUTURO_PRIMA_SEGURO',
                'valor' => 1.84,
                'descripcion' => 'Prima de seguro de AFP Profuturo (%)',
            ],
            [
                'clave' => 'AFP_PROFUTURO_COMISION_FLUJO',
                'valor' => 0.00,
                'descripcion' => 'Comisión sobre el flujo de AFP Profuturo (%)',
            ],
            [
                'clave' => 'AFP_HABITAT_APORTE_OBLIGATORIO',
                'valor' => 10.00,
                'descripcion' => 'Aporte obligatorio a AFP Habitat (%)',
            ],
            [
                'clave' => 'AFP_HABITAT_PRIMA_SEGURO',
                'valor' => 1.84,
                'descripcion' => 'Prima de seguro de AFP Habitat (%)',
            ],
            [
                'clave' => 'AFP_HABITAT_COMISION_FLUJO',
                'valor' => 0.00,
                'descripcion' => 'Comisión sobre el flujo de AFP Habitat (%)',
            ],


            // --- ONP ---
            [
                'clave' => 'ONP_TASA',
                'valor' => 13.00,
                'descripcion' => 'Tasa de aporte a la ONP (%)',
            ],

            // --- Impuesto a la Renta (5ta Categoría) ---
            [
                'clave' => 'RENTA_5TA_TRAMO_1_HASTA_UIT',
                'valor' => 5,
                'descripcion' => 'Límite del Tramo 1 para Renta de 5ta (en UITs)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_1_TASA',
                'valor' => 8,
                'descripcion' => 'Tasa del Tramo 1 para Renta de 5ta (%)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_2_HASTA_UIT',
                'valor' => 20,
                'descripcion' => 'Límite del Tramo 2 para Renta de 5ta (en UITs)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_2_TASA',
                'valor' => 14,
                'descripcion' => 'Tasa del Tramo 2 para Renta de 5ta (%)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_3_HASTA_UIT',
                'valor' => 35,
                'descripcion' => 'Límite del Tramo 3 para Renta de 5ta (en UITs)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_3_TASA',
                'valor' => 17,
                'descripcion' => 'Tasa del Tramo 3 para Renta de 5ta (%)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_4_HASTA_UIT',
                'valor' => 45,
                'descripcion' => 'Límite del Tramo 4 para Renta de 5ta (en UITs)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_4_TASA',
                'valor' => 20,
                'descripcion' => 'Tasa del Tramo 4 para Renta de 5ta (%)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_5_MAS_DE_UIT',
                'valor' => 45,
                'descripcion' => 'Límite del Tramo 5 para Renta de 5ta (en UITs)',
            ],
            [
                'clave' => 'RENTA_5TA_TRAMO_5_TASA',
                'valor' => 30,
                'descripcion' => 'Tasa del Tramo 5 para Renta de 5ta (%)',
            ],
            [
                'clave' => 'RENTA_5TA_DEDUCCION_UIT',
                'valor' => 7,
                'descripcion' => 'Deducción anual para Renta de 5ta (en UITs)',
            ],
        ];

        foreach ($configuraciones as $config) {
            ConfiguracionPlanilla::create($config);
        }
    }
}
