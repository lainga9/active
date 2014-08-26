<?php

class UserTypesTableSeeder extends Seeder {

	public function run()
	{
		$userType = UserType::create([
			'name'	=> 'Individual'
		]);

		$userType = UserType::create([
			'name'	=> 'Organisation'
		]);
	}

}