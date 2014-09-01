<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ActivityReminderEmailCommand extends Command {

	protected $mailer;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:activity_reminder_email';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reminds clients and instructors of a class about to start';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$mailer = new Services\Repositories\DefaultMailer;
		
		$mailer->send(User::find(2), 'emails.blank', 'Testing Command');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
