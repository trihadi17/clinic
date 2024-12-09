<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'national_id' => '14711121',
                'name' => 'Trihadi Putra',
                'gender' => 'Male',
                'date_of_birth' => date('2024-05-12'),
                'phone_number' => '0812345',
                'address' => 'Jalan Serayu, Pekanbaru',
                'created_at' => now(),
            ],
            [
                'national_id' => '14711122',
                'name' => 'Lili Sentosa',
                'gender' => 'Female',
                'date_of_birth' => date('2024-07-01'),
                'phone_number' => '0852987',
                'address' => 'Jalan Melayu, Malaysia',
                'created_at' => now(),
            ],
        ];

        Patient::insert($data);
    }
}
