<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert(
                array(
                    0 =>
                    array(
                        'id' => 1,
                        'name' => 'admin',
                        'email' => 'admin@admin.com',
                        'password' => bcrypt(123456),
                        'phone' => 01000000000,
                        'role_id' => 1,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    1 =>
                    array(
                        'id' => 2,
                        'name' => 'moder',
                        'email' => 'moder@moder.com',
                        'password' => bcrypt(123456),
                        'phone' => 01110000000,
                        'role_id' => 2,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    2 =>
                    array(
                        'id' => 3,
                        'name' => 'user',
                        'email' => 'user@user.com',
                        'password' => bcrypt(123456),
                        'phone' => 01220000000,
                        'role_id' => 3,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
        ));
    }             
}
