<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	DB::table('supplier')->insert([
            'name' 			=> 'Andalas',
            'email'			=> 'andalas@gmail.com',
            'phone'			=> '082112311234',
            'address'		=> 'Solo',
            'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('supplier')->insert([
            'name'          => 'Platinum',
            'email'         => 'platinum@gmail.com',
            'phone'         => '083112311234',
            'address'       => 'Solo',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
