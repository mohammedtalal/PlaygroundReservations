<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slots')->delete();
        
        DB::table('slots')->insert(
                array(
                    0 =>
                    array(
                        'id' => 1,
                        'from' => 12,
                        'to' => 1,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    1 =>
                    array(
                        'id' => 2,
                        'from' => 1,
                        'to' => 2,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    2 =>
                    array(
                        'id' => 3,
                        'from' => 2,
                        'to' => 3,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    3 =>
                    array(
                        'id' => 4,
                        'from' => 3,
                        'to' => 4,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    4 =>
                    array(
                        'id' => 5,
                        'from' => 4,
                        'to' => 5,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    5 =>
                    array(
                        'id' => 6,
                        'from' => 5,
                        'to' => 6,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    6 =>
                    array(
                        'id' => 7,
                        'from' => 6,
                        'to' => 7,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    7 =>
                    array(
                        'id' => 8,
                        'from' => 7,
                        'to' => 8,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    8 =>
                    array(
                        'id' => 9,
                        'from' => 8,
                        'to' => 9,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    9 =>
                    array(
                        'id' => 10,
                        'from' => 9,
                        'to' => 10,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    10 =>
                    array(
                        'id' => 11,
                        'from' => 10,
                        'to' => 11,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    11 =>
                    array(
                        'id' => 12,
                        'from' => 11,
                        'to' => 12,
                        'status' => 'am',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    12 =>
                    array(
                        'id' => 13,
                        'from' => 12,
                        'to' => 1,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    13 =>
                    array(
                        'id' => 14,
                        'from' => 1,
                        'to' => 2,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    14 =>
                    array(
                        'id' => 15,
                        'from' => 2,
                        'to' => 3,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    15 =>
                    array(
                        'id' => 16,
                        'from' => 3,
                        'to' => 4,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    16 =>
                    array(
                        'id' => 17,
                        'from' => 4,
                        'to' => 5,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    17 =>
                    array(
                        'id' => 18,
                        'from' => 5,
                        'to' => 6,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    18 =>
                    array(
                        'id' => 19,
                        'from' => 6,
                        'to' => 7,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    19 =>
                    array(
                        'id' => 20,
                        'from' => 7,
                        'to' => 8,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    20 =>
                    array(
                        'id' => 21,
                        'from' => 8,
                        'to' => 9,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    21 =>
                    array(
                        'id' => 22,
                        'from' => 9,
                        'to' => 10,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    22 =>
                    array(
                        'id' => 23,
                        'from' => 10,
                        'to' => 11,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    23 =>
                    array(
                        'id' => 24,
                        'from' => 11,
                        'to' => 12,
                        'status' => 'pm',
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
        ));
    }
}
