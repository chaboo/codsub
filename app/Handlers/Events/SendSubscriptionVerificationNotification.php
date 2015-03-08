<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Events\SubscriptionWasVerified;
use Mail;

class SendSubscriptionVerificationNotification implements ShouldBeQueued {

	use InteractsWithQueue;

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  SubscriberWasVerified  $event
	 * @return void
	 */
	public function handle(SubscriptionWasVerified $event)
	{
		$subscriber = $event->subscriber;
		$view = 'verified';
		$views = [
      'emails.'.$view.'_html',
      'emails.'.$view.'_text',
    ];

    Mail::send($views, [], function($message) use ($subscriber) {
			$message->to($subscriber->email, $subscriber->name())->subject('Subscription verified!');
		});
	}

}
