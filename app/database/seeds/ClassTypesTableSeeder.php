<?php

class ClassTypesTableSeeder extends Seeder {

	public function run()
	{
		$classType = ClassType::create([
			'name' => 'Wellness'
		]);

		$classType = ClassType::create([
			'name' => 'Fitness'
		]);

		$classType = ClassType::create([
			'name' => 'Body Conditioning'
		]);

		$classType = ClassType::create([
			'name' => 'Dance'
		]);
	}

}