<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    public function run()
    {
        // Membuat 10 data pendaftaran mahasiswa menggunakan factory
        Enrollment::factory(10)->create();
    }
}
