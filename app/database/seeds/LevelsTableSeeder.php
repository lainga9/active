<?php

class LevelsTableSeeder extends Seeder {

	public function run()
	{
		$level = Level::create([
			'name' => 'Beginner'
		]);

		$level = Level::create([
			'name' => 'Intermediate'
		]);

		$level = Level::create([
			'name' => 'Advanced'
		]);

		$level = Level::create([
			'name' => 'Expert'
		]);

		$level = Level::create([
			'name' => 'All Levels'
		]);
	}

}