<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Events\SubscriptionWasVerified;
use App\Subscriber;

class VerifySubscriptionCommand extends Command implements SelfHandling {

	public $subscriber;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Subscriber $subscriber)
	{
		$this->subscriber = $subscriber;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->subscriber->verified = 1;
		$this->subscriber->verification_token = null;
		$this->subscriber->save();

		\Event::fire(new SubscriptionWasVerified($this->subscriber));
	}

}
