<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'practice_license' => 'SIP/123/456',
                'name' => 'Fany Cynthia',
                'phone_number' => '081245622',
                'address' => 'Jalan Kartini, Mojokerto',
                'specialty_id' => 1,
            ],
            [
                'practice_license' => 'SIP/123/457',
                'name' => 'Darko Sugoro',
                'phone_number' => '081245622',
                'address' => 'Jalan Sudirman, Jakarta',
                'specialty_id' => 2,
            ],
        ];

        Doctor::insert($data);
    }
}
