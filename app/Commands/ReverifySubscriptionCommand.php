<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Events\SubscriptionWasRequested;
use App\Subscriber;

class ReverifySubscriptionCommand extends Command implements SelfHandling {

	public $email;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($email)
	{
		$this->email = $email;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$subscriber = Subscriber::whereEmail($this->email)->first();

		if ($subscriber) {
			$subscriber->verification_token = str_random(30);
			$subscriber->save();

			\Event::fire(new SubscriptionWasRequested($subscriber));
		}
	}

}
