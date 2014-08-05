<?php

class FeedbackController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $feedback;
	protected $feedbackValue;
	protected $instructor;
	protected $user;

	public function __construct(
		Feedback $feedback,
		FeedbackValue $feedbackValue,
		Instructor $instructor,
		Activity $activity,
		User $user)
	{
		$this->feedback 		= $feedback;
		$this->feedbackValue 	= $feedbackValue;
		$this->instructor 		= $instructor;
		$this->user 			= $user;
		$this->activity 		= $activity;
		// Filters
		$this->beforeFilter('exists.user', ['only' => ['index']]);
		$this->beforeFilter('exists.activity', ['only' => ['store']]);
		$this->beforeFilter('client', ['only' => ['store']]);
		$this->beforeFilter('instructor', ['only' => ['index']]);
		$this->beforeFilter('feedback.store', ['only' => ['store']]);
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
	public function store($instructorId)
	{
		// Find the activity the feedback is being left for
		$instructor = $this->user->find($instructorId);

		$activity = $this->activity->find(Input::get('activity_id'));

		if($activity)
		{
			$this->feedback->store($this->feedback, $this->feedbackValue, $activity, $instructor, Auth::user(), Input::get());

			return Redirect::back()
			->with('success', 'Thanks for leaving feedback!');
		}

		return Redirect::back()
		->with('error', 'Error finding activity');
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