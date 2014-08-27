<?php

class Activity extends \Eloquent {
	protected $guarded = [];

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

	public function book($user, $mailer) 
	{
		$user->attendingActivities()->attach($this->id);
		$this->reducePlaces();

		$mailer->send($this->instructor, 'emails.blank', 'Testing Email');

		return $this;
	}

	public function isBookable()
	{
		return !$this->isClosed() && !$this->isFull() && !isAttending();
	}

	public static function feedbackable($client, $instructor)
	{
		$activities = $client->attendingActivities;

		$activities = $activities->filter(function($activity) use ($instructor)
		{
			if( $activity->instructor->id == $instructor->id)
			{
				return $activity->hasPassed();
			}
		});

		return $activities;
	}

	public function reducePlaces()
	{
		if( !$this->isFull() )
		{
			$this->places = (int) $this->places - 1;
			$this->save();

			return $this;
		}

		return Redirect::back()
		->with(
			'status',
			'Sorry this class is fully booked!'
		);
	}

	public function attachClassTypes($classTypes)
	{
		if( $classTypes )
		{
			foreach( $classTypes as $classType )
			{
				$this->classTypes()->attach($classType);
			}
		}
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
		$endTime = static::getEndTime($this);
		$currentTime = strtotime("now");

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
}