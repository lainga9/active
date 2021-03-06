<?php

/*
|--------------------------------------------------------------------------
| Custom Validation
|--------------------------------------------------------------------------
|
| The future rule checks to see if the activity being added is in the future.
|
*/

Validator::extend('future', function($attribute, $value, $parameters)
{
    return strtotime($value) >= strtotime("today");
});

/*
|--------------------------------------------------------------------------
| Handling Stripe Errors
|--------------------------------------------------------------------------
|
| The future rule checks to see if the activity being added is in the future.
|
*/

App::error(function(Stripe_InvalidRequestError  $exception, $code, $fromConsole)
{
	return Redirect::route('dashboard')->with('error', $exception->getMessage());
});

App::error(function(Stripe_CardError  $exception, $code, $fromConsole)
{
	return Redirect::route('dashboard')->with('error', $exception->getMessage());
});

App::error(function(Stripe_AuthenticationError  $exception, $code, $fromConsole)
{
	// Authentication with Stripe's API failed // (maybe you changed API keys recently) 
});

App::error(function(Stripe_ApiConnectionError  $exception, $code, $fromConsole)
{
	// Network communication with Stripe failed 
});

App::error(function(Stripe_Error  $exception, $code, $fromConsole)
{
	// Display a very generic error to the user, and maybe send // yourself an email 
});


/*
|--------------------------------------------------------------------------
| Iron.io queue
|--------------------------------------------------------------------------
|
| Required for queuing mail using Iron.io
|
*/

Route::post('queue/receive', function()
{
    return Queue::marshal();
});

/*
|--------------------------------------------------------------------------
| Stripe Connect
|--------------------------------------------------------------------------
|
| Response URI for Stripe Connect
|
*/

Route::get('stripe/connect', [
	'as'	=> 'stripe.connect',
	'uses'	=> 'AccountController@stripeConnect'
]);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 
	['as' => 'register', 
	'uses' => 'AuthController@register']);

