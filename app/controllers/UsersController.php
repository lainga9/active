<?php

use Services\Repositories\ActionRepository;

class UsersController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $user;
	protected $action;

	public function __construct(User $user, ActionRepository $action)
	{
		$this->user 	= $user;
		$this->action 	= $action;

		// Filter
		$this->beforeFilter('auth', ['except' => ['create', 'store'] ] );
		$this->beforeFilter('exists.user', ['only' => ['show', 'edit', 'update', 'follow'] ] );
		$this->beforeFilter('user.favourite', ['only' => ['favourite'] ] );
		$this->beforeFilter('user.notSelf', ['only' => ['favourite', 'follow'] ] );
	}

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = $this->user->all();

		$this->layout->content = View::make('users.index', compact('users'));
	}

	/**
	 * Shows all people a user is following
	 * GET /user/following/{id}
	 *
	 * @return Response
	 */
	public function following($id = null)
	{
		$user 		= $id ? $this->user->find($id) : Auth::user();
		$following 	= $user->following;

		$this->layout->content = View::make('users.index', ['users' => $following]);
	}

	/**
	 * Shows all people a user is followed by
	 * GET /user/following/{id}
	 *
	 * @return Response
	 */
	public function followers($id = null)
	{
		$user 		= $id ? $this->user->find($id) : Auth::user();
		$followers 	= $user->followers;

		$this->layout->content = View::make('users.index', ['users' => $followers]);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		$validation = new Services\Validators\User;

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withErrors($validation->errors)
			->withInput();
		}

		$user = $this->user->createAccount(
			Input::get('user_type'),
			Input::except('email_confirmation', 'password_confirmation', 'user_type'),
			[]
		);

		return Redirect::route('dashboard')
		->with('success', 'Thanks for signing up!');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id = null)
	{
		$user = $id ? $this->user->find($id) : Auth::user();
	
		$userType = strtolower(get_class($user->userable));

		// Returning a View instead of using the layout since we need a full screen layout
		return View::make('users.' . $userType . '.show')->with(compact('user'));
	}

	public function profile()
	{
		$user = Auth::user();

		$userType = strtolower(get_class($user->userable));

		$this->layout->content = View::make('users.' . $userType . '.show')->with(compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		$user = Auth::user();
		$userType = strtolower(get_class($user->userable));
		$this->layout->content = View::make('users.' . $userType . '.edit')->with(compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validation = new Services\Validators\User(Input::all(), true);

		if( !$validation->passes() )
		{
			return Redirect::back()
			->withErrors($validation->errors)
			->withInput();
		}

		$user = $this->user->find($id);
		if( !$user )
		{
			return Redirect::back()
			->with('error', 'Sorry, the requested user cannot be found');
		}

		$userType = get_class($user->userable);

		$typeAttributes = $userType::$typeAttributes;

		$user->update(Input::only(User::$userAttributes));
		$user->userable->update(Input::only($typeAttributes));

		return Redirect::back()
		->with('success', 'User updated successfully');

	}

	/**
	 * Follows a client as a friend
	 * GET /follow/{id}
	 *
	 * @return Response
	 */
	public function follow($id)
	{
		$user 	= Auth::user();
		$client = $this->user->find($id);

		// Follow the user
		$user->followClient($client);

		// Store the action
		$action = $this->action->create($user, 'followed', $client, 'User');

		return Redirect::back()
		->with(
			'success',
			'You are now following ' . $client->first_name . ' ' . $client->last_name
		);
	}

	/**
	 * Adds an instructor to favourites
	 * GET /favourite/{id}
	 *
	 * @return Response
	 */
	public function favourite($id)
	{
		$user 		= Auth::user();
		$instructor	= $this->user->find($id);

		$user->favouriteInstructor($instructor);

		return Redirect::back()
		->with(
			'success',
			'You have successfully favourited ' . $instructor->name
		);
	}

	/**
	 * Removes all favourites for a user
	 * POST /removeFavourites
	 *
	 * @return Response
	 */
	public function removeFavourites()
	{
		$this->user->removeFavourites();

		return Redirect::back()
		->with(
			'success',
			'All favourites successfully removed'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}