<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CertificadoPlantilla;

class CertificadoPlantillasSeeder extends Seeder
{
    public function run()
    {
        $plantillas = [
            [
                'nombre' => 'Certificado Laboral Estándar',
                'tipo_certificado' => 'laboral',
                'contenido_html' => $this->getPlantillaLaboral(),
                'variables_requeridas' => [
                    'empleado_nombre_completo',
                    'empleado_dni',
                    'empleado_cargo',
                    'empleado_fecha_ingreso'
                ],
                'configuracion' => [
                    'formato' => 'A4',
                    'orientacion' => 'portrait',
                    'margenes' => [
                        'top' => '2.5cm',
                        'right' => '2.5cm',
                        'bottom' => '2.5cm',
                        'left' => '2.5cm'
                    ]
                ],
                'activo' => true
            ],
            [
                'nombre' => 'Certificado de Trabajo Detallado',
                'tipo_certificado' => 'trabajo',
                'contenido_html' => $this->getPlantillaTrabajo(),
                'variables_requeridas' => [
                    'empleado_nombre_completo',
                    'empleado_dni',
                    'empleado_cargo',
                    'empleado_fecha_ingreso',
                    'empleado_sueldo',
                    'empleado_area'
                ],
                'configuracion' => [
                    'formato' => 'A4',
                    'orientacion' => 'portrait',
                    'margenes' => [
                        'top' => '2.5cm',
                        'right' => '2.5cm',
                        'bottom' => '2.5cm',
                        'left' => '2.5cm'
                    ]
                ],
                'activo' => true
            ],
            [
                'nombre' => 'Certificado de Remuneraciones',
                'tipo_certificado' => 'remuneraciones',
                'contenido_html' => $this->getPlantillaRemuneraciones(),
                'variables_requeridas' => [
                    'empleado_nombre_completo',
                    'empleado_dni',
                    'empleado_cargo',
                    'empleado_sueldo',
                    'periodo_inicio',
                    'periodo_fin'
                ],
                'configuracion' => [
                    'formato' => 'A4',
                    'orientacion' => 'landscape',
                    'margenes' => [
                        'top' => '2cm',
                        'right' => '2cm',
                        'bottom' => '2cm',
                        'left' => '2cm'
                    ]
                ],
                'activo' => true
            ]
        ];

        foreach ($plantillas as $plantilla) {
            CertificadoPlantilla::create($plantilla);
        }
    }

    protected function getPlantillaLaboral()
    {
        return '
        <div class="certificado">
            <div class="header">
                <img src="{logo_empresa}" alt="Logo">
                <h1>{empresa_nombre}</h1>
            </div>
            
            <div class="contenido">
                <h2>CERTIFICADO LABORAL</h2>
                
                <p>
                    Por medio de la presente, certificamos que el/la Sr(a). <strong>{empleado_nombre_completo}</strong>,
                    identificado(a) con DNI N° <strong>{empleado_dni}</strong>, labora en nuestra empresa desde el
                    <strong>{empleado_fecha_ingreso}</strong>, desempeñando el cargo de <strong>{empleado_cargo}</strong>.
                </p>
                
                <p>
                    Se expide el presente certificado a solicitud del interesado para los fines que estime conveniente.
                </p>
                
                <p class="fecha">
                    Lima, {dia_actual} de {mes_actual} de {año_actual}
                </p>
            </div>
            
            <div class="firma">
                <p>_______________________</p>
                <p>Gerente de Recursos Humanos</p>
                <p>{empresa_nombre}</p>
            </div>
            
            {qr_code}
        </div>';
    }

    protected function getPlantillaTrabajo()
    {
        return '
        <div class="certificado">
            <div class="header">
                <img src="{logo_empresa}" alt="Logo">
                <h1>{empresa_nombre}</h1>
                <p>RUC: {empresa_ruc}</p>
            </div>
            
            <div class="contenido">
                <h2>CERTIFICADO DE TRABAJO</h2>
                
                <p>
                    Por medio del presente documento certificamos que el/la Sr(a). <strong>{empleado_nombre_completo}</strong>,
                    identificado(a) con DNI N° <strong>{empleado_dni}</strong>, ha laborado en nuestra empresa desde el
                    <strong>{empleado_fecha_ingreso}</strong> hasta la actualidad, desempeñando el cargo de 
                    <strong>{empleado_cargo}</strong> en el área de <strong>{empleado_area}</strong>.
                </p>
                
                <p>
                    Durante su permanencia ha demostrado responsabilidad, puntualidad y eficiencia en las labores encomendadas.
                </p>
                
                <p>
                    Se expide el presente certificado a solicitud del interesado para los fines que estime conveniente.
                </p>
                
                <p class="fecha">
                    Lima, {dia_actual} de {mes_actual} de {año_actual}
                </p>
            </div>
            
            <div class="firmas">
                <div class="firma">
                    <p>_______________________</p>
                    <p>Gerente de Recursos Humanos</p>
                </div>
                <div class="firma">
                    <p>_______________________</p>
                    <p>Gerente General</p>
                </div>
            </div>
            
            {qr_code}
        </div>';
    }

    protected function getPlantillaRemuneraciones()
    {
        return '
        <div class="certificado">
            <div class="header">
                <img src="{logo_empresa}" alt="Logo">
                <h1>{empresa_nombre}</h1>
                <p>RUC: {empresa_ruc}</p>
            </div>
            
            <div class="contenido">
                <h2>CERTIFICADO DE REMUNERACIONES</h2>
                
                <p>
                    Por medio del presente documento certificamos que el/la Sr(a). <strong>{empleado_nombre_completo}</strong>,
                    identificado(a) con DNI N° <strong>{empleado_dni}</strong>, quien labora en nuestra empresa
                    desempeñando el cargo de <strong>{empleado_cargo}</strong>, percibe una remuneración mensual de
                    S/ <strong>{empleado_sueldo}</strong> (Son: {empleado_sueldo_letras}).
                </p>
                
                <p>
                    Este certificado corresponde al periodo comprendido entre {periodo_inicio} y {periodo_fin}.
                </p>
                
                <p>
                    Se expide el presente certificado a solicitud del interesado para los fines que estime conveniente.
                </p>
                
                <p class="fecha">
                    Lima, {dia_actual} de {mes_actual} de {año_actual}
                </p>
            </div>
            
            <div class="firmas">
                <div class="firma">
                    <p>_______________________</p>
                    <p>Gerente de Recursos Humanos</p>
                </div>
                <div class="firma">
                    <p>_______________________</p>
                    <p>Jefe de Remuneraciones</p>
                </div>
            </div>
            
            {qr_code}
            
            <div class="verificacion">
                <p>Este documento puede ser verificado ingresando el código QR o visitando:</p>
                <p>{url_verificacion}</p>
            </div>
        </div>';
    }
}
