<?php

class Instructor extends \Eloquent {
	protected $guarded = [];

	public static $typeAttributes = [
		'phone',
		'mobile',
		'postcode',
		'bio',
		'website',
		'facebook',
		'twitter',
		'youtube',
		'google'
	];

	protected $table = "users_instructors";

    public function user()
    {
        return $this->morphOne('User', 'userable');
    }
}