Route::group(['before' => 'auth'], function() {

	/*
	|--------------------------------------------------------------------------
	| Misc Routes
	|--------------------------------------------------------------------------
	|
	*/

	// Dashboard
	Route::get('dashboard', 
		['as' => 'dashboard', 
		'uses' => 'DashboardController@index']);

	/*
	|--------------------------------------------------------------------------
	| Account Routes
	|--------------------------------------------------------------------------
	|
	*/

	// My Account
	Route::get('account', 
		['as' => 'account', 
		'uses' => 'AccountController@index']);

	// My Account
	Route::get('account/addCard', 
		['as' => 'account.addCard', 
		'uses' => 'AccountController@addCard']);

	// Upgrade to Pro Plan
	Route::post('account/goPro', 
		['as' => 'account.goPro', 
		'uses' => 'AccountController@goPro']);

	// Cancel the Pro Plan
	Route::post('account/cancelPro', 
		['as' => 'account.cancelPro', 
		'uses' => 'AccountController@cancelPro']);

	// Resume the Pro Plan
	Route::post('account/resumePro', 
		['as' => 'account.resumePro', 
		'uses' => 'AccountController@resumePro']);

	// Delete a card
	Route::post('account/card/delete/{cardId}', 
		['as' => 'account.card.delete', 
		'uses' => 'AccountController@deleteCard']);

	// Add a card
	Route::post('account/card/add', 
		['as' => 'account.card.add', 
		'uses' => 'AccountController@doAddCard']);

	// Handles failed payments - http://laravel.com/docs/billing#handling-failed-payments
	Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

	/*
	|--------------------------------------------------------------------------
	| Activity Routes
	|--------------------------------------------------------------------------
	|
	*/

	// Activities index
	Route::get('activities', [
		'as'	=> 'activities.index',
		'uses'	=> 'ActivitiesController@index'
	]);

	// Add Activity
	Route::get('activities/create', [
		'as'	=> 'activities.create',
		'uses'	=> 'ActivitiesController@create'
	]);

	Route::get('activities/cover', [
		'as'	=> 'activities.coverListings',
		'uses'	=> 'ActivitiesController@coverListings'
	]);

	// Single Activity
	Route::get('activities/{id}', [
		'as'	=> 'activities.show',
		'uses'	=> 'ActivitiesController@show'
	]);

	// Store Activity
	Route::post('activities', [
		'as'	=> 'activities.store',
		'uses'	=> 'ActivitiesController@store'
	]);

	// Edit Activity
	Route::get('activities/{id}/edit', [
		'as'	=> 'activities.edit',
		'uses'	=> 'ActivitiesController@edit'
	]);

	// Update Activity
	Route::put('activities/{id}', [
		'as'	=> 'activities.update',
		'uses'	=> 'ActivitiesController@update'
	]);

	// Adds an activity to an instructors timetable
	Route::post('activity/addToTimetable/{id}', [
		'as'	=> 'activity.addToTimetable',
		'uses'	=> 'ActivitiesController@addToTimetable'
	]);

	// Find Cover for an Activity
	Route::put('activity/cover/find/{id}', [
		'as'	=> 'activity.findCover',
		'uses'	=> 'ActivitiesController@findCover'
	]);

	// Apply to cover an activity
	Route::post('activity/cover/apply/{id}', [
		'as'	=> 'activity.applyToCover',
		'uses'	=> 'ActivitiesController@applyToCover'
	]);

	// Select an applicant to cover your activity
	Route::post('activity/cover/accept/{id}', [
		'as'	=> 'activity.acceptCover',
		'uses'	=> 'ActivitiesController@acceptCover'
	]);

	// Activities a user is attending
	Route::get('attending',
		['as' => 'activities.attending',
		'uses' => 'ActivitiesController@attending']);


	// Book an Activity
	Route::post('bookActivity/{id}', 
		['as' => 'activity.book',
		'uses' => 'ActivitiesController@book']
	);

	// Show payment form for activity
	Route::get('activity/pay/{id}', 
		['as' => 'activity.pay',
		'uses' => 'ActivitiesController@pay']
	);

	// Process payment for activity
	Route::post('activity/pay/{id}', 
		['as' => 'activity.pay',
		'uses' => 'ActivitiesController@pay']
	);

	// Instructor cancel an activity
	Route::put('cancelActivity/{id}',
		['as' => 'activity.cancel',
		'uses' => 'ActivitiesController@cancel']);

	// Instructor close an activity
	Route::put('closeActivity/{id}',
		['as' => 'activity.close',
		'uses' => 'ActivitiesController@close']);

	/*
	|--------------------------------------------------------------------------
	| Class Type Routes
	|--------------------------------------------------------------------------
	|
	*/

	// Class Types
	Route::resource('classTypes', 'ClassTypesController');

	/*
	|--------------------------------------------------------------------------
	| Message Routes
	|--------------------------------------------------------------------------
	|
	*/

	// Message inbox
	Route::get('messages', 
		['as' => 'messages.index', 
		'uses' => 'MessagesController@index']);

	// Send a message
	Route::post('messages/send/{id}', 
		['as' => 'messages.send', 
		'uses' => 'MessagesController@send']);

	// Get a message thread
	Route::get('messages/thread',
		['as' => 'messages.getThread', 
		'uses' => 'MessagesController@getThread']);

	// Updates the timetable with a new date
	Route::get('timetable',
		['as' => 'activities.timetable',
		'uses' => 'ActivitiesController@timetable']);


	/*
	|--------------------------------------------------------------------------
	| Social Routes
	|--------------------------------------------------------------------------
	|
	*/

	// User Favourites
	Route::get('activity/favourites', 
		['as' => 'favourites', 
		'uses' => 'ActivitiesController@favourites']);

	// Add a favourite
	Route::post('activity/addFavourite/{id}', 
		['as' => 'activity.addFavourite', 
		'uses' => 'ActivitiesController@addFavourite']
	);

	// Follow a friend
	Route::get('follow/{id}', [
		'as'	=> 'user.follow',
		'uses'	=> 'UsersController@follow'
	]);

	// Unfollow a friend
	Route::get('unfollow/{id}', [
		'as'	=> 'user.unfollow',
		'uses'	=> 'UsersController@unfollow'
	]);

	// Favourite an activity
	Route::post('favourite/{id}', [
		'as'	=> 'user.favourite',
		'uses'	=> 'UsersController@favourite'
	]);

	// Remove a favourite
	Route::post('activity/removeFavourite/{id}',
		['as' => 'activity.removeFavourite',
		'uses' => 'ActivitiesController@removeFavourite']
	);

	// Remove all favourites
	Route::post('user/removeFavourites',
		['as' => 'user.removeFavourites',
		'uses' => 'UsersController@removeFavourites']
	);

	// People a user is following
	Route::get('user/following/{id?}', [
		'as'	=> 'user.following',
		'uses'	=> 'UsersController@following'
	]);

	// People a user is followed by
	Route::get('user/followers/{id?}', [
		'as'	=> 'user.followers',
		'uses'	=> 'UsersController@followers'
	]);

	/*
	|--------------------------------------------------------------------------
	| User Routes
	|--------------------------------------------------------------------------
	|
	*/

	// View Profile
	Route::get('profile', [
		'as' => 'profile',
		'uses' => 'UsersController@show'
	]);

	// Edit profile
	Route::get('profile/edit', [
		'as' => 'profile.edit',
		'uses' => 'UsersController@edit'
	]);

	// Users index
	Route::get('users', [
		'as'	=> 'users.index',
		'uses'	=> 'UsersController@index'
	]);

	// Single User
	Route::get('users/show/{id}', [
		'as'	=> 'users.show',
		'uses'	=> 'UsersController@show'
	]);

	// Update profile pic
	Route::put('users/avatar/{id}', [
		'as'	=> 'user.avatar',
		'uses'	=> 'UsersController@avatar'
	]);

	// Suspends a user
	Route::get('users/suspend/{id}', [
		'as'	=> 'user.suspend',
		'uses'	=> 'UsersController@suspend'
	]);

	// Unsuspends a user
	Route::get('users/unsuspend/{id}', [
		'as'	=> 'user.unsuspend',
		'uses'	=> 'UsersController@unsuspend'
	]);

	Route::get('users/suspended', [
		'as'	=> 'users.suspended',
		'uses'	=> 'UsersController@suspended'
	]);

	/*
	|--------------------------------------------------------------------------
	| Feedback Routes
	|--------------------------------------------------------------------------
	|
	*/

	// Feedback Index
	Route::get('feedback/{id?}', 
		['as' => 'feedback.index', 
		'uses' => 'FeedbackController@index']
	);

	// Leave feedback
	Route::post('feedback/{instructorId?}', 
		['as' => 'feedback.store', 
		'uses' => 'FeedbackController@store']);

	/*
	|--------------------------------------------------------------------------
	| Marketing Routes
	|--------------------------------------------------------------------------
	|
	*/

	Route::get('marketing',
		['as' => 'marketing.index',
		'uses' => 'MarketingController@index']);

	Route::get('marketing/download', [
		'as' => 'marketing.download', 
		'uses' => 'MarketingController@download']);

	/*
	|--------------------------------------------------------------------------
	| Search Routes
	|--------------------------------------------------------------------------
	|
	*/

	Route::group(['prefix' => 'search'], function() 
	{
		// Show the advanced search page
		Route::get('/', 
			['as' => 'search', 
			'uses' => 'SearchController@get']);

		// Perform activity search
		Route::get('activities', 
			['as' => 'activities.search', 
			'uses' => 'SearchController@activities']);

		// Perform user search
		Route::get('users', 
			['as' => 'users.search', 
			'uses' => 'SearchController@users']);

		// Perform organisations search
		Route::get('organisations', 
			['as' => 'organisations.search', 
			'uses' => 'SearchController@organisations']);
	});

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	*/

	Route::group(['prefix' => 'api'], function() 
	{
		Route::get('activities', 
			['as' => 'api.activities', 
			'uses' => 'ActivitiesController@api']
		);

		Route::get('favourites', 
			['as' => 'api.favourites',
			'uses' => 'ActivitiesController@apiFavourites']);

		Route::get('attending', 
			['as' => 'api.attending',
			'uses' => 'ActivitiesController@apiAttending']);

		Route::get('activity/isFavourite/{id}',
			['as' => 'activity.isFavourite',
			'uses' => 'ActivitiesController@isFavourite']);

		Route::get('activity/isAttending/{id}',
			['as' => 'activity.isAttending',
			'uses' => 'ActivitiesController@isAttending']);

		Route::get('threads',
			['as' => 'api.threads',
			'uses' => 'MessagesController@apiThreads']);

		Route::get('thread/{id}',
			['as' => 'api.thread',
			'uses' => 'MessagesController@apiThread']);

		Route::post('messages/send/{id}',
			['as' => 'api.sendMessage',
			'uses' => 'MessagesController@apiSend']);

		Route::get('findMessageRecipient/{id}', 
			['as' => 'api.findMessageRecipient',
			'uses' => 'MessagesController@findRecipient']);
	});
});

