<?php namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use App\Events\DuplicateSubscriptionWasRequested;
use Mail;

class SendDuplicateSubscriptionNotification implements ShouldBeQueued {

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
	 * @param  DuplicateSubscriptionWasRequested  $event
	 * @return void
	 */
	public function handle(DuplicateSubscriptionWasRequested $event)
	{
		$subscriber = $event->subscriber;
		$view = 'duplicate';
		$views = [ 
      'emails.'.$view.'_html',
      'emails.'.$view.'_text',
    ];

		Mail::send($views, [], function($message) use ($subscriber) {
			$message->to($subscriber->email, $subscriber->name())->subject('Duplicate subscription!');
		});
	}

}
