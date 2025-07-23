<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionGeneral;
use App\Models\TipoPermiso;
use App\Models\ReglaCalculo;

class ConfiguracionGeneralSeeder extends Seeder
{
    public function run()
    {
        // Configuraciones generales del sistema
        ConfiguracionGeneral::create([
            'nombre_empresa' => 'SODEXTEL',
            'ruc' => '20123456789',
            'direccion' => 'Av. Principal 123',
            'telefono' => '(01) 123-4567',
            'email' => 'contacto@sodextel.com',
            'logo' => 'logo.png',
            'moneda' => 'PEN',
            'zona_horaria' => 'America/Lima',
            'dias_vacaciones_por_anio' => 30,
            'dias_alerta_vencimiento_contrato' => 30,
            'dias_alerta_vencimiento_documentos' => 15,
        ]);

        // Tipos de permisos
        $tiposPermiso = [
            ['nombre' => 'Permiso por enfermedad', 'requiere_sustento' => true, 'max_dias' => 3],
            ['nombre' => 'Permiso por fallecimiento familiar', 'requiere_sustento' => true, 'max_dias' => 5],
            ['nombre' => 'Permiso por matrimonio', 'requiere_sustento' => true, 'max_dias' => 5],
            ['nombre' => 'Permiso por paternidad', 'requiere_sustento' => true, 'max_dias' => 10],
            ['nombre' => 'Permiso por maternidad', 'requiere_sustento' => true, 'max_dias' => 98],
            ['nombre' => 'Permiso particular', 'requiere_sustento' => false, 'max_dias' => 1],
        ];

        foreach ($tiposPermiso as $tipo) {
            TipoPermiso::create($tipo);
        }

        // Reglas de cálculo
        $reglasCalculo = [
            [
                'nombre' => 'Cálculo de CTS',
                'formula' => 'sueldo_base * 1.1667',
                'descripcion' => 'Cálculo estándar de CTS'
            ],
            [
                'nombre' => 'Cálculo de Gratificación',
                'formula' => 'sueldo_base + bonificacion_9p',
                'descripcion' => 'Gratificación con bonificación extraordinaria'
            ],
            [
                'nombre' => 'Cálculo de Vacaciones',
                'formula' => 'sueldo_base / 30 * dias_vacaciones',
                'descripcion' => 'Cálculo de vacaciones proporcional'
            ],
        ];

        foreach ($reglasCalculo as $regla) {
            ReglaCalculo::create($regla);
        }
    }
}
