<?php

use Laravel\Cashier\BillableTrait;
use Laravel\Cashier\BillableInterface;

class Instructor extends \Eloquent implements BillableInterface {

	use BillableTrait;

	protected $guarded = [];

	protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	public static $typeAttributes = [
		'phone',
		'mobile',
		'postcode',
		'bio',
		'website',
		'facebook',
		'twitter',
		'youtube',
		'google'
	];

	protected $table = "users_instructors";

    public function user()
    {
        return $this->morphOne('User', 'userable');
    }

	public function marketingMaterial($view, $data, $filename)
	{
		$pdf = PDF::loadView($view, $data);
		return $pdf->download($filename . '.pdf');
	}

    public static function spendCredit($user, $activity)
    {
    	if( !$user->userable->subscribed('pro') )
    	{
    		$user->userable->credits = (int) $user->userable->credits - 1;
	    	$user->userable->save();
    	}

    	$credit = Credit::create([
    		'instructor_id' => $user->id,
    		'activity_id' 	=> $activity->id
    	]);
    }

    public static function getCreditsAttribute($value)
    {
    	return (int) $value;
    }

    public static function checkAvailable($user, $input)
    {
    	$activities = $user->activities;

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
    	});

    	return $activities;
    }

    public function getAverageFeedback()
    {
    	$feedback = $this->user->feedback;

    	if( $feedback->isEmpty() ) return null;

    	$ratings = [];

    	foreach( $feedback as $item )
    	{
    		if( $item->values )
    		{
    			foreach( $item->values as $value )
    			{
    				$ratings[] = $value->value;
    			}
    		}
    	}

    	if( count($ratings) )
    	{
    		return (float) array_sum($ratings)/count($ratings);
    	}

    	return null;
    }
}