<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CorporationType;

class CorporationTypeSeeder extends Seeder
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
                'name' => 'Dalam Negeri',
            ],
            [
                'name' => 'Luar Negeri',
            ],
        ];
        CorporationType::insert($data);
    }
}
