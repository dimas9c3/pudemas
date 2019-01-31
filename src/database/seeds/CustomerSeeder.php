<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
        	'customer_type'	=> '1',
            'name' 			=> 'Amir',
            'email'			=> 'dimas9c3@gmail.com',
            'phone'			=> '082112311234',
            'address'		=> 'Solo',
            'created_at' 	=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' 	=> Carbon::now()->format('Y-m-d H:i:s')
        ]);

         DB::table('customer')->insert([
            'customer_type' => '1',
            'name'          => 'Budi',
            'email'         => 'dimas.visualb@gmail.com',
            'phone'         => '083112311234',
            'address'       => 'Solo',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
