<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        
        DB::table('roles')->insert(
                array(
                    0 =>
                    array(
                        'id' => 1,
                        'name' => 'admin',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    1 =>
                    array(
                        'id' => 2,
                        'name' => 'moder',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    2 =>
                    array(
                        'id' => 3,
                        'name' => 'user',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
            ));
    }
}
