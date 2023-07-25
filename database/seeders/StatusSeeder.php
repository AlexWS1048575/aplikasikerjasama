<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
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
                'name' => 'Pending',
            ],
            [
                'name' => 'In Progress',
            ],
            [
                'name' => 'Approved',
            ],
        ];
        Status::insert($data);
    }
}
