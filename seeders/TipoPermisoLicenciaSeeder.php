<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPermisoLicenciaSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            // Licencias Médicas
            [
                'codigo' => 'LM_ENF',
                'nombre' => 'Licencia por Enfermedad',
                'descripcion' => 'Licencia médica por enfermedad común',
                'dias_max_ano' => null,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => true,
                'aplica_sil' => true,
                'categoria' => 'licencia',
                'orden' => 1,
                'activo' => true
            ],
            [
                'codigo' => 'LM_MAT',
                'nombre' => 'Licencia por Maternidad',
                'descripcion' => 'Descanso pre y post natal',
                'dias_max_ano' => null,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => true,
                'aplica_sil' => true,
                'categoria' => 'licencia',
                'orden' => 2,
                'activo' => true
            ],
            [
                'codigo' => 'LM_PAT',
                'nombre' => 'Licencia por Paternidad',
                'descripcion' => 'Licencia por nacimiento de hijo/a',
                'dias_max_ano' => 10,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'licencia',
                'orden' => 3,
                'activo' => true
            ],
            
            // Permisos Remunerados
            [
                'codigo' => 'PR_FAL',
                'nombre' => 'Permiso por Fallecimiento',
                'descripcion' => 'Fallecimiento de familiar directo',
                'dias_max_ano' => 5,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'permiso',
                'orden' => 4,
                'activo' => true
            ],
            [
                'codigo' => 'PR_MAT',
                'nombre' => 'Permiso por Matrimonio',
                'descripcion' => 'Licencia por matrimonio civil',
                'dias_max_ano' => 3,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'permiso',
                'orden' => 5,
                'activo' => true
            ],
            [
                'codigo' => 'PR_EST',
                'nombre' => 'Permiso por Estudios',
                'descripcion' => 'Exámenes académicos',
                'dias_max_ano' => 10,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'permiso',
                'orden' => 6,
                'activo' => true
            ],
            
            // Permisos No Remunerados
            [
                'codigo' => 'PNR_PER',
                'nombre' => 'Permiso Personal',
                'descripcion' => 'Permiso por asuntos personales',
                'dias_max_ano' => 15,
                'requiere_sustento' => false,
                'descuenta_remuneracion' => true,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'permiso',
                'orden' => 7,
                'activo' => true
            ],
            [
                'codigo' => 'PNR_CAP',
                'nombre' => 'Permiso Capacitación',
                'descripcion' => 'Permiso para capacitación externa',
                'dias_max_ano' => 30,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => true,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'permiso',
                'orden' => 8,
                'activo' => true
            ],
            
            // Otros
            [
                'codigo' => 'OT_COM',
                'nombre' => 'Comisión de Servicios',
                'descripcion' => 'Trabajo fuera del centro laboral',
                'dias_max_ano' => null,
                'requiere_sustento' => true,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'otros',
                'orden' => 9,
                'activo' => true
            ],
            [
                'codigo' => 'OT_VAC',
                'nombre' => 'Vacaciones',
                'descripcion' => 'Periodo vacacional',
                'dias_max_ano' => 30,
                'requiere_sustento' => false,
                'descuenta_remuneracion' => false,
                'genera_subsidio' => false,
                'aplica_sil' => false,
                'categoria' => 'otros',
                'orden' => 10,
                'activo' => true
            ]
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipos_permisos')->insert([
                'codigo' => $tipo['codigo'],
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'dias_max_ano' => $tipo['dias_max_ano'],
                'requiere_sustento' => $tipo['requiere_sustento'],
                'descuenta_remuneracion' => $tipo['descuenta_remuneracion'],
                'genera_subsidio' => $tipo['genera_subsidio'],
                'aplica_sil' => $tipo['aplica_sil'],
                'categoria' => $tipo['categoria'],
                'orden' => $tipo['orden'],
                'activo' => $tipo['activo'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
