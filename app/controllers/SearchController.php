<?php

class SearchController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $activity;

	public function __construct(Activity $activity)
	{
		$this->activity = $activity;
	}

	/**
	 * Searches activities
	 * get /search/activities
	 *
	 * @return Response
	 */
	public function activities()
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

}