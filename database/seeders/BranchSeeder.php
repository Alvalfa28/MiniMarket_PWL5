<?php

namespace Database\Seeders;

use App\Models\BranchModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // BranchModel::create([
        //     'id_cabang' => 'pst',
        //     'nama_cabang' => 'Pusat JayuSmart',
        //     'alias'=>'Pusat',
        //     'telepon' => '087391273441',
        //     'alamat' => 'Jalan Siliwangi No.8, Cianjur Kota',
        // ]);


        for ($i = 1; $i <= 5; $i++) {
            BranchModel::create([
                'id_cabang' => 'cb' . $i,
                'nama_cabang' => $faker->company,
                'alias'=>'Cabang ' . $i,
                'telepon' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);
        }
    }
}
