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

	public function Favourites()
	{
		return $this->belongsToMany('User', 'activity_favourite');
	}

	public static function isFavourite($id)
	{
		return Auth::user()->favourites->contains($id) ? true : false;
	}

	public static function makeAddressURL($activity)
	{
		return urlencode($activity->street_address) . ',' . urlencode($activity->town) . ',' . urlencode($activity->postcode);
	}

	public static function makeTimetable($user, $date = null)
	{
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
}