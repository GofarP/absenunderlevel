<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        Jabatan::factory()->create([
            'nama' => 'Administrator',
        ]);

        Karyawan::factory()->create([
            'users_id'=>1,
            'jabatan_id'=>1,
            'cabang_id'=>null,
            'shift_id'=>null,
            'gaji_pokok'=>0,
            'lembur'=>0
        ]);
    }
}
