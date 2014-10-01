<?php

class DashboardController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $user;

	public function __construct(Activity $activity)
	{
		$this->activity = $activity;
		$this->user 	= Auth::user();
	}

	/**
	 * Display a listing of the resource.
	 * GET /admin
	 *
	 * @return Response
	 */
	public function index()
	{
		if( $this->user->isClient() || $this->user->isAdmin() )
		{
			$activities = $this->activity->future()->orderBy('created_at', 'DESC')->paginate(10);
			$this->layout->content =  View::make('activities.client.index', compact('activities'));
			return;
		}

		if( $this->user->isInstructor() )
		{
			$activities = $this->user->activities;
			$data = [
				'user'			=> $this->user,
				'activities'	=> $activities
			];
			
			return View::make('users.instructor.show', $data);
		}

		// $userType = strtolower(get_class($this->user->userable));
		// $this->layout->content = View::make('dashboard.' . $userType)->with(compact('activities'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /admin/{id}
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
	 * GET /admin/{id}/edit
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
	 * PUT /admin/{id}
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
	 * DELETE /admin/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}