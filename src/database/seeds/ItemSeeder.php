<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_category1')->insert([
        	'name'				=> 'LAPTOP',
        	'created_at'		=> CARBON::now()->format('Y-m-d H:i:s'),
        	'updated_at'		=> CARBON::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('item_category2')->insert([
        	'name'				=> 'ASUS',
        	'created_at'		=> CARBON::now()->format('Y-m-d H:i:s'),
        	'updated_at'		=> CARBON::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('item')->insert([
        	'item_category1'	=> '1',
        	'item_category2'	=> '1',
        	'name'				=> 'X441SA',
        	'purchase_price'	=> '3000000',
        	'selling_price'		=> '3500000',
        	'created_at'		=> CARBON::now()->format('Y-m-d H:i:s'),
        	'updated_at'		=> CARBON::now()->format('Y-m-d H:i:s')
        ]);

         DB::table('item')->insert([
            'item_category1'    => '1',
            'item_category2'    => '1',
            'name'              => 'X441UA',
            'purchase_price'    => '3100000',
            'selling_price'     => '3600000',
            'created_at'        => CARBON::now()->format('Y-m-d H:i:s'),
            'updated_at'        => CARBON::now()->format('Y-m-d H:i:s')
        ]);

          DB::table('item')->insert([
            'item_category1'    => '1',
            'item_category2'    => '1',
            'name'              => 'X441XA',
            'purchase_price'    => '3200000',
            'selling_price'     => '3700000',
            'created_at'        => CARBON::now()->format('Y-m-d H:i:s'),
            'updated_at'        => CARBON::now()->format('Y-m-d H:i:s')
        ]);

    }
}
