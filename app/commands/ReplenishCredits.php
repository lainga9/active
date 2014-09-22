<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ReplenishCreditsCommand extends Command {

	protected $mailer;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:replenish_credits';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Replenish all users credits to 3';

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
		$instructors = Instructor::all();

		if( !$instructors->isEmpty() )
		{
			foreach( $instructors as $instructor )
			{
				$instructor->replenishCredits();
			}
		}
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
