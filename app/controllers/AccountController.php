<?php

class AccountController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $account;
	protected $credit;

	public function __construct(Account $account, Credit $credit)
	{
		$this->account 	= $account;
		$this->credit 	= $credit;

		$this->beforeFilter('instructor');
	}

	/**
	 * Display a listing of the resource.
	 * GET /account
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->layout->content = View::make('account.index');
	}

	public function goPro()
	{
		// Pass the generated token, an instance of the Credit model and the user to the stripe method in the Account model
		try
		{
			$charge = $this->account->goPro(Input::get('stripeToken'), $this->credit, Auth::user()->userable);
		}
		catch(Exception $e)
		{
			return Redirect::back()
			->with('error', $e->getMessage());
		}

		return Redirect::back()
		->with('success', 'Welcome to the Pro Plan!');

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /account
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /account/{id}
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
	 * GET /account/{id}/edit
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
	 * PUT /account/{id}
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
	 * DELETE /account/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}