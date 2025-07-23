<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipoContratoSeeder::class,
            FrecuenciaPagoSeeder::class,
            SituacionLaboralSeeder::class,
            RegimenPensionarioSeeder::class,
            NivelEducativoSeeder::class,
            EstadoCivilSeeder::class,
            TipoDocumentoSeeder::class,
            BancoSeeder::class,
            DepartamentoSeeder::class,
            CargoSeeder::class,
            EmpleadoSeeder::class,
            ConceptoPlanillaSeeder::class, 
            ConfiguracionPlanillaSeeder::class,
        ]);
    }
}
