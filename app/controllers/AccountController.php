<?php

use Services\Interfaces\AccountInterface;

class AccountController extends \BaseController {

	protected $layout = 'layouts.main';
	protected $account;
	protected $credit;
	protected $stripe;

	public function __construct(Account $account, Credit $credit, AccountInterface $stripe)
	{
		$this->account 	= $account;
		$this->credit 	= $credit;
		$this->stripe 	= $stripe;
		$this->user 	= Auth::user();
	}

	/**
	 * Display a listing of the resource.
	 * GET /account
	 *
	 * @return Response
	 */
	public function index()
	{
		if( $this->user->isInstructor() )
		{
			$this->layout->content = View::make('account.index', ['user' => $this->user]);
		}
		else
		{
			dd('todo client account');
		}
	}

	public function addCard()
	{
		$this->layout->content = View::make('account.addCard');
	}

	public function goPro()
	{
		// Pass the generated token, an instance of the Credit model and the user to the stripe method in the Account model
		try
		{
			$charge = $this->account->goPro(Input::get('stripeToken'), $this->credit, $this->user);
		}
		catch(Exception $e)
		{
			return Redirect::back()
			->with('error', $e->getMessage());
		}

		return Redirect::back()
		->with('success', 'Welcome to the Pro Plan!');

	}

	public function cancelPro()
	{
		$this->account->cancelPro($this->user);

		return Redirect::back()
		->with(
			'success',
			'You have successfully cancelled your Pro Subscription'
		);
	}

	public function resumePro()
	{
		$this->account->resumePro($this->user);

		return Redirect::back()
		->with(
			'success',
			'You have successfully resumed your Pro Subscription'
		);
	}

	public function makePayment()
	{

	}

}