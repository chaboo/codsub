<?php namespace App\Providers;

use App\Events\DuplicateSubscriptionWasRequested;
use App\Events\SubscriptionWasVerified;
use App\Events\SubscriptionWasRequested;

use App\Handlers\Events\SendDuplicateSubscriptionNotification;
use App\Handlers\Events\SendSubscriptionVerificationNotification;
use App\Handlers\Events\SendSubscriptionVerificationRequest;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],

		SubscriptionWasRequested::class => [
			SendSubscriptionVerificationRequest::class,
		],
		SubscriptionWasVerified::class => [
			SendSubscriptionVerificationNotification::class,
		],
		DuplicateSubscriptionWasRequested::class => [
			SendDuplicateSubscriptionNotification::class,
		]		
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}

}
