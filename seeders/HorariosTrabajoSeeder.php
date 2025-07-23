<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HorariosTrabajoSeeder extends Seeder
{
    public function run(): void
    {
        $horarios = [
            [
                'id' => Str::uuid(),
                'nombre' => 'Horario Administrativo',
                'descripcion' => 'Horario estandar para personal administrativo',
                'hora_entrada' => '08:00:00',
                'hora_salida' => '17:00:00',
                'inicio_refrigerio' => '12:00:00',
                'fin_refrigerio' => '13:00:00',
                'minutos_tolerancia_entrada' => 15,
                'minutos_tolerancia_salida' => 15,
                'horas_laborales_dia' => 8,
                'dias_laborales' => json_encode(['lunes', 'martes', 'miercoles', 'jueves', 'viernes']),
                'sabado_medio_dia' => false,
                'sabado_hora_salida' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Horario Operativo Mañana',
                'descripcion' => 'Turno mañana para personal operativo',
                'hora_entrada' => '07:00:00',
                'hora_salida' => '15:00:00',
                'inicio_refrigerio' => '11:00:00',
                'fin_refrigerio' => '11:30:00',
                'minutos_tolerancia_entrada' => 10,
                'minutos_tolerancia_salida' => 10,
                'horas_laborales_dia' => 8,
                'dias_laborales' => json_encode(['lunes', 'martes', 'miercoles', 'jueves', 'viernes']),
                'sabado_medio_dia' => true,
                'sabado_hora_salida' => '12:00:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Horario Operativo Tarde',
                'descripcion' => 'Turno tarde para personal operativo',
                'hora_entrada' => '15:00:00',
                'hora_salida' => '23:00:00',
                'inicio_refrigerio' => '19:00:00',
                'fin_refrigerio' => '19:30:00',
                'minutos_tolerancia_entrada' => 10,
                'minutos_tolerancia_salida' => 10,
                'horas_laborales_dia' => 8,
                'dias_laborales' => json_encode(['lunes', 'martes', 'miercoles', 'jueves', 'viernes']),
                'sabado_medio_dia' => false,
                'sabado_hora_salida' => null,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nombre' => 'Horario Ventas',
                'descripcion' => 'Horario para personal de ventas',
                'hora_entrada' => '09:00:00',
                'hora_salida' => '18:00:00',
                'inicio_refrigerio' => '13:00:00',
                'fin_refrigerio' => '14:00:00',
                'minutos_tolerancia_entrada' => 20,
                'minutos_tolerancia_salida' => 20,
                'horas_laborales_dia' => 8,
                'dias_laborales' => json_encode(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado']),
                'sabado_medio_dia' => true,
                'sabado_hora_salida' => '13:00:00',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('horarios_trabajo')->insert($horarios);
    }
}