<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call([
    		UsersTableSeeder::class,
    		CustomerTypeSeeder::class,
    		RolesTableSeeder::class,
    		PermissionTableSeeder::class,
    		ModelHasRolesTableSeeder::class,
    		RolesHasPermissionTableSeeder::class,
            SupplierSeeder::class,
            CustomerSeeder::class,
            ItemSeeder::class,
            SettingSeeder::class,
    	]);
    }
}
