<?php

use Illuminate\Database\Seeder;

class RolesHasPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1;$i<=8;$i++) {
        DB::table('role_has_permissions')->insert([
            'permission_id' => $i,
            'role_id' => '1',
        ]);
        }
    }
}
