<?php

use Services\Repositories\ActionRepository;
use Services\Interfaces\UploadInterface;

class UsersController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $user;
	protected $action;
	protected $upload;

	public function __construct(User $user, ActionRepository $action, UploadInterface $upload)
	{
		$this->user 	= $user;
		$this->action 	= $action;
		$this->upload 	= $upload;

		// Filter
		$this->beforeFilter('auth', ['except' => ['create', 'store'] ] );
		$this->beforeFilter('exists.user', ['only' => ['show', 'edit', 'update', 'follow', 'avatar', 'suspend', 'unsuspend'] ] );
		$this->beforeFilter('user.favourite', ['only' => ['favourite'] ] );
		$this->beforeFilter('user.notSelf', ['only' => ['favourite', 'follow'] ] );
		$this->beforeFilter('user.follow', ['only' => ['follow'] ] );
		$this->beforeFilter('user.unfollow', ['only' => ['unfollow'] ] );
		$this->beforeFilter('admin', ['only' => ['suspend', 'unsuspend', 'suspended'] ] );
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
		$this->layout->content = View::make('users.client.create');
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

		$user = $user->incrementPageView();
	
		$userType = strtolower(get_class($user->userable));

		// Returning a View instead of using the controller layout since we need a full screen layout
		return View::make('users.' . $userType . '.show')->with(compact('user'));
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
	 * Update the users profile pic
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function avatar($id)
	{
		if( !Input::hasFile('avatar') ) 
		{
			return Redirect::back()
			->with('error', 'Please select an image to upload');
		}

		try
		{
			$user 			= $this->user->find($id);
			$path 			= $this->upload->fire(Input::file('avatar'));
			$user->avatar 	= $path;
			$user->save();

			return Redirect::back()
			->with('success', 'Profile picture successfully updated!');
		}
		catch(Exception $e)
		{
			return Redirect::back()
			->with('error', $e->getMessage());
		}
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
		$user->follow($client);

		// Store the action
		$action = $this->action->create($user, 'followed', $client, 'User');

		return Redirect::back()
		->with(
			'success',
			'You are now following ' . $client->first_name . ' ' . $client->last_name
		);
	}

	/**
	 * Unfollows a client 
	 * GET /unfollow/{id}
	 *
	 * @return Response
	 */
	public function unfollow($id)
	{
		$user 	= Auth::user();
		$client = $this->user->find($id);

		// Follow the user
		$user->unfollow($client);

		return Redirect::back()
		->with(
			'success',
			'You are no longer following ' . $client->first_name . ' ' . $client->last_name
		);
	}

	/**
	 * Suspends a user
	 * GET /users/suspend/{id}
	 *
	 * @return Response
	 */
	public function suspend($id)
	{
		$user = $this->user->find($id);
		$user = $user->suspend();

		return Redirect::back()
		->with(
			'success',
			'You have successfully suspended ' . $user->first_name
		);
	}

	/**
	 * Unsuspends a user
	 * GET /users/unsuspend/{id}
	 *
	 * @return Response
	 */
	public function unsuspend($id)
	{
		$user = $this->user->find($id);
		$user = $user->unsuspend();

		return Redirect::back()
		->with(
			'success',
			'You have successfully unsuspended ' . $user->first_name
		);
	}

	/**
	 * Show all suspended users
	 * GET /users/suspended
	 *
	 * @return Response
	 */
	public function suspended()
	{
		$users = $this->user->suspended();
		$this->layout->content = View::make('users.suspended', compact('users'));
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