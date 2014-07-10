<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		User::createAccount(
			'Admin',
			[
				'email' 	=> 'glasgoweb@gmail.com', 
				'password' 	=> 'Gr4k0103',
				'role_id' 	=> 3
			],
			[]
    	);

	}

}