<?php

class FeedbackController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $feedback;
	protected $activity;
	protected $user;

	public function __construct(
		Feedback $feedback, 
		Activity $activity,
		User $user)
	{
		$this->feedback = $feedback;
		$this->activity = $activity;
		$this->user 	= $user;

		// Filters
		$this->beforeFilter('exists.user', ['only' => ['index']]);
	}

	/**
	 * Display a listing of the resource.
	 * GET /feedback
	 *
	 * @return Response
	 */
	public function index($id = null)
	{
		if($id)
		{
			$feedback = $this->feedback->whereInstructorId($id)->get();
		}
		else
		{
			$feedback = $this->feedback->own()->get();
		}

		$this->layout->content = View::make('feedback.index', compact('feedback'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /feedback/create
	 *
	 * @return Response
	 */
	public function create()
	{
		// $this->layout->content = View::make('feedback.create', ['feedback' => $feedback]);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /feedback
	 *
	 * @return Response
	 */
	public function store($activityId)
	{
		// Find the activity the feedback is being left for
		$activity 	= $this->activity->find($activityId);

		// Find the instructor of the activity
		$instructor = $activity->instructor;

		// Create the feedback container
		$feedback = Feedback::create([
			'activity_id' 	=> $activity->id,
			'client_id'		=> Auth::user()->id,
			'instructor_id' => $instructor->id
		]);

		// In the leave feedback form, the fields are created by looping through all of the FeedbackItems. Each of them has a name corresponding to the FeedbackItem->id so we capture an associative array of FeedbackItem->id => value and loop through this to create the actual FeedbackValue items. We have to unset the _token field for the loop to work

		$input = Input::get();
		unset($input['_token']);

		foreach( $input as $id => $value )
		{
			$feedbackValue = FeedbackValue::create([
				'feedback_item_id' 	=> $id,
				'value' 			=> $value,
				'feedback_id'		=> $feedback->id
			]);
		}

		return Redirect::back()
		->with('success', 'Thanks for leaving feedback!');

	}

	/**
	 * Display the specified resource.
	 * GET /feedback/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /feedback/{id}/edit
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
	 * PUT /feedback/{id}
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
	 * DELETE /feedback/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}