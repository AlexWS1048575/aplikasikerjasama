<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Pemerintah',
            ],
            [
                'name' => 'Pendidikan',
            ],
            [
                'name' => 'Bisnis',
            ],
            [
                'name' => 'Lainnya',
            ],
        ];
        Type::insert($data);
    }
}
