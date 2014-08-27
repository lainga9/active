<?php namespace Services\Repositories;

use Services\Interfaces\MailerInterface;

class DefaultMailer implements MailerInterface {

	public function send(\User $recipient, $view, $subject, array $data = null)
	{
		$data = $data ? $data : [];

		$message = \Mail::send(
			$view,
			$data,
			function($message) use ($recipient, $subject)
		{
			$message->to(
		    	$recipient->email, 
		    	$recipient->first_name
		    )
		   	->subject($subject);
		});
	}

} 