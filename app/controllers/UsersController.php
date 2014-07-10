<?php

class UsersController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
		$this->beforeFilter('auth', ['except' => ['create', 'store'] ] );
	}

	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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

		$userType = Input::get('user_type');

		$user = $this->user->createAccount(
			$userType,
			Input::except('email_confirmation', 'password_confirmation', 'user_type'),
			[]
		);

		return Redirect::back()
		->with('success', 'Thanks for signing up!');
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = $this->user->find($id);
		if(!$user)
		{
			return Redirect::back()
			->with('error', 'Sorry we cannot find the user you requested');
		}

		$userType = get_class($user->userable);

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
		$userType = get_class($user->userable);
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