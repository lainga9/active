<?php

class Activity extends \Eloquent {
	protected $guarded = [];

	// Activities in the future
	public function scopeFuture($query)
	{
		return $query->where('date', '>=', date('Y-m-d'));
	}

	public function scopeDate($query, $date)
	{
		return $query->where('date', '=', $date);
	}

	// Activities for which the instructor has applied to have them covered
	public function scopeNeedCover($query)
	{
		return $query->where('need_cover', '=', 1);
	}

	// Instructors who have applied to cover the activity
	public function coverApplicants()
	{
		return $this->belongsToMany('User', 'activity_cover', 'activity_id', 'instructor_id');
	}

	// The instructor who has been selected to cover the activity
	public function coverInstructor()
	{
		return $this->belongsTo('User', 'cover_instructor_id');
	}

	// The class types associated to the activity
	public function ClassTypes()
	{
		return $this->belongsToMany('ClassType');
	}

	// The instructor for the activity
	public function Instructor()
	{
		return $this->belongsTo('User', 'user_id');
	}

	// Classes listed by organisations are sometimes taught by freelance instructors. This function adds the freelancers as a 'secondary' instructor so that the activity can be displayed on their timetable
	public function taughtBy()
	{
		return $this->belongsTo('User', 'taught_by_id');
	}
	
	// Clients who are attending the activity
	public function Clients()
	{
		return $this->belongsToMany('User');
	}

	// The difficulty level associated with the activity
	public function Level()
	{
		return $this->belongsTo('Level');
	}

	// DEPRECATED - users who have favourited an activity
	public function Favourites()
	{
		return $this->belongsToMany('User', 'activity_favourite');
	}

	// Whether or not the activity is full
	public function isFull()
	{
		return $this->places == 0 ? true : false;
	}

	// Whether or not the activity is closed for bookings
	public function isClosed()
	{
		return $this->closed == 1 ? true : false;
	}

	// Whether or not the activity is cancelled
	public function isCancelled()
	{
		return $this->cancelled == 1 ? true : false;
	}

	// Whether or not the activity needs cover from another instructor
	public function needsCover()
	{
		return $this->need_cover == 1 ? true : false;
	}

	// Checks if the logged-in user can apply to cover the activity.
	public function isCoverable()
	{
		return $this->needsCover() && Auth::user()->isInstructor() && !$this->isOwn();
	}

	// Closes an activity for bookings
	public function close()
	{
		$this->closed = 1;
		$this->save();

		return $this;
	}

	// Cancels an activity
	public function cancel()
	{
		$this->cancelled = 1;
		$this->save();

		return $this;
	}

	// Lists an activity on the find cover board
	public function findCover()
	{
		$this->need_cover = 1;
		$this->save();

		return $this;
	}

	// Checks to see if an activity is being covered by someone else
	public function isCovered()
	{
		if( $this->coverInstructor ) return true;

		return false;
	}

	// Allows an instructor to apply to cover an activity
	public function applyToCover($applicant)
	{
		$this->coverApplicants()->attach($applicant->id);

		return $this;
	}

	// Allows the owner of an activity to select an instructor to cover it
	public function acceptCover($applicant)
	{
		$this->cover_instructor_id = $applicant->id;
		$this->save();

		return $this;
	}

	// Allows client to book an activity
	public function book($user) 
	{
		$user->attendingActivities()->attach($this->id);
		$this->reducePlaces();

		return $this;
	}

	// Checks whether an activity is available to book
	public function isBookable()
	{
		return !$this->isClosed() && !$this->isFull() && !isAttending();
	}

	// Reduces the places of an activity by 1 when someone books it
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

	// When an activity is listed this creates the appropriate database relationships between the activity and the class types i.e. metafit etc
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

	// DEPRECATED - checks whether the activity is a user's favourite or not
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

	// Checks whether or not a user is attending an activity
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

	// Checks if the logged in user created the activity
	public function createdBy($user = null)
	{
		$user = $user ? $user : Auth::user();

		return $this->user_id == $user->id ? true : false;
	}

	// Alias for createdBy()
	public function isOwn()
	{
		return $this->createdBy();
	}

	// Returns the start time for the activity
	public function getStartTime()
	{
		return strtotime($this->date . ' ' . $this->time_from);
	}

	// Returns the end time for the activity
	public function getEndTime()
	{
		return strtotime($this->date . ' ' . $this->time_until);
	}

	// Checks if an activity has passed
	public function hasPassed()
	{
		$endTime 		= static::getEndTime($this);
		$currentTime 	= strtotime("now");

		return $endTime < $currentTime ? true : false;
	}

	// Makes a URL encoded address for an activity. Used for google maps
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
    	return date('d-m-Y', strtotime($this->date));
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

    // The array of data which is passed to the create activity page when create similar activity button is clicked
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