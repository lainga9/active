<?php

class Client extends \Eloquent {
	protected $guarded = [];

	public static $typeAttributes = [
		'twitter',
		'youtube',
		'facebook',
		'website',
		'instagram',
		'bio'
	];

	protected $table = "users_clients";

    public function user()
    {
        return $this->morphOne('User', 'userable');
    }
}