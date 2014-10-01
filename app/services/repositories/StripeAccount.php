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
					'description'	=> 'Payment for ' . $activity->getName(),
					'metadata'		=> [
						'activity_id'	=> $activity->id
					]
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

	public function getCustomerById($customerId)
	{
		return $this->customer->retrieve($customerId);
	}

	public function getCards($customerId)
	{
		if( !$customerId ) return null;

		$customer = $this->getCustomerById($customerId);

		if( $customer->cards )
		{
			return $customer->cards->data;
		}

		return $customer->cards;
	}

	public function deleteCard($customerId, $cardId)
	{
		if( !$customerId ) return null;

		$customer = $this->getCustomerById($customerId);

		if( $customer )
		{
			$card = $customer->cards->retrieve($cardId);

			if( $card )
			{
				$delete = $customer->cards->retrieve($cardId)->delete();

				return $delete;
			}
		}

		return null;
	}

	public function addCard($customerId, $token)
	{
		if( !$customerId )
		{
			$customer = $this->createCustomer(\	Auth::user(), $token);

			return $customer;
		}
		else
		{
			$customer = $this->getCustomerById($customerId);

			if( $customer )
			{
				$card = $customer->cards->create(["card" => $token]);

				return $card;
			}
		}

		return null;
	}

	public function getChargesByCustomerId($customerId)
	{
		if( !$customerId ) return null;

		$charges = $this->charge->all(['customer' => $customerId]);

		if( $charges )
		{
			return $charges->data;
		}

		return null;
	}

	public function getActivityFromCharge($charge)
	{
		$id = $charge->metadata->activity_id;

		if( $id )
		{
			return \Activity::find($id);
		}

		return null;
	}
}