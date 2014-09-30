<?php namespace Services\Repositories;

use \Stripe_Customer;
use \Stripe_Charge;

class StripeAccount implements \Services\Interfaces\AccountInterface {

	protected $customer;
	protected $charge;

	public function __construct(Stripe_Customer $customer, Stripe_Charge $charge)
	{
		$this->customer = $customer;
		$this->charge 	= $charge;
	}

	public function createCharge($user, $activity, $token = null)
	{
		if( !$token )
		{
			// Check if customer already exists
			if( $user->hasStripeCard() )
			{
				$customer = $this->customer->retrieve($user->stripe_id);

				$charge = $this->charge->create([
					'amount'		=> $activity->stripeCost(),
					'currency'		=> 'gbp',
					'customer'		=> $customer,
					'name'			=> 'iya',
					'description'	=> 'Payment for ' . $activity->getName()
				]);

				return $charge;
			}
		}
		else
		{
			$customer = $this->createCustomer($user, $token);

			$charge = $this->charge->create([
				'amount'		=> $activity->stripeCost(),
				'currency'		=> 'gbp',
				'customer'		=> $customer,
				'description'	=> 'Payment for ' . $activity->getName()
			]);

			return $charge;
		}
	}

	public function createCustomer($user, $token)
	{
		$customer = Stripe_Customer::create([
			'card'	=> $token,
			'email'	=> $user->email
		]);

		$user->stripe_id 	= $customer->id;
		$user->last_four	= $customer->cards->data[0]->last4;
		$user->save();

		return $customer;
	}

	public function getCustomerById($id)
	{
		return $this->customer->retrieve($id);
	}
}