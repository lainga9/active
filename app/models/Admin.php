<?php

class Admin extends \Eloquent {
	protected $guarded = [];

	protected $table = "users_admins";

    public function user()
    {
        return $this->morphOne('User', 'userable');
    }
}