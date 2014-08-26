<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $guarded = [];

	// This array is used to distinguish which fields should be stored in the users table as opposed to the clients or instructors table. It's used when static::createAccount() is called in UsersController

	public static $userAttributes = [
		'first_name',
		'last_name',
		'email',
		'gender',
		'avatar'
	];

	/* Relationships */

	public function CreditHistory()
	{
		return $this->hasMany('Credit', 'instructor_id');
	}

	// Classes listed by an Instructor
	public function Activities($date = null)
	{
		if( $date )
		{
			return $this->hasMany('Activity')->whereDate($date);	
		}

		return $this->hasMany('Activity');
	}

	// Classes that client is attending
	public function AttendingActivities() 
	{
		return $this->belongsToMany('Activity');
	}

	// Clients favourite activities
	public function Favourites()
	{
		return $this->belongsToMany('Activity', 'activity_favourite');
	}

	// Feedback an instructor has received
	public function Feedback()
	{
		return $this->hasMany('Feedback', 'instructor_id');
	}

	// Messages sent by a User
	public function sentMessages()
	{
		return $this->hasMany('Message', 'sender_id');
	}

	// Messages received by a user
	public function receivedMessages()
	{
		return $this->hasMany('Message', 'recipient_id');
	}

	public function removeFavourites()
	{
		$favourites = Auth::user()->favourites;

		if( !$favourites->isEmpty() )
		{
			foreach( $favourites as $favourite )
			{
				Auth::user()->favourites()->detach($favourite->id);
			}
		}
	}

	public function makeTimetable($user = null, $date = null)
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
			if( $user->isInstructor() )
			{
				$activities[ strtolower( date( 'l', strtotime($date) ) ) ] = Activity::whereUserId($user->id)->whereDate($date)->get();
			}

			if( $user->isClient() )
			{
				$activities[ strtolower( date( 'l', strtotime($date) ) ) ] = $user->attendingActivities()->whereDate($date)->get();
			}
		}

		return $activities;
	}

	// Class types associated to an instructor. It checks all activities listed by an instructor and returns all of the classtypes associated to them.
	public static function ClassTypes($user)
	{
		$classTypes = [];

	    foreach ($user->activities as $activity)
	    {
	        foreach ($activity->classTypes as $classType)
	        {
	            if ($classType->id !== $user->id && !isset($classTypes[$classType->id]))
	            {
	                $classTypes[$classType->id] = $classType;
	            }
	        }
	    }

	    return Illuminate\Database\Eloquent\Collection::make($classTypes);
	}

	/* End Relationships */

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	// Maps the user to the user type i.e. client, instructor, admin etc
	public function userable()
    {
	    return $this->morphTo();
    }

    // Hash the password upon user creation
    public function setPasswordAttribute($pass)
	{
		$this->attributes['password'] = Hash::make($pass);
	}

	// Method to create the user and corresponding user type i.e. client, instructor, admin etc
    public static function createAccount(
    	$type, 
    	array $userAttributes, 
    	array $typeAttributes
    )
	{
	    if(class_exists($type))
	    {
	        $userType = $type::create($typeAttributes);
	    	$userType->user()->create($userAttributes);

	    	return $userType;
	    } 
	    else
	    {
	    	throw new Exception("Invalid user type");
	    }
	}

	// Check if the user is a client
	public function isClient()
	{
		if( !Auth::check() ) return false;

		if( $this->role_id == 3 ) return true;

		return $this->role_id == 1 ? true : false;
	}

	// Check if the user is instructor
	public function isInstructor()
	{
		if( !Auth::check() ) return false;

		if( $this->role_id == 3 ) return true;

		return $this->role_id == 2 ? true : false;
	}

	// Check if the user is an individudal
	public function isIndividual()
	{
		if( !Auth::check() ) return false;

		return $this->user_type_id == 1 ? true : false;		
	}

	// Check if the user is an organisation
	public function isOrganisation()
	{
		if( !Auth::check() ) return false;

		return $this->user_type_id == 1 ? true : false;		
	}

	// Check if the user is attending an activity
	public static function isAttending($id)
	{
		return Auth::user()->attendingActivities->contains($id) ? true : false;
	}

}
