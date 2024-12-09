<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'specialty_name' => 'Dokter Umum',
                'created_at' => now(),
            ],
            [
                'specialty_name' => 'Dokter Anak',
                'created_at' => now(),
            ],
            [
                'specialty_name' => 'Dokter Kulit',
                'created_at' => now(),
            ],
        ];

        Specialty::insert($data);
    }
}
