<?php

class Activity extends \Eloquent {
	protected $guarded = [];

	public function scopeFuture($query)
	{
		return $query->where('date', '>=', date('Y-m-d'));
	}

	public function scopePassed($query)
	{
		return $query->where('date', '<', date('Y-m-d'));
	}

	public function ClassTypes()
	{
		return $this->belongsToMany('ClassType');
	}

	public function Instructor()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function Clients()
	{
		return $this->belongsToMany('User');
	}

	public function Level()
	{
		return $this->belongsTo('Level');
	}

	public function Favourites()
	{
		return $this->belongsToMany('User', 'activity_favourite');
	}

	public function isFull()
	{
		return $this->places == 0 ? true : false;
	}

	public function isClosed()
	{
		return $this->closed == 1 ? true : false;
	}

	public function isCancelled()
	{
		return $this->cancelled == 1 ? true : false;
	}

	public function close()
	{
		$this->closed = 1;
		$this->save();

		return $this;
	}

	public function cancel()
	{
		$this->cancelled = 1;
		$this->save();

		return $this;
	}

	public function book($user) 
	{
		$user->attendingActivities()->attach($this->id);
		$this->reducePlaces();

		return $this;
	}

	public function isBookable()
	{
		return !$this->isClosed() && !$this->isFull() && !isAttending();
	}

	public function reducePlaces()
	{
		if( !$this->isFull() )
		{
			$this->places = (int) $this->places - 1;
			$this->save();

			return $this;
		}
		else
		{
			throw new Exception('Sorry, this class is fully booked!');
		}
	}

	public function attachClassTypes($ids)
	{
		if( $this->classTypes )
		{
			foreach($this->classTypes as $classType)
			{
				$this->classTypes()->detach($classType->id);
			}
		}

		if( $ids )
		{
			foreach( $ids as $id )
			{
				$this->classTypes()->attach($id);
			}
		}

		return $this;
	}

	public function isFavourite()
	{
		$favourite = Auth::user()->favourites->contains($this->id) ? true : false;

		if( Request::wantsJSON() )
		{
			return Response::json([
				'favourite' => $favourite
			]);
		}

		return $favourite;
	}

	public function isAttending($user = null)
	{
		$user = $user ? $user : Auth::user();

		$attending = $user->attendingActivities->contains($this->id) ? true : false;

		if( Request::wantsJSON() )
		{
			return Response::json([
				'attending' => $attending
			]);
		}

		return $attending;
	}

	public function createdBy($user = null)
	{
		$user = $user ? $user : Auth::user();

		return $this->user_id == $user->id ? true : false;
	}

	public function isOwn()
	{
		return $this->createdBy();
	}

	public function getStartTime()
	{
		return strtotime($this->date . ' ' . $this->time_from);
	}

	public function getEndTime()
	{
		return strtotime($this->date . ' ' . $this->time_until);
	}

	public function hasPassed()
	{
		$endTime 		= static::getEndTime($this);
		$currentTime 	= strtotime("now");

		return $endTime < $currentTime ? true : false;
	}

	public function makeAddressURL()
	{
		return urlencode($this->street_address) . ',' . urlencode($this->town) . ',' . urlencode($this->postcode);
	}

	public function checkAvailable($activities, $input)
    {
    	// The requested start and finish times for the new activity (in timestmamp form)
    	$requestedStart 	= strtotime($input['date'] . ' ' . $input['time_from']);
    	$requestedFinish 	= strtotime($input['date'] . ' ' . $input['time_until']);

    	// Check for a date clash
    	$activities = $activities->filter(function($activity) use ($requestedStart, $requestedFinish)
    	{
    		// The start and finish times for the current activity in the loop
    		$start 	= $activity->getStartTime();
    		$finish = $activity->getEndTime();
    		
    		// Check if the requested activity starts during the current activity
    		if( $requestedStart >= $start && $requestedStart <= $finish )
    		{
    			return true;
    		}

    		// Check if the current activity starts during the requested activity
    		if( $start >= $requestedStart && $start <= $requestedFinish )
    		{
    			return true;
    		}

    		return false;
    	});

    	return $activities;
    }

    /* Accessors */

    public function getName()
    {
    	return $this->name;
    }

    public function getDescription() 
    {
    	return $this->description;
    }

    public function getLevel()
    {
    	return $this->level ? $this->level->name : 'N/A';
    }

    public function getPlaces()
    {
    	return $this->places;
    }

    public function getPlacesLeft()
    {
    	$places 	= $this->places;
    	$attending 	= count($this->attending);

    	return $places - $attending;
    }

    public function getPrice()
    {
    	return '&pound;' . number_format($this->cost, 2);
    }

    public function getAddress()
    {
    	return $this->street_address . ', ' . $this->town . ', ' . $this->postcode;
    }

    public function getDate()
    {
    	return $this->date;
    }

    public function getTime()
    {
    	return $this->time_from . ' - ' . $this->time_until;
    }

    public function getTypes()
    {
    	if( $this->classTypes->isEmpty() ) return 'N/A';

    	$names = [];

    	foreach( $this->classTypes as $classType )
    	{
    		$names[] = $classType->name;
    	}

    	return implode(', ', $names);
    }

    public function getClassTypeIds()
    {
    	$ids = [];

    	if( !$this->classTypes->isEmpty() )
    	{
    		foreach( $this->classTypes as $classType )
    		{
    			$ids[] = $classType->id;
    		}
    	}

    	return $ids;
    }

    public function getLink()
    {
    	return URL::route('activities.show', $this->id);
    }

    public function getLevelId()
    {
    	return $this->level ? $this->level->id : null;
    }

    public function createSimilarString()
    {
    	return [
    		'name'			=> $this->getName(),
    		'description'	=> $this->getDescription(),
    		'places'		=> $this->getPlaces(),
    		'street_address'=> $this->street_address,
    		'town'			=> $this->town,
    		'postcode'		=> $this->postcode,
    		'date'			=> $this->getDate(),
    		'time_from'		=> $this->time_from,
    		'time_until'	=> $this->time_until,
    		'cost'			=> $this->cost,
    		'class_type_id'	=> $this->getClassTypeIds(),
    		'level_id'		=> $this->getLevelId()
    	];
    }

    public function stripeCost()
    {
    	return number_format($this->cost, 0) * 100;
    }
}