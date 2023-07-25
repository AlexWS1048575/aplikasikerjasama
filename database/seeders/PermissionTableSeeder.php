<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
           'role-create',
           'role-read',
           'role-update',
           'role-delete',
           'organization-create',
           'organization-read',
           'organization-update',
           'organization-delete',
           'corporation-create',
           'corporation-read',
           'corporation-update',
           'corporation-delete',
           'wish-create',
           'wish-read',
           'wish-update',
           'wish-delete',
           'user-create',
           'user-read',
           'user-update',
           'user-delete',
        ];
        
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
