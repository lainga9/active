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
	if( Auth::check() )
	{
		if( Auth::user()->isSuspended() )
		{
			return View::make('auth.suspended');
		}
	}
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| View Composers
|--------------------------------------------------------------------------
| 
| Makes sure certain data is always available to specific views.
|
*/

// Makes sure the activities list is available for auto predict in the basic search
View::composer('_partials.search.basic', 'Services\Composers\SearchComposer');
View::composer('_partials.search.advanced', 'Services\Composers\SearchComposer');

// Make sure the user is always available for the social stream on activities page
View::composer('activities.client.index', 'Services\Composers\SocialComposer');

// Sends links to the admin sidebar
View::composer('_partials.admin.sidebar', 'Services\Composers\AdminSidebarComposer');

// Sends all class types to class types form
View::composer('_partials.forms.classTypes', 'Services\Composers\ClassTypeFormComposer');

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

Route::filter('admin', function()
{
	if( !Auth::user()->isAdmin() )
	{
		return Redirect::route('dashboard');
	}
});

Route::filter('instructor', function()
{
	if( !Auth::user()->isInstructor() )
	{
		return Redirect::route('dashboard')
		->with('error', 'Sorry you do not have sufficient permissions to perform that action');
	}
});

// Checks the user is a client
Route::filter('client', function()
{
	if( !Auth::user()->isClient() )
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
	if( Auth::user()->isInstructor() )
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
Route::filter('user.exists', function($route)
{
	$id = Route::input('id');

	if($id)
	{
		$user = User::find($id);

		if( !$user )
		{
			if( Request::ajax() )
			{
				return Response::json([
					'errors' => [['Sorry, this user cannot be found']]
				]);
			}

			return Redirect::route('dashboard')
			->with('error', 'Sorry, the user you requested cannot be found');	
		}
	}
});

// Checks to see if the user exists
Route::filter('user.notSelf', function($route)
{
	$id = Route::input('id');

	if($id)
	{
		$user = User::find($id);

		if( !$user )
		{
			return Redirect::route('dashboard')
			->with('error', 'Sorry, the user you requested cannot be found');	
		}

		if( $user->id == Auth::user()->id )
		{
			if( Request::ajax() )
			{
				return Response::json([
					'errors' => [['Sorry, an error has occurred']]
				]);
			}

			return Redirect::route('dashboard')
			->with('error', 'An error has occurred');	
		}
	}
});

// Check to see if the activity exists
Route::filter('activity.exists', function($route)
{
	$id = Route::input('id');
	
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
	$id = Route::input('id');

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
	if( !Auth::user()->subscribed('pro') )
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
	
	if( !Auth::user()->feedbackable($instructor) )
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
	$activity = Activity::find(Route::input('id'));

	if($activity->user_id != Auth::user()->id)
	{
		return Redirect::route('dashboard')
		->with(
			'error',
			'You can only perform that action for activities which you have listed'
		);
	}

});

Route::filter('user.favourite', function($route)
{
	if( Auth::user()->id == Route::input('id') )
	{
		return Redirect::back()
		->with('error', 'You cannot add yourself to your favourites');
	}
});

Route::filter('user.follow', function($route)
{
	$user = User::find(Route::input('id'));

	if( Auth::user()->following->contains($user->id) )
	{
		return Redirect::back()
		->with('error', 'You are already following ' . $user->first_name);	
	}
});

Route::filter('user.unfollow', function($route)
{
	$user = User::find(Route::input('id'));

	if( !Auth::user()->following->contains($user->id) )
	{
		return Redirect::back()
		->with('error', 'You aren\'t following ' . $user->first_name);	
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
