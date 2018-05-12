<?php

use Illuminate\Database\Seeder;

class PlaygroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('playgrounds')->delete();
        
        DB::table('playgrounds')->insert(
                array(
                    0 =>
                    array(
                        'id' => 1,
                        'name' => 'leagua',
                        'details' => 'lorem ipsum bla bla details',
                        'address' => '25 asmaa fahmy elnozha',
                        'image' => '001.png',
                        'user_id' => 1,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    1 =>
                    array(
                        'id' => 2,
                        'name' => 'ronaldo',
                        'details' => 'lorem ipsum bla bla details',
                        'address' => 'Fesal St, haram',
                        'image' => '002.png',
                        'user_id' => 2,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
                    2 =>
                    array(
                        'id' => 3,
                        'name' => 'salah',
                        'details' => 'lorem ipsum bla bla details',
                        'address' => 'roxy, masr gdeda',
                        'image' => '003.png',
                        'user_id' => 3,
                        'created_at' => '2017-05-22 12:07:12',
                        'updated_at' => '2017-05-22 12:07:12',
                    ),
        ));
    }
}
