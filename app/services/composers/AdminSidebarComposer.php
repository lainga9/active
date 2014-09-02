<?php namespace Services\Composers;

class AdminSidebarComposer {

	public function compose($view)
	{
		$links = [
			[
				'name' 	=> 'Suspended',
				'url'	=> \URL::route('users.suspended')
			]
		];


		$view->with(compact('links'));
	}

}