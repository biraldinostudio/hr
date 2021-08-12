<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PohSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pohs')->insert(
            [
                'id'=>1,
                'name' => 'HEAD OFFICE',
				'active'=>'1',
                'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')				
            ]);
    }
}
