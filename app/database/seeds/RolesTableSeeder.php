<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{
		$role = Role::create([
			'id' 	=> 1,
			'name' 	=> 'Client'
		]);

		$role = Role::create([
			'id' 	=> 2,
			'name' 	=> 'Instructor'
		]);

		$role = Role::create([
			'id' 	=> 3,
			'name' 	=> 'Admin'
		]);
	}

}