<?php namespace Services\Repositories;

use Services\Interfaces\SearchInterface;
use Activity;
use ClassType;
use Paginator;
use View;
use Request;
use User;

class DefaultSearch implements SearchInterface {

	protected $activity;
	protected $user;
	protected $classType;

	public function __construct(Activity $activity, User $user, ClassType $classType)
	{
		$this->activity 	= $activity;
		$this->user 		= $user;
		$this->classType 	= $classType;	
	}

	public function users($input)
	{
		$users = $this->user;

		// Name Search
		if( isset($input['name']) )
		{
			$name = $input['name'];

			if($name)
			{
				$searchTerms = explode(' ', $name);

			    foreach($searchTerms as $term)
			    {
			        $query = $users->where('first_name', 'LIKE', '%' . $term .'%')
			       			 ->orWhere('last_name', 'LIKE', '%' . $term .'%');
			    }
			}
		}

		// Email Search
		if( isset($input['email']) )
		{
			$email = $input['email'];

			if($email)
			{
				$query = $users->whereEmail($email);
			}
		}
		
		$users = $query->orderBy('created_at', 'DESC')->get();

		return $users;
	}

	public function activities($input)
	{
		$activities = $this->activity;

		// Keyword Search
		if( isset($input['terms']) )
		{
			$terms = $input['terms'];

			if($terms)
			{
				$searchTerms = explode(' ', $terms);

			    foreach($searchTerms as $term)
			    {
			        $activities = $activities->where('name', 'LIKE', '%' . $term .'%');
			    }
			}
		}
		
		$activities = $activities->orderBy('created_at', 'DESC')->get();

		/*-------------- APPLY FILTERS ---------------*/	

		// Class Type
		if( isset($input['class_type_id']) )
		{
			$classTypeId = $input['class_type_id'];

			if($classTypeId)
			{
				if( !is_array($classTypeId) )
				{
					$classTypeIds = explode(',', $classTypeId);
				}
				else
				{
					$classTypeIds = $classTypeId;
				}

				$activities = $activities->filter(function($activity) use ($classTypeIds)
				{
					foreach($classTypeIds as $classTypeId)
					{
						$classType 	= $this->classType->find($classTypeId);
						$children 	= $this->classType->findChildren($classType);

						if( $activity->classTypes->contains($classTypeId) )
						{
							return true;
						}

						if( $children )
						{
							foreach( $children as $child )
							{
								if( $activity->classTypes->contains($child->id) )
								{
									return true;
								}
							}
						}
					}
				});
			}
		}

		// Time Filter 
		if( isset($input['time_from']) && isset($input['time_until']) )
		{
			$timeFrom = strtotime($input['time_from']);
			$timeUntil = strtotime($input['time_until']);

			if($timeFrom && $timeUntil)
			{
				$activities = $activities->filter(function($activity) use ($timeFrom, $timeUntil)
				{
					$startTime = strtotime($activity->time_from);
					$endTime = strtotime($activity->time_until);

					if( $startTime >= $timeFrom && $endTime <= $timeUntil)
					{
						return true;
					}
				});
			}
		}

		// Day Search
		if ( isset($input['day']) )
		{
			$days = $input['day'];

			if( $days )
			{
				// Coming from advanced search
				if( !is_array($days) )
				{
					$days = explode(',', $days);
				}

				$activities = $activities->filter(function($activity) use ($days)
				{
					$activityDay = date('N', strtotime($activity->date));

					foreach( $days as $day )
					{
						if($day == $activityDay)
						{
							return true;
						}
					}
				});
			}
		}

		// Gender Search
		if( isset($input['genders']) )
		{
			$genders = $input['genders'];

			if($genders)
			{
				if( !is_array($genders) )
				{
					$genders = explode(',', $genders);
				}

				$activities = $activities->filter(function($activity) use ($genders)
				{
					foreach( $genders as $gender )
					{
						return $activity->instructor->gender == $gender ? true : false;
					}
				});
			}
		}

		// Distance Search
		if( isset($input['distance']) && isset($input['location']) )
		{
			$distance = $input['distance'];
			$location = $input['location'];

			if( $distance && $location )
			{
				$activities = $activities->filter(function($activity) use ($distance, $location)
				{
					$activityAddress = $activity->street_address . ',' . $activity->postcode;

					$string = 'origins=' . urlencode($activityAddress) . '&destinations=' . urlencode($location);

					$ch = curl_init();

					curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/distancematrix/xml?units=imperial&' . $string);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$output = curl_exec($ch);

					$xml = simplexml_load_string($output);

					$retrievedDistance = intval($xml->row->element->distance->text);

					if( $retrievedDistance <= $distance)
					{
						return true;
					}

				});
			}
		}

		// Check if we have changed page in the pagination. If we have then subtract 1 from the page query parameter to get the correct index in the array i.e. page1 is the first page so equals index 0 in the array
		$page = isset($input['page']) ? (int) $input['page'] - 1 : 0;

		if( !$activities->isEmpty() )
		{
			// Split the activities into chunks of 10
			$chunk = $activities->chunk(10);

			// Find the correct chunk depending on the page
			$activeChunk = $chunk->get($page);

			// Create the pagination
			$activities = Paginator::make($activeChunk->all(), count($activities), 10);
		}

		// Used for the AJAX Search. Rather than returning JSON and having to parse it with a template we simply render the view here and pass back the HTML string

		if( Request::ajax() )
		{
			return View::make('_partials.ajax.activities', compact('activities'))->render();
		}

		return $activities;
	}
}