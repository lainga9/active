<?php namespace Services\Interfaces;

interface MailerInterface {

	public function send($recipient, $view, $subject, array $data = null);

	public function later($delay, $recipient, $view, $subject, array $data = null);

}