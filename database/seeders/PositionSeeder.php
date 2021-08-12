<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('positions')->insert(
            [
                'id'=>1,
                'department_id'=>1,
                'name' => 'HR ADMINISTRATOR',
                'active'=>'1',
                'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')				
            ]);
    }
}
