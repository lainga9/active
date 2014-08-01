<?php

class DashboardController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;

	public function __construct(Activity $activity)
	{
		$this->activity = $activity;
	}

	/**
	 * Display a listing of the resource.
	 * GET /admin
	 *
	 * @return Response
	 */
	public function index()
	{
		if( User::isClient() )
		{
			$activities = $this->activity->paginate(10);
		}

		if( User::isInstructor() )
		{
			$activities = Auth::user()->activities;
		}

		$userType = get_class(Auth::user()->userable);
		$this->layout->content = View::make('dashboard.' . $userType)->with(compact('activities'));
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