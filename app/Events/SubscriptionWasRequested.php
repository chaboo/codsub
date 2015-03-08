<?php namespace App\Events;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use App\Subscriber;

class SubscriptionWasRequested extends Event {

	use SerializesModels;

	public $subscriber;
	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Subscriber $subscriber)
	{
		$this->subscriber = $subscriber;
	}

}
