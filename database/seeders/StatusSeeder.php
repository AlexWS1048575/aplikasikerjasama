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
                'name' => 'In Progress',
            ],
            [
                'name' => 'Needs Revision',
            ],
            [
                'name' => 'Approved',
            ],
        ];
        Status::insert($data);
    }
}
