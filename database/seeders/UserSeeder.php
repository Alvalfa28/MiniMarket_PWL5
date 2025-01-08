<?php

namespace Database\Seeders;

use App\Models\UserStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $roles = ['owner', 'manager', 'supervisor', 'cashier', 'warehouse'];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $owner = UserStore::create([
            'nama_user' => 'Jayusman',
            'peran' => 'owner', 
            'email' => 'owner@minimarket.com',
            'password' => Hash::make('owner'), 
            'id_cabang' => null, 
        ]);
        $owner->assignRole('owner'); 

        $roleAlias = [
            'manager',
            'supervisor',
            'cashier',
            'warehouse'
        ];

        foreach (range(1, 5) as $branchNumber) {
            $branchId = 'cb' . $branchNumber; 

            foreach ($roleAlias as $role) {
                $user = UserStore::create([
                    'nama_user' => $faker->name, 
                    'peran' => $role,
                    'email' => $role . $branchId . '@minimarket.com',
                    // 'password' => Hash::make($role . $branchId),
                    'password' => Hash::make('password'),
                    'id_cabang' => $branchId,
                ]);
                $user->assignRole($role);
            }
        }
    }
}
