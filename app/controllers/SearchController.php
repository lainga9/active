<?php

class SearchController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;
	protected $search;
	protected $user;

	public function __construct(Activity $activity, Services\Interfaces\SearchInterface $search, User $user)
	{
		$this->activity = $activity;
		$this->search 	= $search;
		$this->user 	= $user;
	}

	/**
	 * Shows search form
	 * get /search
	 *
	 * @return Response
	 */
	public function get()
	{
		$activities = $this->search->activities(Input::all());

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
				'results' => $activities
			]);
		}
		else
		{
			$this->layout->content = View::make('activities.client.index')->with(compact('activities'));	
		}
	}

	/**
	 * Searches users
	 * get /search/users
	 *
	 * @return Response
	 */
	public function users()
	{
		$users = $this->search->users(Input::all());

		if( Request::ajax() )
		{
			return Response::json([
				'results'	=> $users
			]);
		}

		$this->layout->content = View::make('users.search')->with(compact('users'));
	}

	/**
	 * Searches organisations
	 * get /search/organisations
	 *
	 * @return Response
	 */
	public function organisations()
	{
		$organisations = $this->search->organisations(Input::all());


		if( Request::ajax() )
		{
			return Response::json([
				'results'	=> $organisations
			]);
		}

		$this->layout->content = View::make('users.search')->with(['users' => $organisations]);
	}

}