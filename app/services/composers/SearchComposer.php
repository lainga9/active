<?php namespace Services\Composers;

use ClassType;
use Activity;

class SearchComposer {

	protected $classType;
	protected $activity;

	public function __construct(ClassType $classType, Activity $activity)
	{
		$this->classType 	= $classType;
		$this->activity 	= $activity;
	}

	public function compose($view)
	{
		$return = [];

		$activities = $this->activity->all();

		if( $activities )
		{
			foreach($activities as $activity)
			{
				$return[] = $activity->name;
			}
		}

		$classTypes = $this->classType->all();

		$data = [
			'activities' 	=> $return,
			'classTypes'	=> $classTypes
		];

		$view->with($data);
	}

}