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

	// Returns the object of the action. So if the action is someone booked into an activity, this will return the activity. If someone follows a user, this will return the user.
	public function getObject()
	{
		$type 	= $this->actionObject->object;
		$object = $type::find($this->actionObject->actionChange->actor_id);

		return $object;
	}

	public function getObjectType()
	{
		return strtolower(get_class(self::getObject()));
	}

	public function getSubjectName()
	{
		if( $this->user->id == Auth::user()->id ) return 'You';

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
		$object = self::getObject();

		switch(get_class($object))
		{
			case('User') :
				if( $object->id == Auth::user()->id )
				{
					$name = 'You';
				}
				else
				{
					$name = $object->first_name . ' ' . $object->last_name;
				}
				break;

			case('Activity') :
				$name = $object->name;
				break;
		}

		return $name;
	}

	public function getActor()
	{
		return $this->actionObject->actionChange->user;
	}

	public function getObjectLink()
	{
		$object = self::getObject();

		switch(get_class($object))
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

	public function getTemplate()
	{
		$object = self::getObject();

		switch(get_class($object)) 
		{
			case('User') :
				$template = '_partials.users.excerpt';
				break;

			case('Activity') :
				$template = '_partials.client.activity';
				break;
		}

		return $template;
	}
}