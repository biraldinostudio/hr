<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(
            [
                'id'=>'1',
                'site_id'=>'1',
                'poh_id'=>'1',
                'position_id'=>'1',
                'nrp'=>'1382263',
                'ktp'=>'2384726371829384',
                'name' => 'Administrator',
                'email' => 'kayetanus.biraldino@gmail.com',
                'password' => Hash::make('123'),
                'join_date'=>'2021-01-01',
                'religion'=>'Katolik',
                'staff'=>'1',
                'employee'=>'0',
				'phone'=>'081952431678',
                'lumpsum'=>'0',
                'lumpsum_status'=>'0',
                'level'=>'administrator',
                'active'=>'1',
                'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
            ]);
    }
}
