<?php

class Search extends \Eloquent {
	protected $fillable = [];

	public static function execute(array $input)
	{
		$activities = new Activity;

		// Keyword Search
		if( $terms = Input::get('terms') )
		{
		    $searchTerms = explode(' ', $terms);

		    foreach($searchTerms as $term)
		    {
		        $activities = $activities->where('name', 'LIKE', '%' . $term .'%');
		    }
		}
		
		$activities = $activities->orderBy('created_at', 'DESC')->get();

		/*-------------- APPLY FILTERS ---------------*/	

		// Class Type
		if( $classTypeId = Input::get('class_type_id') )
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
					$classType 	= ClassType::find($classTypeId);
					$children 	= ClassType::findChildren($classType);

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

		// Day Search
		if ($days = Input::get('day') )
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

		// Gender Search
		if( $genders = Input::get('genders') )
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

		// Distance Search
		if( Input::get('distance') && Input::get('location'))
		{
			$distance = Input::get('distance');
			$location = Input::get('location');

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

		// Check if we have changed page in the pagination. If we have then subtract 1 from the page query paramater to get the correct index in the array i.e. page1 is the first page so equals index 0 in the array
		$page = Input::get('page') ? (int) Input::get('page') - 1 : 0;

		if( !$activities->isEmpty() )
		{
			// Split the activities into chunks of 10
			$chunk = $activities->chunk(10);

			// Find the correct chunk depending on the page
			$activeChunk = $chunk->get($page);

			// Create the pagination
			$activities = Paginator::make($activeChunk->all(), count($activities), 10);
		}

		// Used for the AJAX Search. When the AJAX search is used the JSON response is rendered using a handlebars template. This template does not have access to PHP functions or relationships such as $activity->user so we have to make sure to include all of the information in the JSON response.

		if( Request::ajax() )
		{
			return static::resultsToJSON($activities);
		}

		return $activities;
	}

	public static function resultsToJSON($activities)
	{
		$activitiesArr = [];
		$links = '';

		if( count($activities) )
		{
			foreach( $activities as $activity )
			{
				$attending 					= $activity->isAttending() ? true : false;
				$favourite 					= $activity->isFavourite() ? true : false;

				// Convert the activity to an array so we can add extra values to it
				$activityArr 				= $activity->toArray();

				// Get the creator of the activity and add it to the array
				$instructor 				= $activity->instructor;

				$activityArr['user'] 		= $instructor->toArray();

				// Boolean - is the user attending this activity
				$activityArr['attending'] 	= $attending;

				// Boolean - is this activity a favourite of the user
				$activityArr['favourite'] 	= $favourite;

				$activityArr['level']		= $activity->level ? $activity->level->name : 'N/A';

				// Routes for use in the template file
				$activityArr['routes'] 		= [
					'book'			=> URL::route('activity.book', $activity->id),
					'showUser'		=> URL::route('users.show', $activity->instructor->id),
					'showActivity' 	=> URL::route('activities.show', $activity->id)
				];

				$activityArr['views']		= [
					'addFavourite'	=> View::make('_partials.elements.addFavourite')
										->with(compact('activity'))
										->render(),
					'removeFavourite'	=> View::make('_partials.elements.removeFavourite')
										->with(compact('activity'))
										->render(),
				];
				$activitiesArr[]			= $activityArr;
			}

			$links = $activities->links()->render();
		}

		$return = [
			'activities' => $activitiesArr,
			'links'		=> $links
		];

		return $return;
	}
}