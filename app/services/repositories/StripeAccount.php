<?php namespace Services\Repositories;

use \Stripe_Customer;
use \Stripe_Charge;
use \Stripe_Token;

class StripeAccount implements \Services\Interfaces\AccountInterface {

	protected $customer;
	protected $charge;
	protected $token;

	public function __construct(Stripe_Customer $customer, Stripe_Charge $charge, Stripe_Token $token)
	{
		$this->customer = $customer;
		$this->charge 	= $charge;
		$this->token 	= $token;
	}

	public function createToken($customerId, $accessToken)
	{
		$token = $this->token->create([
			'customer'	=> $customerId
		],
		$accessToken);

		return $token;
	}

	public function createCharge($user, $activity, $token = null)
	{
		if( !$token )
		{
			$customer = $this->customer->retrieve($user->stripe_id);
		}
		else
		{
			$customer = $this->createCustomer($user, $token);
		}

		$token = $this->createToken($customer->id, $activity->instructor->stripe_access_token);

		$charge = $this->charge->create(
			[
				'amount'		=> $activity->stripeCost(),
				'currency'		=> 'gbp',
				'card'			=> $token->id,
				'description'	=> 'Payment for ' . $activity->getName(),
				'metadata'		=> [
					'activity_id'	=> $activity->id
				]
			],
			$activity->instructor->stripe_access_token
		);

		return $charge;
	}

	public function createCustomer($user, $token)
	{
		$customer = $this->customer->create([
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

	public function getAccessToken($code)
	{
		$url = 'https://connect.stripe.com/oauth/token';

		$postFields = [
			'client_secret' => 'sk_test_4QR832L2BoSdqhwKsrNwIBt3',
			'grant_type' 	=> 'authorization_code',
			'client_id' 	=> 'ca_4vqCgoetFXAQtOjNSzpfYK0nIrLt2Uz2',
			'code' 			=> $code,
		];

		$ch = curl_init();

		$options = [
			CURLOPT_URL				=> $url,
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_POST			=> true,
			CURLOPT_POSTFIELDS		=> http_build_query($postFields)
		];

		curl_setopt_array($ch, $options);

		$data = curl_exec($ch);

		curl_close($ch);

		if( $data )
		{
			$data = json_decode($data);
		}

		return $data;
	}
}