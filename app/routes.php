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

	// Dashboard
	Route::get('dashboard', 
		['as' => 'dashboard', 
		'uses' => 'DashboardController@index']);

	// My Account
	Route::get('account', 
		['as' => 'account', 
		'uses' => 'AccountController@index']);

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

	// Handles failed payments - http://laravel.com/docs/billing#handling-failed-payments
	Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

	// Activities
	Route::resource('activities', 'ActivitiesController');

	// Class Types
	Route::resource('classTypes', 'ClassTypesController');

	// Book an Activity
	Route::post('bookActivity/{id}', 
		['as' => 'activity.book',
		'uses' => 'ActivitiesController@book']
	);

	// Instructor cancel an activity
	Route::put('cancelActivity/{id}',
		['as' => 'activity.cancel',
		'uses' => 'ActivitiesController@cancel']);

	// Instructor close an activity
	Route::put('closeActivity/{id}',
		['as' => 'activity.close',
		'uses' => 'ActivitiesController@close']);

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

	// Activities a user is attending
	Route::get('attending',
		['as' => 'activities.attending',
		'uses' => 'ActivitiesController@attending']);

	// User Favourites
	Route::get('activity/favourites', 
		['as' => 'favourites', 
		'uses' => 'ActivitiesController@favourites']);

	// Add a favourite
	Route::post('activity/addFavourite/{id}', 
		['as' => 'activity.addFavourite', 
		'uses' => 'ActivitiesController@addFavourite']
	);

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

	Route::get('profile',
		['as' => 'profile.edit',
		'uses' => 'UsersController@edit']);

	// Feedback Index
	Route::get('feedback/{id?}', 
		['as' => 'feedback.index', 
		'uses' => 'FeedbackController@index']
	);

	// Leave feedback
	Route::post('feedback/{instructorId?}', 
		['as' => 'feedback.store', 
		'uses' => 'FeedbackController@store']);

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
			'uses' => 'ActivitiesController@getSearch']);

		// Perform the search
		Route::get('activities', 
			['as' => 'activities.search', 
			'uses' => 'ActivitiesController@search']);
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

// Users
Route::resource('users', 'UsersController', ['except' => ['edit']]);

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
