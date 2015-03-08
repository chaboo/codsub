<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Events\SubscriptionWasRequested;
use Mail;

class SendSubscriptionVerificationRequest implements ShouldBeQueued {

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
	 * @param  SubscribtionWasRequested  $event
	 * @return void
	 */
	public function handle(SubscriptionWasRequested $event)
	{
		$subscriber = $event->subscriber;
		$view = 'verify';
		$views = [
      'emails.'.$view.'_html',
      'emails.'.$view.'_text',
    ];

    Mail::send($views, compact('subscriber'), function($message) use ($subscriber) {
			$message->to($subscriber->email, $subscriber->name())->subject('Please verify your subscription!');
		});
	}

}
