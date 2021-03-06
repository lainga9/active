<?php namespace Services\Repositories;

use Services\Interfaces\MailerInterface;
use Exception;

class DefaultMailer implements MailerInterface {

	public function send($recipient, $view, $subject, array $data = null)
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

	public function later($delay, $recipient, $view, $subject, array $data = null)
	{
		$data = $data ? $data : [];

		$message = \Mail::later(
			$delay,
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

	public function scheduleReminder($activity, $recipient)
	{
		$startTime 		= $activity->getStartTime();
		$now 			= strtotime("now");

		$scheduledTime	= $startTime - $now + 3600;

		$reminder = $this->later($scheduledTime, $recipient, 'emails.client.reminder', 'Reminder for ' . $activity->name, ['activity' => $activity->toArray()]);
	}

	public function cancelActivity($activity)
	{
		$attending = $activity->clients;

		if( $attending )
		{
			foreach( $attending as $user )
			{
				$this->send($user, 'emails.blank', 'Activity Cancelled');
			}
		}

		$instructor = $activity->instructor;

		if( $instructor )
		{
			$this->send($instructor, 'emails.blank', 'Confirmation of cancellation');
		}
	}

} 