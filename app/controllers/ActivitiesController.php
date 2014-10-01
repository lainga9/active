<?php

use Services\Interfaces\MailerInterface;
use Services\Interfaces\SearchInterface;
use Services\Interfaces\UploadInterface;
use Services\Interfaces\AccountInterface;
use Services\Repositories\ActionRepository;
use Services\Repositories\ActivityRepository;

class ActivitiesController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $classType;	
	protected $instructor;
	protected $client;
	protected $action;
	protected $mailer;
	protected $search;
	protected $activityRepo;
	protected $upload;
	protected $validator;
	protected $stripe;

	public function __construct(
		Activity $activity, 
		ClassType $classType,
		Instructor $instructor,
		Client $client,
		User $user,
		MailerInterface $mailer,
		ActionRepository $action,
		SearchInterface $search,
		ActivityRepository $activityRepo,
		UploadInterface $upload,
		Services\Validators\Activity $validator,
		AccountInterface $stripe
	)
	{
		$this->activity 	= $activity;
		$this->validator 	= $validator;
		$this->activityRepo	= $activityRepo;
		$this->classType 	= $classType;
		$this->instructor 	= $instructor;
		$this->client 		= $client;
		$this->mailer 		= $mailer;
		$this->action 		= $action;
		$this->search 		= $search;
		$this->upload 		= $upload;
		$this->stripe 		= $stripe;
		$this->user 		= Auth::user();

		/*-------- FILTERS -------*/

		// Checks that the activity exists
		$this->beforeFilter('activity.exists', ['only' => ['show', 'edit', 'update', 'book', 'addFavourite', 'removeFavourite', 'isFavourite', 'isAttending', 'cancel']] );

		// Instructor Only Pages
		$this->beforeFilter('instructor', ['only' => ['create', 'edit', 'store', 'timetable', 'cancel', 'close']] );

		// Client Only Pages
		$this->beforeFilter('client', ['only' => ['attending', 'favourites']] );

		$this->beforeFilter('instructor.hasCredits', ['only' => ['create', 'store']] );
		// Checks the user is not an instructor since they're not allowed to book. Checks that the user isn't already booked in.
		$this->beforeFilter('activity.book', ['only' => ['book']] );

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
		$activities = $this->activity->future()->orderBy('created_at', 'DESC')->paginate(10);

		if( $this->user->isInstructor() )
		{
			$activities = $this->user->activities()->future()->get();
			$passed 	= $this->user->activities()->passed()->get();
		}

		$data = [
			'activities' 	=> $activities,
			'user'			=> $this->user
		];

		if( $this->user->isInstructor() )
		{
			$data['passed'] = $passed;
		}

		$this->layout->content = View::make('activities.' . strtolower(get_class($this->user->userable)) . '.index')->with($data);
	}

	public function attending()
	{
		$activities = $this->user->activities()->future()->get();

		$this->layout->content = View::make('activities.client.attending', compact('activities'));
	}

	public function timetable()
	{
		$date = Input::get('date') ? Input::get('date') : null;

		$activities = $this->user->makeTimetable($this->user, $date);
		
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
		if( !$this->validator->passes() )
		{
			return Redirect::back()
			->withErrors($this->validator->errors)
			->withInput();
		}

		$clashes = $this->instructor->checkAvailable($this->user, Input::get());

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

		$upload = $this->upload->fire(Input::file('avatar'));

		if($upload)
		{
			$activity->avatar = $upload;
			$activity->save();
		}

		$activity->attachClassTypes(Input::get('class_type_id'));
		
		$this->instructor->spendCredit($this->user, $activity);

		try
		{
			$action = $this->action->create($activity->instructor, 'created', $activity, 'Activity');
		}
		catch(Exception $e)
		{
			return Redirect::back()
			->with('error', $e->getMessage());
		}

		return Redirect::route('dashboard')
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

		$clashes = $this->instructor->checkAvailable($this->user, Input::all(), $activity);

		if( !$clashes->isEmpty() )
		{
			return Redirect::back()
			->withInput()
			->with([
				'error' 		=> 'There has been a clash!',
				'activities' 	=> $clashes
			]);
		}

		$update = $activity->update(Input::except('class_type_id', 'avatar'));

		$upload = $this->upload->fire(Input::file('avatar'));

		if($upload)
		{
			$activity->avatar = $upload;
			$activity->save();
		}

		$activity->attachClassTypes(Input::get('class_type_id'));

		return Redirect::back()
		->with('success', 'Activity updated successfully');
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

		$clashes = $this->user->checkAvailable($activity);

		if( !$clashes->isEmpty() )
		{
			return Redirect::back()
			->with([
				'error' 		=> 'You are already booked into ' . $clashes->first()->name . ' at that time!',
				'activities' 	=> $clashes
			]);
		}

		$charge = $this->stripe->createCharge($this->user, $activity, Input::get('stripeToken'));

		$activity->book($this->user);
	
		try
		{
			$action 	= $this->action->create($this->user, 'booked into', $activity, 'Activity');
		}
		catch(Exception $e)
		{
			return Redirect::back()
			->with('error', $e->getMessage());
		}

		$email 		= $this->mailer->send($activity->instructor, 'emails.blank', 'Testing Email');

		$reminder 	= $this->mailer->scheduleReminder($activity, $this->user);
		
		return Redirect::route('activities.show', $activity->id)
		->with('success', 'You have successfully booked this activity');
	}

	/**
	 * Shows the payment for for booking an activity
	 * GET /activity/pay
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function pay($id)
	{
		$activity = $this->activity->find($id);
		
		$this->layout->content = View::make('activities.pay')->with(compact('activity'));
	}

	/**
	 * Allows an instructor to cancel an activity
	 * PUT /cancelActivity
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function cancel($id)
	{
		$activity = $this->activity->find($id);
		$activity = $activity->cancel();
		
		$this->mailer->cancelActivity($activity);

		return Redirect::back()
		->with(
			'success',
			'Activity successfully cancelled'
		);
	}


	/**
	 * Allows an instructor to close an activity
	 * POST /bookActivity
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function close($id)
	{
		$activity = $this->activity->find($id);
		$activity->close();

		return Redirect::back()
		->with(
			'success',
			'Booking has successfully been closed for this activity'
		);
	}

	/**
	 * Displays a list of the users favourites activities
	 * GET /favourites
	 *
	 * @return Response
	 */
	public function favourites()
	{
		$activities = $this->user->favouriteActivities();
		$activities = Paginator::make($activities->all(), count($activities), 10);

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
		$this->user->favourites()->attach($id);

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
		$this->user->favourites()->detach($id);

		return Response::json([
			'success' 	=> 'Activity removed from favourites!',
			'html' 		=> View::make('_partials.elements.addFavourite')
							->with(compact('activity'))
							->render()
		]);
	}

	public function api()
	{
		$activities = $this->search->activities(Input::all());

		return $activities;
	}

	public function apiFavourites()
	{
		return $this->user->favourites;
	}

	public function apiAttending()
	{
		return $this->user->attendingActivities;
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