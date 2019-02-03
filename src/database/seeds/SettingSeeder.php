<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('settings')->insert([
        'id_courier' 	        => '3',
        'lat_start'             => '-7.5308914',
        'lng_start'             => '110.73143',
        'watcher_view_update'   => '5',
        'courier_location_update'=> '30',
        'default_send_cost'     => '10000',
        'created_at' 	        => Carbon::now()->format('Y-m-d H:i:s'),
        'updated_at' 	        => Carbon::now()->format('Y-m-d H:i:s')
    ]);
   }
}
