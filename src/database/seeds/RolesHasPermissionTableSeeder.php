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
        $pimpinans = [
            '1','2','3','4','5',
        ];
        foreach ($pimpinans as $pimpinan) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $pimpinan,
                'role_id' => '2',
            ]);
        }

        $admins = [
            '3','4','5',
        ];
        foreach ($admins as $admin) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $admin,
                'role_id' => '1',
            ]);
        }
    }
}
