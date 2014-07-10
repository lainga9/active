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

		// Execute the query
		$activities = $activities->get();


		/*-------------- APPLY FILTERS ---------------*/	

		// Class Type
		if( $classTypeId = Input::get('class_type_id') )
		{
			$activities = $activities->filter(function($activity) use ($classTypeId)
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

				return false;
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

				return false;
			});
		}

		// Distance Search
		// if( Input::get('distance') && Input::get('location'))
		// {
		// 	$distance = Input::get('distance');
		// 	$location = Input::get('location');

		// 	$activities = $activities->filter(function($activity) use ($distance, $location)
		// 	{
		// 		$activityAddress = $activity->street_address . ',' . $activity->postcode;

		// 		$string = 'origins=' . urlencode($activityAddress) . '&destinations=' . urlencode($location);

		// 		$ch = curl_init();

		// 		curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&' . $string);

		// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// 		$output = curl_exec($ch);

		// 		foreach(json_decode($output)->rows as $row)
		// 		{
		// 			if($row->elements)
		// 			{
		// 				foreach($row->elements as $result)
		// 				{
		// 					if( intval( ($result->distance->text) ) < $distance)
		// 					{
		// 						return true;
		// 					}
		// 				}
		// 			}
		// 		}
		// 	});
		// }

		// Used for the AJAX Search. When the AJAX search is used the JSON response is rendered using a handlebars template. This template does not have access to PHP functions or relationships such as $activity->user so we have to make sure to include all of the information in the JSON response.

		if( Request::ajax() )
		{
			$activitiesArr = [];

			if( count($activities) )
			{
				foreach( $activities as $activity )
				{
					$attending 					= User::isAttending($activity->id) ? true : false;
					$favourite 					= Activity::isFavourite($activity->id) ? true : false;

					// Convert the activity to an array so we can add extra values to it
					$activityArr 				= $activity->toArray();

					// Get the creator of the activity and add it to the array
					$instructor 				= $activity->instructor;

					$activityArr['user'] 		= $instructor->toArray();

					// Boolean - is the user attending this activity
					$activityArr['attending'] 	= $attending;

					// Boolean - is this activity a favourite of the user
					$activityArr['favourite'] 	= $favourite;

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
			}

			return $activitiesArr;
		}

		return $activities;
	}
}