<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ThirdAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Other', 
            'email' => 'other@gmail.com',
            'password' => bcrypt('other65535'),
            'phone' => '081234081234',
        ]);
        
        $role = Role::create(['name' => 'Other']);
         
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::whereBetween('id', ['13', '16'])->pluck('id', 'id');
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}
