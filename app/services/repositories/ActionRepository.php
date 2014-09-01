<?php namespace Services\Repositories;

use Action;
use ActionObject;
use ActionChange;

class ActionRepository {

	protected $action;
	protected $actionObject;
	protected $actionChange;

	public function __construct(Action $action, ActionObject $actionObject, ActionChange $actionChange)
	{
		$this->action 		= $action;
		$this->actionObject	= $actionObject;
		$this->actionChange	= $actionChange;
	}

	public function create($subject, $verb, $object, $type)
	{
		$action = $this->action->create([
			'user_id'	=> $subject->id
		]);

		if( !$action )
		{
			throw new Exception('Error creating action');
		}

		$actionObject = $this->actionObject->create([
			'action_id'	=> $action->id,
			'object'	=> $type
		]);

		if( !$actionObject )
		{
			throw new Exception('Error creating action object');
		}

		$actionChange = $this->actionChange->create([
			'action_object_id'	=> $actionObject->id,
			'verb'				=> $verb,
			'actor_id'			=> $object->id
		]);

		if( !$actionChange )
		{
			throw new Exception('Error creating action change');
		}

		return true;
	}

}