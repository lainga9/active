<?php namespace Services\Composer;

use ClassType;

class ClassTypeFormComposer {

	protected $classType;

	public function __construct(ClassType $classType)
	{
		$this->classType = $classType;
	}

	public function compose($view)
	{
		$classTypes = $this->classType->all();

		$view->with(compact('classTypes'));
	}

}