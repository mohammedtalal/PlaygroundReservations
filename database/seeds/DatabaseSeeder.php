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
        // $this->call(UsersTableSeeder::class);
        $this->define(App\User::class, function (Faker\Generator $faker) {
		    static $password;

		    $user1 = [
		        'name' => 'admin',
		        'email' => 'admin@admin.com',
		        'password' => bcrypt(123456),
		        'remember_token' => str_random(10),
		    ];

		    $user2 = [
		        'name' => 'moderator',
		        'email' => 'moder@moder.com',
		        'password' => bcrypt(123456),
		        'remember_token' => str_random(10),
		    ];

		    $user3 = [
		        'name' => 'user',
		        'email' => 'user@user.com',
		        'password' => bcrypt(123456),
		        'remember_token' => str_random(10),
		    ];

		});

		$this->define(App\Role::class, function (Faker\Generator $faker) {
		    static $password;

		    $role = [
		        'name' => 'admin',
		    ];

		    $role2 = [
		        'name' => 'moderator',
		    ];

		    $role3 = [
		        'name' => 'user',
		    ];

		});
    }
}
