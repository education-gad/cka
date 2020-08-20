<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('users')->insert([
			'first_name' => 'Sabbir',
			'last_name' => 'Ahmed',
			'name' => str_random(10),
			'email' => 'admin@gmail.com',
			'password' => bcrypt('123456'),
		]);

	}
}
