<?php

class ActivitiesController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $classType;	

	public function __construct(Activity $activity, ClassType $classType)
	{
		$this->activity 	= $activity;
		$this->classType 	= $classType;

		// Filters
		$this->beforeFilter('instructor', ['only' => ['create', 'store']] );
		$this->beforeFilter('client', ['only' => ['attending']] );
		$this->beforeFilter('activity.book', ['only' => ['book']] );
	}

	/**
	 * Display a listing of the resource.
	 * GET /activities
	 *
	 * @return Response
	 */
	public function index()
	{
		$activities = $this->activity->all();

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

		if(strtotime(Input::get('time_from')) >= strtotime(Input::get('time_until')))
		{
			return Redirect::back()
			->with('error', 'Please make sure your class last at least 30 minutes');
		}

		$activity = $this->activity->create(Input::except('class_type_id'));

		// If there are any class types associated with this activity then insert the relationships
		if( $classTypes = Input::get('class_type_id') )
		{
			foreach( $classTypes as $classType )
			{
				$activity->classTypes()->attach($classType);
			}
		}

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

		if( !$activity )
		{
			return Redirect::back()
			->with('error', 'Activity not found!');
		}

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
		//
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
		//
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

		if( !$activity )
		{
			return Redirect::route('admin')
			->with('error', 'Sorry, we can\'t find the activity you requested!');
		}

		if( Auth::user()->attendingActivities->contains($id) )
		{
			return Redirect::back()
			->with('status', 'You are already booked into this class!');
		}

		Auth::user()->attendingActivities()->attach($id);

		// Reduce number of places by 1
		$activity->places = (int) $activity->places - 1;
		$activity->save();
		
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
		$activities = Auth::user()->favourites;
		$this->layout->content = View::make('activities.favourites')->with(compact('activities'));
	}

	/**
	 * Adds an activity to a users favourites
	 * POST /addFavourite
	 *
	 * @return Response
	 */
	public function addFavourite()
	{
		$id = Input::get('id');

		$activity = $this->activity->find($id);
		if( !$activity )
		{
			return Response::json([
				'error' => 'Sorry, we can\'t find the activity you requested!'
			]);
		}

		if( Auth::user()->favourites->contains($id) )
		{
			return Response::json([
				'status' => 'This is already in your favourites!'
			]);
		}

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
	public function removeFavourite()
	{
		$id = Input::get('id');

		$activity = $this->activity->find($id);
		if( !$activity )
		{
			return Response::json([
				'error' => 'Sorry, we can\'t find the activity you requested!'
			]);
		}

		if( !Auth::user()->favourites->contains($id) )
		{
			return Response::json([
				'status' => 'This activity is not in your favourites!'
			]);
		}

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
		$activities = $this->activity->all();
		$this->layout->content = View::make('activities.search')->with(compact('activities'));
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

	public function api()
	{
		$activities = Search::execute(Input::all());

		return $activities;
	}
}