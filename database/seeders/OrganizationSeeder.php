<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // contoh data instansi, boleh dihapus jika tidak diperlukan
        $data = [
            [
                'name' => 'Sekretariat Daerah',
                'email' => 'null@gmail.com',
                'address' => 'Null',
                'phone' => '081234567890',
                'headofstate' => 'Unknown',
                'pic' => 'Unknown',
                'created_by' => '1',
                'updated_by' => '1',
            ],
        ];
        Organization::insert($data);
    }
}
