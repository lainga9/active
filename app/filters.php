<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('instructor', function()
{
	if( !User::isInstructor() )
	{
		return Redirect::route('dashboard')
		->with('error', 'Sorry you do not have sufficient permissions to perform that action');
	}
});

// Checks the user is a client
Route::filter('client', function()
{
	if( !User::isClient() )
	{
		return Redirect::route('dashboard')
		->with('error', 'Sorry, instructors cannot perform that action!');
	}
});

// Checks that the class doesn't finish before it starts
Route::filter('activity.hasLength', function($route)
{
	if(strtotime(Input::get('time_from')) >= strtotime(Input::get('time_until')))
	{
		return Redirect::back()->withInput()
		->with('error', 'Please make sure your class last at least 30 minutes');
	}
});

// Checks that the user is an instructor and that the client isn't already booked in.
Route::filter('activity.book', function($route)
{
	if( User::isInstructor() )
	{
		return Redirect::route('dashboard')
		->with('error', 'Sorry, instructors cannot book activities');
	}

	$id = Route::input('id');

	$activity = Activity::find($id);

	if( $activity->isFull() )
	{
		return Redirect::back()
		->with('status', 'Sorry this class is fully booked!');	
	}

	if( Auth::user()->attendingActivities->contains($id) )
	{
		return Redirect::back()
		->with('status', 'You are already booked into this class!');
	}

});

// Checks to see if the user exists
Route::filter('exists.user', function($route)
{
	$id = Route::input('users');

	if( !$id )
	{
		$id = Route::input('id');
	}

	if($id)
	{
		$user = User::find($id);

		if( !$user )
		{
			return Redirect::route('dashboard')
			->with('error', 'Sorry, the user you requested cannot be found');	
		}
	}
});

// Check to see if the activity exists
Route::filter('exists.activity', function($route)
{
	$id = Route::input('activities');

	if(!$id)
	{
		$id = Route::input('activityId');
	}
	
	if($id)
	{
		$activity = Activity::find($id);

		if( !$activity )
		{
			if( Request::ajax() )
			{
				return Response::json([
					'error' => 'Sorry, we can\'t find the activity you requested!'
				]);
			}

			return Redirect::route('dashboard')
			->with('error', 'The activity you are looking for cannot be found');
		}
	}
});

// Check is an activity has passed or not
Route::filter('activity.hasPassed', function($route)
{
	$id = Route::input('activityId');

	$activity = Activity::find($id);

	if( !Activity::hasPassed() )
	{
		return Redirect::back()
		->with(
			'error',
			'This activity has not taken place yet'
		);
	}

});

// Makes sure the activity isn't already in the users favourites when trying to add
Route::filter('activity.isFavourite', function($route) 
{
	$id = Route::input('id');

	if( Auth::user()->favourites->contains($id) )
	{
		return Response::json([
			'html' => 'This is already in your favourites!'
		]);
	}
});

// Makes sure the activity is in the users favourites when trying to remove
Route::filter('activity.notFavourite', function($route)
{
	$id = Route::input('id');

	if( !Auth::user()->favourites->contains($id) )
	{
		return Response::json([
			'html' => 'This activity is not in your favourites!'
		]);
	}
});

// Checks the instructor has enough credits to list an activity
Route::filter('instructor.hasCredits', function() 
{
	if( !Auth::user()->userable->subscribed() )
	{
		$credits = Auth::user()->userable->credits;

		if( $credits < 1 )
		{
			return Redirect::route('dashboard')
			->with('error', 'Sorry you do not have enough credits to list this activity');
		}
	}
});

Route::filter('feedback.store', function($route)
{
	$instructor = User::find(Route::input('instructorId'));
	
	if( !Activity::feedbackable(Auth::user(), $instructor) )
	{
		return Redirect::back()
		->with(
			'error',
			'You can only leave feedback for classes which you have attended'
		);
	}
});

Route::filter('activity.belongsTo', function($route)
{
	$activity = Activity::find(Route::input('activities'));

	if($activity->user_id != Auth::user()->id)
	{
		return Redirect::route('dashboard')
		->with(
			'error',
			'You can only perform that action for activities which you have listed'
		);
	}

});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
