<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table('menus')->insert([
			'name' => 'catalog',
			'order' => 1,
			'visible' => 1,
		]);

		DB::table('menus')->insert([
			'name' => 'sales',
			'order' => 2,
			'visible' => 1,
		]);

		DB::table('menus')->insert([
			'name' => 'purchases',
			'order' => 3,
			'visible' => 1,
		]);
	}
}
