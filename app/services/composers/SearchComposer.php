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

		// $classTypes = $this->classType->all();

		// if( $classTypes )
		// {
		// 	foreach($classTypes as $classType)
		// 	{
		// 		$return[] = $classType->name;
		// 	}
		// }

		// $view->with('classTypes', $return);

		$activities = $this->activity->all();

		if( $activities )
		{
			foreach($activities as $activity)
			{
				$return[] = $activity->name;
			}
		}

		$view->with('activities', $return);
	}

}