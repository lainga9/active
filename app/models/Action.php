<?php

class Action extends \Eloquent {
	protected $guarded = [];

	public function User()
	{
		return $this->belongsTo('User');
	}

	public function ActionObject()
	{
		return $this->hasOne('ActionObject');
	}

	public function output()
	{
		$object = $this->actionObject->object;
		return 	$this->user->first_name . ' ' . $this->user->last_name . ' ' .
				$this->actionObject->actionChange->verb . ' ' .
				$object::find($this->actionObject->actionChange->actor_id)->first_name . '';
	}

	public function getComponents()
	{
		$object = $this->actionObject->object;
		$object = $object::find($this->actionObject->actionChange->actor_id);

		return [
			'subject' 	=> $this->user,
			'verb'		=> $this->actionObject->actionChange->verb,
			'object'	=> $object
		];
	}

	public function getSubjectName()
	{
		return $this->user->first_name . ' ' . $this->user->last_name;
	}

	public function getSubjectLink()
	{
		return URL::route('users.show', $this->user->id);
	}

	public function getVerb()
	{
		return $this->actionObject->actionChange->verb;
	}

	public function getObjectName()
	{
		$type 	= $this->actionObject->object;
		$object = $type::find($this->actionObject->actionChange->actor_id);

		switch($type)
		{
			case('User') :
				$name = $object->first_name . ' ' . $object->last_name;
				break;

			case('Activity') :
				$name = $object->name;
				break;
		}

		return $name;
	}

	public function getObjectLink()
	{
		$type 	= $this->actionObject->object;
		$object = $type::find($this->actionObject->actionChange->actor_id);

		switch($type)
		{
			case('User') :
				$link = URL::route('users.show', $object->id);
				break;

			case('Activity') :
				$link = URL::route('activities.show', $object->id);
				break;
		}

		return $link;
	}
}