<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run()
    {
        $banks = [
            [
                'name' => 'Banco de Crédito del Perú',
                'short_name' => 'BCP',
                'code' => '002',
                'swift_code' => 'BCPLPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco Continental',
                'short_name' => 'BBVA',
                'code' => '011',
                'swift_code' => 'BCONPELP',
                'is_active' => true
            ],
            [
                'name' => 'Scotiabank Perú',
                'short_name' => 'Scotiabank',
                'code' => '009',
                'swift_code' => 'SCBLPELP',
                'is_active' => true
            ],
            [
                'name' => 'Interbank',
                'short_name' => 'Interbank',
                'code' => '003',
                'swift_code' => 'INTNPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco de la Nación',
                'short_name' => 'BN',
                'code' => '018',
                'swift_code' => 'NACIPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco Falabella Perú',
                'short_name' => 'Falabella',
                'code' => '801',
                'swift_code' => 'FALAPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco Pichincha',
                'short_name' => 'Pichincha',
                'code' => '055',
                'swift_code' => 'PIPCPELP',
                'is_active' => true
            ],
            [
                'name' => 'Mibanco',
                'short_name' => 'Mibanco',
                'code' => '053',
                'swift_code' => 'MIBKPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco Santander Perú',
                'short_name' => 'Santander',
                'code' => '056',
                'swift_code' => 'BSCHPELP',
                'is_active' => true
            ],
            [
                'name' => 'Banco GNB',
                'short_name' => 'GNB',
                'code' => '054',
                'swift_code' => 'GANAPELP',
                'is_active' => true
            ]
        ];

        foreach ($banks as $bank) {
            Bank::firstOrCreate(
                ['code' => $bank['code']],
                $bank
            );
        }
    }
}