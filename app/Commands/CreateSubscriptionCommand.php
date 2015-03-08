<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Events\SubscriptionWasRequested;
use App\Subscriber;

class CreateSubscriptionCommand extends Command implements SelfHandling {

	public $first_name;
	public $last_name;
	public $email;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($first_name, $last_name, $email)
	{
		$this->first_name 	= $first_name;
		$this->last_name 	= $last_name;
		$this-> email 			= $email;	
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$subscriber = Subscriber::create([
				'first_name' 					=> $this->first_name,
				'last_name' 					=> $this->last_name,
				'email' 							=> $this->email,
				'verification_token' 	=> str_random(30)
			]);

		\Event::fire(new SubscriptionWasRequested($subscriber));
	}

}
