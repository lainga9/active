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

	public function cancel()
	{
		$this->cancelled = 1;
		$this->save();

		return $this;
	}

	public function isCancelled()
	{
		return $this->cancelled == 1 ? true : false;
	}

	public static function feedbackable($client, $instructor)
	{
		$activities = $client->attendingActivities;

		$activities = $activities->filter(function($activity) use ($instructor)
		{
			if( $activity->instructor->id == $instructor->id)
			{
				return static::hasPassed($activity);
			}
		});

		return $activities;
	}

	public static function reducePlaces($activity)
	{
		if( !$activity->isFull() )
		{
			$activity->places = (int) $activity->places - 1;
			$activity->save();

			return $activity;
		}

		return Redirect::back()
		->with(
			'status',
			'Sorry this class is fully booked!'
		);
	}

	public static function attachClassTypes($activity)
	{
		if( $classTypes = Input::get('class_type_id') )
		{
			foreach( $classTypes as $classType )
			{
				$activity->classTypes()->attach($classType);
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

	public static function getStartTime($activity)
	{
		return strtotime($activity->date . ' ' . $activity->time_from);
	}

	public static function getEndTime($activity)
	{
		return strtotime($activity->date . ' ' . $activity->time_until);
	}

	public static function hasPassed($activity)
	{
		$endTime = static::getEndTime($activity);
		$currentTime = strtotime("now");

		return $endTime < $currentTime ? true : false;
	}

	public static function makeAddressURL($activity)
	{
		return urlencode($activity->street_address) . ',' . urlencode($activity->town) . ',' . urlencode($activity->postcode);
	}

	public static function makeTimetable($user = null, $date = null)
	{
		$user = $user ? $user : Auth::user();

		// Initialise empty arrays
		$dates = [];
		$activities = [];

		if( !$date )
		{
			// Get the closest Monday i.e. the starting date
			$start = strtotime("Monday this week");
		}
		else
		{
			$start = strtotime($date);
		}

		// Convert it to the correct date format for eloquent queries
		$monday = date( "Y-m-d", $start );

		// Add it to the dates array
		$dates[] = $monday;

		// Get the next 6 days and store them in the dates array
		for($i = 1; $i < 7; $i++)
		{
			$dates[] = date( "Y-m-d", strtotime("+{$i} day", $start) );
		}

		// For each date, find the corresponding activities and store them in an array
		foreach($dates as $date)
		{
			$activities[ strtolower( date( 'l', strtotime($date) ) ) ] = Activity::whereUserId($user->id)->whereDate($date)->get();
		}

		return $activities;
	}

	public static function checkAvailable($activities, $input)
    {
    	// The requested start and finish times for the new activity (in timestmamp form)
    	$requestedStart 	= strtotime($input['date'] . ' ' . $input['time_from']);
    	$requestedFinish 	= strtotime($input['date'] . ' ' . $input['time_until']);

    	// Check for a date clash
    	$activities = $activities->filter(function($activity) use ($requestedStart, $requestedFinish)
    	{
    		// The start and finish times for the current activity in the loop
    		$start 	= strtotime($activity->date . ' ' . $activity->time_from);
    		$finish = strtotime($activity->date . ' ' . $activity->time_until);
    		
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