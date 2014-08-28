<?php

class Client extends \Eloquent {
	protected $guarded = [];

	public static $typeAttributes = [
		'twitter',
		'youtube',
		'facebook',
		'website',
		'instagram',
		'bio'
	];

	protected $table = "users_clients";

    public function user()
    {
        return $this->morphOne('User', 'userable');
    }

    public static function checkAvailable($user, $activity)
    {
    	$activities = $user->attendingActivities;

    	// The requested start and finish times for the new activity (in timestmamp form)
    	$requestedStart 	= strtotime($activity->date . ' ' . $activity->time_from);
    	$requestedFinish 	= strtotime($activity->date . ' ' . $activity->time_until);

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