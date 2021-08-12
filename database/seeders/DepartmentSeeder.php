<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('departments')->insert(
            [
                'id'=>1,
                'code' => 'GEA',
                'name' => 'GEA',
                'active'=>'1',
                'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')				
            ]);
    }
}
