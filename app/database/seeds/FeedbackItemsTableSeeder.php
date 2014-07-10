<?php

class FeedbackItemsTableSeeder extends Seeder {

	public function run()
	{
		$feedbackItem = FeedbackItem::create([
			'id' => 1,
			'name' => 'Enthusiasm and motivation'
		]);

		$feedbackItem = FeedbackItem::create([
			'id' => 2,
			'name' => 'Instruction and technique'
		]);

		$feedbackItem = FeedbackItem::create([
			'id' => 3,
			'name' => 'Was the class taught to the level as advertised?'
		]);

		$feedbackItem = FeedbackItem::create([
			'id' => 4,
			'name' => 'Overall Satisfaction'
		]);
	}

}