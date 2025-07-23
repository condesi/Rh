<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRol = DB::table('roles')->where('nombre', 'Super Administrador')->first();
        
        $usuario = [
            'id' => Str::uuid(),
            'name' => 'Administrador Sistema',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
            'tipo_usuario' => 'admin',
            'activo' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('users')->insert($usuario);
    }
}