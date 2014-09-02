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
		'user_type_id',
		'street_address',
		'town',
		'postcode'
	];

	/* Relationships */

	// Credits spent by an instructor	
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

	// Actions performed this user
	public function Actions()
	{
		return $this->hasMany('Action')->orderBy('created_at', 'DESC');
	}

	// Actions where the user is mentioned i.e. someone has followed them
	public function Mentions()
	{
		return $this->hasMany('ActionChange', 'actor_id');
	}

	// Creates a stream of a users actions and mentions
	public function Stream()
	{
		$stream 	= [];

		$actions 	= $this->actions;
		$mentions 	= $this->mentions;
		
		if($actions)
		{
			foreach($actions as $action)
			{
				$stream[] = $action;
			}
		}

		if($mentions)
		{
			foreach($mentions as $mention)
			{
				$stream[] = $mention->actionObject->action;
			}
		}

		$stream = Illuminate\Database\Eloquent\Collection::make($stream);
		$stream = $stream->sortByDesc('created_at');

		return $stream;
	}

	public function SocialStream()
	{
		$stream = [];

		// Uncomment if you would like to include users own actions in their social stream
		// if( !$this->stream()->isEmpty() )
		// {
		// 	foreach($this->stream() as $action)
		// 	{
		// 		$stream[] = $action;
		// 	}
		// }

		if( !$this->following->isEmpty() )
		{
			foreach( $this->following as $following )
			{
				if( !$following->stream()->isEmpty() )
				{
					foreach( $following->stream() as $action )
					{
						// Don't include friends following other people - not interesting
						if( $action->getObjectType() == 'user' )
						{
							if( $action->user_id == $this->id)
							{
								continue;
							}	
						} 

						$stream[] = $action;
					}
				}
			}
		}

		$stream = Illuminate\Database\Eloquent\Collection::make($stream);
		$stream = $stream->sortByDesc('created_at');

		return $stream;
	}

	// Clients favourite instructors
	public function Favourites()
	{
		return $this->belongsToMany('User', 'follow_clients', 'user_id', 'client_id')->whereRoleId(2);
	}

	public function FavouriteActivities()
	{
		$return = [];

		$instructors = $this->following;

		if( !$instructors ) return null;

		foreach( $instructors as $instructor )
		{
			$activities = $instructor->activities;

			if( !$activities ) return null;

			foreach( $activities as $activity )
			{
				$return[] = $activity;
			}
		}

		return Illuminate\Database\Eloquent\Collection::make($return);
	}

	// Clients friends - people they're following
	public function Following()
	{
		return $this->belongsToMany('User', 'follow_clients', 'user_id', 'client_id');
	}

	// Clients friends - people they're following
	public function Followers()
	{
		return $this->belongsToMany('User', 'follow_clients', 'client_id', 'user_id');
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

	public function makeAddressURL()
	{
		return urlencode($this->street_address) . ',' . urlencode($this->town) . ',' . urlencode($this->postcode);
	}

	public function makeTimetable($user = null, $date = null)
	{
		$user = $user ? $user : Auth::user();

		// Initialise empty arrays
		$dates 		= [];
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
		$monday 	= date( "Y-m-d", $start );

		// Add it to the dates array
		$dates[] 	= $monday;

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

		return $this->user_type_id == 2 ? true : false;		
	}

	// Follow a client
	public function follow($user)
	{
		$this->following()->attach($user->id);
	}

	// Follow a client
	public function unfollow($user)
	{
		$this->following()->detach($user->id);
	}

	// Follow an instructor
	public function favouriteInstructor($instructor)
	{
		$this->favourites()->attach($instructor->id);
	}

	// Checks if a client can leave feedback for an instructor
	public function feedbackable($instructor)
	{
		if( $this->isInstructor() ) return null;
		
		$activities = $this->attendingActivities;

		$activities = $activities->filter(function($activity) use ($instructor)
		{
			if( $activity->instructor->id == $instructor->id)
			{
				return $activity->hasPassed();
			}
		});

		return $activities;
	}

	// Updates a user's avatar
	public function updateAvatar($input)
	{
		$path 		= 'uploads/' . str_random(20);
		$filename 	= $input->getClientOriginalName();
		$avatar 	= $input->move($path, $filename);

		if($avatar)
		{
			$this->avatar = $path . '/' . $filename;
			$this->save();

			return $this;
		}
		else
		{
			throw new Exception('Problem Uploading File');
		}
	}

	// Checks if a user is following someone
	public function isFollowing($user)
	{
		return $this->following->contains($user->id);
	}

	// Checks if a class clashes with other booked classes
	public function checkAvailable($activity)
    {
    	$activities = $this->attendingActivities;

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

    public function incrementPageView()
    {
    	if( $this->isClient() ) return $this;

    	$this->userable->page_views = (int) $this->userable->page_views + 1;
    	$this->userable->save();

    	return $this;
    }
}