/*
|--------------------------------------------------------------------------
| Unprotected User Routes
|--------------------------------------------------------------------------
|
*/

// Add User
Route::get('users/create', [
	'as'	=> 'users.create',
	'uses'	=> 'UsersController@create'
]);

// Update User
Route::put('users/{id}', [
	'as'	=> 'users.update',
	'uses'	=> 'UsersController@update'
]);

// Store User
Route::post('users', [
	'as'	=> 'users.store',
	'uses'	=> 'UsersController@store'
]);

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
*/

// Login
Route::get(
	'login', 
	array(
		'as' => 'getLogin', 
		'uses' => 'AuthController@getLogin'
	)
);

Route::post(
	'login', 
	array(
		'as' => 'postLogin', 
		'uses' => 'AuthController@postLogin'
	)
);

// Logout
Route::get(
	'logout', 
	array(
		'as' => 'getLogout', 
		'uses' => 'AuthController@getLogout'
	)
);

// Password Reminder
Route::get(
	'passwordReminder',
	array(
		'as' => 'password.reminder',
		'uses' => 'RemindersController@getRemind'
	)
);

Route::post(
	'passwordReminder',
	array(
		'as' => 'password.reminder',
		'uses' => 'RemindersController@postRemind'
	)
);

// Password Reminder
Route::get(
	'password/reset/{token}',
	array(
		'as' => 'password.reset',
		'uses' => 'RemindersController@getReset'
	)
);

// Password Reset
Route::post(
	'passwordReset',
	array(
		'as' => 'password.reset',
		'uses' => 'RemindersController@postReset'
	)
);
