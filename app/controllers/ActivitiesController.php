<?php

class ActivitiesController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $classType;	
	protected $instructor;
	protected $client;

	public function __construct(
		Activity $activity, 
		ClassType $classType,
		Instructor $instructor,
		Client $client
	)
	{
		$this->activity 	= $activity;
		$this->classType 	= $classType;
		$this->instructor 	= $instructor;
		$this->client 		= $client;

		/*-------- FILTERS -------*/

		// Instructor Only Pages
		$this->beforeFilter('instructor', ['only' => ['create', 'edit', 'store', 'timetable']] );

		// Client Only Pages
		$this->beforeFilter('client', ['only' => ['attending', 'favourites']] );

		$this->beforeFilter('instructor.hasCredits', ['only' => ['create', 'store']] );
		// Checks the user is not an instructor since they're not allowed to book. Checks that the user isn't already booked in.
		$this->beforeFilter('activity.book', ['only' => ['book']] );

		// Checks that the activity exists
		$this->beforeFilter('exists.activity', ['only' => ['show', 'edit', 'update', 'book', 'addFavourite', 'removeFavourite', 'isFavourite', 'isAttending']] );

		// Checks the activity lasts at least 30 minutes
		// $this->beforeFilter('activity.hasLength', ['only' => ['store']] );

		// Makes sure the activity isn't already a favourite when trying to add to favourites
		$this->beforeFilter('activity.isFavourite', ['only' => ['addFavourite']] );

		// Makes sure activity is a favourite before it's removed
		$this->beforeFilter('activity.notFavourite', ['only' => ['removeFavourite']] );

		$this->beforeFilter('activity.belongsTo', ['only' => ['edit']] );
	}

	/**
	 * Display a listing of the resource.
	 * GET /activities
	 *
	 * @return Response
	 */
	public function index()
	{
		$activities = $this->activity->paginate(10);

		if( User::isInstructor() )
		{
			$activities = Activity::makeTimetable(Auth::user());
		}

		$this->layout->content = View::make('activities.' . get_class(Auth::user()->userable) . '.index')->with(compact('activities'));
	}

	public function attending()
	{
		$activities = Auth::user()->attendingActivities;

		$this->layout->content = View::make('activities.client.attending', compact('activities'));
	}

	public function timetable()
	{
		$date = Input::get('date');

		$activities = Activity::makeTimetable(Auth::user(), $date);
		
		$this->layout->content = View::make('activities.instructor.index')->with(compact('activities'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /activities/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$classTypes = $this->classType->all();

		$this->layout->content 	= View::make('activities.create')
									->with(compact('classTypes'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /activities
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = new Services\Validators\Activity;

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withErrors($validation->errors)
			->withInput();
		}

		$clashes = $this->instructor->checkAvailable(Auth::user(), Input::get());

		if( !$clashes->isEmpty() )
		{
			return Redirect::back()
			->withInput()
			->with([
				'error' 		=> 'There has been a clash!',
				'activities' 	=> $clashes
			]);
		}

		$activity = $this->activity->create(Input::except('class_type_id'));

		$this->activity->attachClassTypes($activity);
		
		$this->instructor->spendCredit(Auth::user(), $activity);

		return Redirect::back()
		->with('success', 'Activity added successfully');
	}

	/**
	 * Display the specified resource.
	 * GET /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$activity = $this->activity->find($id);
		$this->layout = View::make('layouts.full');
		$this->layout->content = View::make('activities.show', compact('activity'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /activities/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$activity = $this->activity->find($id);
		$this->layout->content = View::make('activities.edit', compact('activity'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validation = new Services\Validators\Activity;

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withErrors($validation->errors)
			->withInput();
		}

		$activity = $this->activity->find($id);

		$activity = $activity->update(Input::except('class_type_id'));

		$clashes = $this->instructor->checkAvailable(Auth::user(), Input::all());

		if( !$clashes->isEmpty() )
		{
			return Redirect::back()
			->withInput()
			->with([
				'error' 		=> 'There has been a clash!',
				'activities' 	=> $clashes
			]);
		}

		$activity->attachClassTypes($activity);

		return Redirect::back()
		->with('success', 'Activity added successfully');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Attaches a user to an activity
	 * POST /bookActivity
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function book($id)
	{
		$activity = $this->activity->find($id);		

		$clashes = $this->client->checkAvailable(Auth::user(), $activity);

		if( !$clashes->isEmpty() )
		{
			return Redirect::back()
			->with([
				'error' 		=> 'You are already booked into ' . $clashes->first()->name . ' at that time!',
				'activities' 	=> $clashes
			]);
		}

		Auth::user()->attendingActivities()->attach($id);

		$this->activity->reducePlaces($activity);
		
		return Redirect::back()
		->with('success', 'You have successfully booked this activity');
	}

	/**
	 * Displays a list of the users favourites activities
	 * GET /favourites
	 *
	 * @return Response
	 */
	public function favourites()
	{
		$activities = Auth::user()->favourites()->paginate(10);
		$this->layout->content = View::make('activities.client.index')->with(compact('activities'));
	}

	/**
	 * Adds an activity to a users favourites
	 * POST /addFavourite
	 *
	 * @return Response
	 */
	public function addFavourite($id)
	{
		$activity = $this->activity->find($id);
		
		// Add the activity to the users favourites
		Auth::user()->favourites()->attach($id);

		return Response::json([
			'success' 	=> 'Activity added to favourites!',
			'html' 		=> View::make('_partials.elements.removeFavourite')
							->with(compact('activity'))
							->render()
		]);
	}

	/**
	 * Removes an activity from a users favourites
	 * POST /removeFavourite
	 *
	 * @return Response
	 */
	public function removeFavourite($id)
	{
		$activity = $this->activity->find($id);

		// Add the activity to the users favourites
		Auth::user()->favourites()->detach($id);

		return Response::json([
			'success' 	=> 'Activity removed from favourites!',
			'html' 		=> View::make('_partials.elements.addFavourite')
							->with(compact('activity'))
							->render()
		]);
	}

	public function getSearch()
	{
		$activities = Search::execute(Input::all());

		if( Request::ajax() )
		{
			return Response::json([
				'activities' => $activities
			]);
		}

		// Returning the view since we are overriding the layout in the template
		return View::make('activities.search')->with(compact('activities'));
	}

	/**
	 * Searches activities
	 * POST /search
	 *
	 * @return Response
	 */
	public function search()
	{
		$activities = Search::execute(Input::all());

		if( Request::ajax() )
		{
			return Response::json([
				'activities' => $activities
			]);
		}
		else
		{
			$this->layout->content = View::make('activities.client.index')->with(compact('activities'));	
		}
	}

	public function buildPagination(Paginator $paginator)
	{
		
	}

	public function api()
	{
		$activities = Search::execute(Input::all());

		return $activities;
	}

	public function apiFavourites()
	{
		return Auth::user()->favourites;
	}

	public function apiAttending()
	{
		return Auth::user()->attendingActivities;
	}

	public function isFavourite($id)
	{
		$activity = $this->activity->find($id);
		return $this->activity->isFavourite($activity);
	}

	public function isAttending($id)
	{
		$activity = $this->activity->find($id);
		return $this->activity->isAttending($activity);
	}
}