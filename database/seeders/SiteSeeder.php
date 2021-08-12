<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('sites')->insert([
            'id'=>1,
            'code' => 'TCM',
            'name' => 'PT Turbaindo Coal Mining',
            'active'=>'1',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')			
        ]);
    }
}
