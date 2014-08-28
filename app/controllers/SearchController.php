<?php

class SearchController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $search;
	protected $user;

	public function __construct(Activity $activity, Services\Repositories\DefaultSearch $search, User $user)
	{
		$this->activity = $activity;
		$this->search 	= $search;
		$this->user 	= $user;
	}

	/**
	 * Searches activities
	 * get /search/activities
	 *
	 * @return Response
	 */
	public function activities()
	{
		$activities = $this->search->activities(Input::all());

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

	public function users()
	{
		$users = $this->search->users(Input::all());

		$this->layout->content = View::make('users.search')->with(compact('users'));
	}

}