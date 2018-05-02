<?php


use Illuminate\Database\Eloquent\Faker as factory;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(UsersSeeder::class);
    	$this->call(RolesSeeder::class);
    	$this->call(PlaygroundSeeder::class);
    	$this->call(SlotsSeeder::class);
    }
}
