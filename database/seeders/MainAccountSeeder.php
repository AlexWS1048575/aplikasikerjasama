<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class MainAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // contoh data untuk role sebagai admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin12345'),
                'role_id' => '1',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // contoh data untuk role sebagai user
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user6789'),
                'role_id' => '2',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        User::insert($data);
    }
}
