<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class SecondAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'User', 
            'email' => 'user@gmail.com',
            'password' => bcrypt('user67890'),
            'phone' => '089876543210',
        ]);
        
        $role = Role::create(['name' => 'User']);
         
        // $permissions = Permission::pluck('id','id')->all();
        $permissions = Permission::whereBetween('id', ['13', '16'])->pluck('id', 'id');
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}