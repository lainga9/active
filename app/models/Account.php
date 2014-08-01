<?php

class Account extends \Eloquent {
	protected $fillable = [];

	public static function goPro($token, $credit, $user)
	{
		try 
		{
			if( $user->subscribed() )
			{
				throw new Exception( 'You are already subscribed to this plan!' );
			}

			$user->subscription('pro')->create($token);
			return $user;
		} 
		catch(Stripe_CardError $e) 
		{
			throw new Exception($e->getMessage());
		}
	}
}