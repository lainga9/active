<?php namespace Services\Interfaces;

interface MailerInterface {

	public function send(\User $recipient, $view, $subject, array $data = null);

}