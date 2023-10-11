<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::insert([
            [
                'nama' => 'Teknologi & Logistik',
                'kode' => 'TEKLOG'

            ],
            [
                'nama' => 'Wilayah 2',
                'kode' => 'WIL2'
            ]
        ]);
    }
}
